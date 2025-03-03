# Projet d'étude Symfony avancé - BackOffice d'entreprise 

Dans le cadre de l'UE `R6.A.05 - Dev Avancée`, dirigée par [Laurine Poinsignon](https://github.com/Laurine27), j'ai développé cette application de BackOffice pour une entreprise fictive de gestion de clients et de produits.

Les fonctionnalités explorées sont les suivantes :
- **Voters** : Utilisation des voters pour restreindre l'accès aux différentes fonctionnalités de l'application selon les rôles **USER**, **MANAGER** et **ADMIN**.
- **Traits** : Utilisation des traits pour factoriser l'implémentation de certaines `column` des entités Doctrine (Ex : `CreatedAt` et `UpdatedAt`).
- **FileSystem** : Utilisation du `FileSystem` pour manipuler les fichiers et implémenter des fonctionnalités d'import et d'export de la liste des produits.
- **Commands** : Implémentation d'une commande permettant de créer un client par indice de commande (Ex : `php bin/console app:client:create`).
- **Services** : Utilisation des services pour factoriser la logique utilisée dans les commandes.
- **Unit tests** : Mise en place de tests unitaires pour le service lié à l'entité Utilisateur (`UserServiceTest`).

L'intégralité des produits et de leurs informations présents dans les fixtures a été récupérée sur le site [maxesport.gg](https://maxesport.gg).

## Difficultés rencontrées

Pour une raison inconnue, après avoir testé plusieurs variantes d'implémentation, consulté la documentation et des forums (Stack Overflow) et m'être aidé d'IA… Je n'ai pas réussi à afficher les erreurs des formulaires. Par exemple, lors d'une mauvaise saisie du prix pour la création/modification d'articles, la requête n'est pas validée, l'erreur peut être `dump` dans le form, mais l'interface graphique ne les affiche pas.

## Utilisation

Une fois les fixtures chargées, vous pourrez vous connecter avec les utilisateurs renseignés dans le fichier [UserFixtures.php](./src/DataFixtures/UserFixtures.php), dont les utilisateurs principaux peuvent s'identifier avec :

- **Utilisateur lambda** :
  ```text
  john.doe@example.com
  password123
  ```

- **Utilisateur MANAGER** :
  ```text
  manager@example.com
  managerpassword
  ```

- **Utilisateur ADMIN** :
  ```text
  admin@example.com
  adminpassword
  ```

## Stack technique

- PHP 8.2
- Symfony 7.1
- MySQL
- Tailwind

## Initialisation de votre IDE

### PHPStorm

1. Ouvrir le projet dans PHPStorm
2. Installer les extensions Twig et Symfony
    - Aller dans File > Settings > Plugins
    - Installer les extensions (Twig, EA Inspection, PHP Annotations, .env files support)

### Visual Studio Code

1. Ouvrir le projet dans Visual Studio Code
2. Installer les extensions pour PHP, Twig et Symfony
    - Aller dans l'onglet Extensions
    - Installer les extensions (whatwedo.twig, TheNouillet.symfony-vscode, DEVSENSE.phptools-vscode, 
    bmewburn.vscode-intelephense-client, zobo.php-intellisense)

## Installation en local

1. Cloner le projet
2. Installer PHP >= 8.2 et Composer (Sur votre machine utiliser XAMPP pour windows, MAMP pour mac ou LAMP pour linux bien prendre la version PHP 8.2)
3. Installer les dépendances du projet avec la commande `composer install`
4. Utiliser de CLI `symfony` pour démarer le projet avec la commande `symfony server:start`. 
   Ou faire un virtual host sur votre serveur local (XAMPP par exemple pour Windows) 
 - Ouvrir le fichier `httpd-vhosts.conf` dans le répertoire `C:\xampp\apache\conf\extra`
    - Ajouter le code suivant à la fin du fichier
    ```
    <VirtualHost *>
        DocumentRoot "C:\Users\votre_username\Documents\iut\symfony_base\public"
        ServerName symfony_base.local
        
        <Directory "C:\Users\votre_username\Documents\iut\symfony_base\public">
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    ```
    - Ajouter l'adresse IP de votre machine dans le fichier `C:\Windows\System32\drivers\etc\hosts`
    ```
    127.0.0.1 symfony_base.local
    ```
    - Redémarrer Apache
    - Accéder à l'adresse `symfony_base.local` dans votre navigateur

5. Créer un fichier `.env.local` à la racine du projet et ajouter la configuration de la base de données
6. Créer la base de données avec la commande `php bin/console doctrine:database:create`
7. Exécuter les migrations avec la commande `php bin/console doctrine:migrations:migrate`
8. Charger les données de test avec la commande `php bin/console doctrine:fixtures:load`

## Utilisation

- N'hésitez pas à consulter la documentation de Symfony pour plus d'informations sur l'utilisation du framework : https://symfony.com/doc/current/index.html

- Notez comment fonctionne votre projet dans le fichier README.md et mettez à jour ce fichier au fur et à mesure de l'avancement de votre projet pour aider les autres développeurs à comprendre comment fonctionne votre projet.
