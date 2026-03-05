<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

define('PASSWORD', 'Responsable008');
define('DATA_DIR', __DIR__ . '/lcl_data');

// Créer le dossier de données s'il n'existe pas
if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
}

function getUserFile($username) {
    return DATA_DIR . '/' . $username . '.txt';
}

function loadUserData($username) {
    $userFile = getUserFile($username);
    
    if (file_exists($userFile)) {
        $content = file_get_contents($userFile);
        if (!empty($content)) {
            return json_decode($content, true);
        }
    }
    
    // Premier login - créer le compte avec 1,500,000 €
    $userData = [
        'username' => $username,
        'balance' => 1500000,
        'transactions' => []
    ];
    
    saveUserData($username, $userData);
    return $userData;
}

function saveUserData($username, $data) {
    $userFile = getUserFile($username);
    file_put_contents($userFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Déterminer l'action
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login':
        handleLogin();
        break;
    
    case 'balance':
        handleGetBalance();
        break;
    
    case 'transaction':
        handleTransaction();
        break;
    
    default:
        echo json_encode(['error' => 'Action non valide']);
        break;
}

function handleLogin() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    
    if (empty($username)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Nom d\'utilisateur requis']);
        return;
    }
    
    if ($password !== PASSWORD) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Mot de passe incorrect']);
        return;
    }
    
    $userData = loadUserData($username);
    echo json_encode(['success' => true, 'user' => $userData]);
}

function handleGetBalance() {
    $username = $_GET['username'] ?? '';
    
    if (empty($username)) {
        http_response_code(400);
        echo json_encode(['error' => 'Nom d\'utilisateur requis']);
        return;
    }
    
    $userData = loadUserData($username);
    echo json_encode([
        'balance' => $userData['balance'],
        'transactions' => $userData['transactions']
    ]);
}

function handleTransaction() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $username = $input['username'] ?? '';
    $recipient = $input['recipient'] ?? '';
    $amount = floatval($input['amount'] ?? 0);
    
    $userData = loadUserData($username);
    
    if ($amount > $userData['balance']) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Solde insuffisant']);
        return;
    }
    
    $transactionDate = new DateTime();
    $returnDate = (clone $transactionDate)->add(new DateInterval('P3D'));
    
    $transaction = [
        'amount' => $amount,
        'from' => $username,
        'to' => $recipient,
        'date' => $transactionDate->format('d/m/Y'),
        'returnDate' => $returnDate->format('d/m/Y'),
        'timestamp' => $transactionDate->getTimestamp()
    ];
    
    $userData['balance'] -= $amount;
    $userData['transactions'][] = $transaction;
    
    saveUserData($username, $userData);
    
    echo json_encode([
        'success' => true,
        'balance' => $userData['balance'],
        'transactions' => $userData['transactions']
    ]);
}
?>
