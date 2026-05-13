# M.E.SI Platform — Mission Évangélique Sion

Plateforme web officielle de la Mission Évangélique Sion (M.E.SI), construite avec Laravel 12.

---

## Stack technique

- **Backend** : Laravel 12, PHP 8.2+
- **Frontend** : Tailwind CSS 3, Alpine.js, Vite
- **Base de données** : MySQL
- **Auth** : Laravel Breeze

---

## Installation

### Prérequis
- PHP 8.2+ (XAMPP recommandé)
- Composer
- Node.js & npm
- MySQL

### Étapes

```bash
# 1. Cloner le dépôt
git clone https://github.com/Angemm/mesi-platform.git
cd mesi-platform

# 2. Installer les dépendances PHP
composer install --prefer-source --no-interaction

# 3. Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
# DB_DATABASE=mesi-platform
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Créer la base de données dans phpMyAdmin puis migrer
php artisan migrate --force
php artisan db:seed --force

# 6. Installer les dépendances front
npm install
npm run build

# 7. Lancer le projet
php artisan serve
```

> **Note** : Si tu rencontres un timeout PHP (max 30s), modifie `max_execution_time = 120` dans `C:\xampp\php\php.ini` et relance le serveur.

---

## Lancer en développement

Dans deux terminaux séparés :

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Accès : `http://127.0.0.1:8000`

---

## Accès administration

L'interface d'administration n'est pas accessible via un bouton sur le site public.

Pour y accéder : `http://127.0.0.1:8000/admin`

Identifiants par défaut (à changer en production) :
- **Email** : `admin@mesi.org`
- **Mot de passe** : `Admin@MESI2024!`

---

## Structure du projet

```
app/
├── Http/Controllers/        # Contrôleurs publics
│   └── Admin/               # Contrôleurs administration
├── Models/                  # Modèles Eloquent
resources/
├── views/
│   ├── layouts/             # Layouts (app.blade.php, admin.blade.php)
│   ├── front/               # Pages publiques (home)
│   ├── eglise/              # Pages Église
│   ├── admin/               # Vues administration
│   └── ...
routes/
├── web.php                  # Routes principales
└── auth.php                 # Routes authentification
```

---

## Fonctionnalités

**Site public**
- Page d'accueil avec hero, verset du jour, cultes, actualités, missions, événements, dons
- Pages Église (histoire, vision, pasteurs, départements)
- Cultes & Live (replay YouTube)
- Actualités avec catégories
- Missions avec suivi des dons
- Sermons (audio, vidéo, PDF)
- Formulaire de contact avec sujet dynamique
- Newsletter
- Page de don

**Administration**
- Dashboard avec statistiques
- Gestion cultes, actualités, missions, sermons, événements
- Gestion membres et départements
- Suivi des dons
- Messages de contact
- Newsletter (export CSV, envoi groupé)
- Horaires des cultes
- Verset du jour
- Paramètres généraux

---

## Branches

| Branche | Description |
|---|---|
| `main` | Production stable |
| `dev-eliphaz` | Développement actif |

---

## Licence

Projet privé — Mission Évangélique Sion © {{ date('Y') }}
