# 🛍️ Symfony

Projet Symfony permettant la gestion de produits, d'utilisateurs et de notifications.

---
## 📦 Installation

```
git clone https://github.com/Elyn03/symfony-shop.git
```
```
composer install
```
```
php bin/console doctrine:database:create
```
```
php bin/console doctrine:migrations:migrate
```
```
php bin/console doctrine:fixtures:load
```
## 📦 Démarrer le serveur
```
symfony server:start
```
---
## ⚙️ .ENV

```
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/final_project_courses"
```
---
## 🧩 Fonctionnalités principales

### 🎯 Utilisateur (ROLE_USER)

- Voir la **liste des produits**
- Voir la **page détail** d’un produit
- **Acheter** un produit si suffisamment de points
- **Modifier** ses informations personnelles (nom, prénom)
- Si désactivé :
    - Ne peut pas acheter
    - Voit un **message d’avertissement**

### 🛠️ Administrateur (ROLE_ADMIN)

- **Ajouter / Modifier / Supprimer** un produit
- **Désactiver un utilisateur**
- **Recevoir une notification** :
    - Lors de la création, modification ou suppression d’un produit
    - Lorsqu’un utilisateur effectue un achat
- **Ajouter 1000 points** à tous les utilisateurs actifs (via Messenger)
