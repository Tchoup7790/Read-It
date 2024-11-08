# Read-It

## Description  
Application utilisant le modèle **MVC** pour la gestion des utilisateurs, articles et commentaires, avec un front-end stylisé avec **PicoCSS**.  
Les fonctionnalités incluent :  
- **Gestion des utilisateurs** : création, connexion, modification du profil.  
- **Gestion des articles** : création, modification, consultation.  
- **Base de données MySQL** pour stocker utilisateurs, articles et commentaires.

### Technologies  
- **PHP**
- **MySQL**  
- **PicoCSS**  
- **PDO** pour la gestion des connexions à la base de données

---

## Structure du projet  

```
/ (racine du projet)
├── index.php        # Point d'entrée
├── router.php       # Routeur
├── /database        # Configuration de la base de données
└── /app
    ├── /controllers # Logique métier
    ├── /models      # Modèles de données
    ├── /views       # Vues
    ├── /dao         # Accès aux données (DAO)
    └── /verificator # Validation des données utilisateur
```

---

## Installation

1. **Cloner le projet**  
   ```bash
   git clone https://github.com/Tchoup7790/Read-It.git
   cd Read-It
   ```

2. **Créer la base de données**  
   Créez la base de données MySQL et les tables via le fichier SQL dans le dossier :  
   ```
    / (racine du projet)
    └── /database
        └── create_table.sql
   ```

3. **Configurer la base de données**  
   Dans `index.php`, configurez la connexion à votre base de données.
   ```php
    // mise en place de la session et de la db
    $db_host = "localhost";
    $db_name = "read_it_prod";
    $db_test_name = "read_it_test";
    $db_username = "root";
    $db_password = "root";
   ```

---

## Lancer l'application

1. **Démarrer MySQL** et vérifier que la base de données est prête.
2. **Lancer le serveur PHP** :
   ```bash
   php -S localhost:8000
   ```
3. **Accéder à l'application** via :  
   [http://localhost:8000](http://localhost:8000)

---

## Fonctionnalités à venir
- Gestion des commentaires dans le front-end
- Recherche des articles
- création d'un compte administrateur
- Tests unitaires et validation avancée

---

## Auteurs
- [Tchoup7790](https://github.com/Tchoup7790)

---

## Licence  
Projet sous licence MIT - voir le fichier [LICENSE](LICENSE).
