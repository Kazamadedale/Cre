# 🏦 LCL - Site Bancaire pour InfinityFree

## 📦 Fichiers à télécharger

Tous les fichiers sont prêts pour être uploadés sur **InfinityFree** (ou n'importe quel hébergeur PHP gratuit).

### Structure des fichiers :
```
ton-site/
├── index.html          (Page principale)
├── api.php             (API Backend PHP)
├── .htaccess           (Configuration Apache)
└── lcl_data/           (Créé automatiquement - stocke les fichiers TXT)
```

## 🚀 Installation sur InfinityFree

### Étape 1 : Créer un compte InfinityFree
1. Va sur **https://infinityfree.net**
2. Crée un compte gratuit
3. Crée un nouveau site web

### Étape 2 : Uploader les fichiers
1. Connecte-toi au **File Manager** ou utilise **FileZilla (FTP)**
2. Va dans le dossier `htdocs/` ou `public_html/`
3. Upload ces 3 fichiers :
   - `index.html`
   - `api.php`
   - `.htaccess`

### Étape 3 : Créer le dossier lcl_data
1. Dans le File Manager, crée un nouveau dossier nommé `lcl_data`
2. Change les permissions à **755** (lecture/écriture/exécution)

### Étape 4 : Tester ton site
1. Accède à ton site : `http://tonsite.infinityfree.net`
2. Connecte-toi avec n'importe quel nom d'utilisateur
3. Mot de passe : `Responsable008`

## 🔐 Sécurité

✅ Le dossier `lcl_data/` est protégé par `.htaccess`
✅ Personne ne peut accéder directement aux fichiers TXT
✅ Seul l'API PHP peut lire/écrire les données

## 💰 Fonctionnalités

✅ **Premier login** : Solde automatique de 1 500 000 €
✅ **Fichiers TXT** : Chaque utilisateur a son fichier `username.txt`
✅ **Synchronisation** : Accessible depuis tous les appareils
✅ **Historique** : Transactions avec dates de retour (+3 jours)
✅ **4 opérations** : Envoyer, Retirer, Payer, Virement

## 📁 Exemple de fichier utilisateur (jean.txt)

```json
{
  "username": "jean",
  "balance": 1450000,
  "transactions": [
    {
      "amount": 50000,
      "from": "jean",
      "to": "Marie",
      "date": "24/01/2026",
      "returnDate": "27/01/2026",
      "timestamp": 1737723456
    }
  ]
}
```

## 🌐 Accès multi-appareils

Une fois hébergé sur InfinityFree, ton site est accessible depuis :
- 📱 Téléphone
- 💻 Ordinateur
- 📲 Tablette
- 🌍 N'importe où dans le monde !

Tous les appareils partagent les mêmes données stockées dans les fichiers TXT sur le serveur.

## ⚠️ Important

- InfinityFree peut avoir des limites (300 requêtes/heure)
- Si tu veux plus de performance, considère un hébergement payant
- Assure-toi que le dossier `lcl_data/` a les bonnes permissions (755)

## 🎯 URL finale

Ton site sera accessible à : `http://tonsite.infinityfree.net`

(Remplace "tonsite" par le nom que tu as choisi lors de la création)

## 💡 Conseils

- Teste d'abord en local si tu veux
- Vérifie que PHP est activé (InfinityFree l'active par défaut)
- Les fichiers TXT sont créés automatiquement au premier login
