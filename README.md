# Installation du projet

## 1. Clonage du dépôt git :

```
git clone https://github.com/elanglet/formation-symfony-monjournal.git
```

## 2. Installation des dépendances 

```
composer install
```

## 3. Base de données

- Créer la base de données
- Modifier la valeur de `DATABASE_URL` dans le fichier `.env`

```
php bin/console doctrine:schema:update --force
```

## 4. Démarrer le serveur de développement

- Démarrer le serveur et commencer à utiliser et à modifier l'application

```
symfony server:start
```
