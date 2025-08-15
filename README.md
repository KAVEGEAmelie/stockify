# Système de Gestion de Stock Laravel

Une application web complète de gestion de stock développée avec Laravel 11.

## Fonctionnalités

- 📦 **Gestion des Produits** : Créer, modifier, supprimer et visualiser les produits
- 🏷️ **Gestion des Catégories** : Organiser les produits par catégories
- 🏢 **Gestion des Fournisseurs** : Gérer les informations des fournisseurs
- 📊 **Mouvements de Stock** : Suivre les entrées, sorties et ajustements de stock
- 🚨 **Alertes Stock Faible** : Notifications automatiques pour les stocks bas
- 📈 **Dashboard** : Vue d'ensemble avec statistiques et graphiques

## Structure des Entités

### Produits
- Nom, SKU, description
- Prix de vente et prix de revient
- Quantité en stock et niveau minimum
- Catégorie et fournisseur associés
- Unité de mesure

### Catégories
- Nom et description
- Statut actif/inactif

### Fournisseurs
- Informations de contact complètes
- Personne de contact
- Statut actif/inactif

### Mouvements de Stock
- Type : Entrée, Sortie, Ajustement
- Quantité et stocks avant/après
- Référence et notes
- Horodatage et utilisateur

## Installation

1. Cloner le repository
```bash
git clone <repository-url>
cd stock-management
```

2. Installer les dépendances
```bash
composer install
npm install
```

3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données dans `.env`
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

5. Exécuter les migrations
```bash
php artisan migrate
```

6. (Optionnel) Peupler avec des données de test
```bash
php artisan db:seed
```

7. Lancer le serveur de développement
```bash
php artisan serve
```

## Technologies Utilisées

- **Backend** : Laravel 11, PHP 8.2+
- **Frontend** : Bootstrap 5, Bootstrap Icons
- **Base de données** : SQLite (configurable pour MySQL/PostgreSQL)
- **Authentification** : Laravel Breeze (à configurer si nécessaire)

## Routes Principales

- `/` - Dashboard principal
- `/products` - Gestion des produits
- `/categories` - Gestion des catégories
- `/suppliers` - Gestion des fournisseurs
- `/stock-movements` - Historique des mouvements

## Développement

### Ajouter une nouvelle fonctionnalité

1. Créer un modèle et migration
```bash
php artisan make:model MonModele -m
```

2. Créer un contrôleur
```bash
php artisan make:controller MonController --resource
```

3. Ajouter les routes dans `routes/web.php`

### Tests

```bash
php artisan test
```

## Licence

Ce projet est open-source sous licence MIT.
