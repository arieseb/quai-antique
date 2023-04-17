# Le Quai Antique - ECF Développeur Web et Web Mobile

## Procédure d'installation de l'application en local

### 1 - Installer et configurer XAMPP
 - Se rendre sur [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
et installer la dernière version compatible avec le système d'exploitation et au minimum PHP 8.1
 - Créer le dossier `apps` à la racine du dossier d'installation de XAMPP
   (`C:/xampp`)
   - Ouvrir le fichier `C:/xampp/apache/conf/extra/httpd-vhost.conf`
     - Ajouter les lignes ci-dessous à la fin du fichier :

           <VirtualHost *:80>
                ServerName quai-antique.localhost

                DocumentRoot "C:/xampp/apps/quai-antique/public"
                DirectoryIndex index.php

                <Directory "C:/xampp/apps/quai-antique/public">
                    Require all granted

                    FallbackResource /index.php
                </Directory>
            </VirtualHost>

 - Démarrer les modules Apache et MySQL

### 2 - Installer Git
 - Se rendre sur [https://git-scm.com/downloads](https://git-scm.com/downloads) et installer 
la dernière version de Git compatible avec le système d'exploitation

### 3 - Cloner l'application
 - Ouvrir un terminal et saisir la commande `cd c:/xampp/apps`
 - Saisir la commande `git clone https://github.com/arieseb/quai-antique.git`

### 4 - Configurer le fichier .env
 - À la racine du projet, ouvrir le fichier `.env`
 - Changer le paramètre `APP_ENV` à `prod`
 - Ajouter à la fin du fichier la ligne suivante : `DATABASE_URL="mysql://root@127.0.0.1:3306/quai-antique"`

### 5 - Installer les dépendances
 - Composer
   - Se rendre sur [https://getcomposer.org/download/](https://getcomposer.org/download/)
   et suivre les instructions d'installation
   - Exécuter la commande ``composer install``
 - Node.js et NPM
   - Se rendre sur [https://nodejs.org/en/download](https://nodejs.org/en/download) et installer la version LTS
   compatible avec le système d'exploitation
   - Exécuter la commande ``npm i``

### 6 - Initialiser la base de données
 - Exécuter la commande suivante pour créer la base de données ``php bin/console doctrine:create:database --if-not-exists``
 - Créer ensuite une migration ``php bin/console make:migration``
 - Exécuter ensuite ``php bin/console doctrine:migration:migrate``

### 7 - Peupler la base de données
 - Exécuter la commande suivante ``cd c:/xampp/apps/quai-antique/database``
 - Exécuter ensuite ``mysql -u root quai-antique < install.sql``

### 8 - Vous pouvez désormais vous connecter à l'application à l'adresse ``quai-antique.localhost``
Le restaurant et un compte administrateur ont été automatiquement créés en base de données
par l'application  
Les informations de connexion au compte administrateur sont renseignés dans la copie

### 9 - Ajouter les images du carrousel 
 - Se connecter en tant qu'administrateur et se rendre dans le panneau d'administration
 - Cliquer sur le bouton "Gestion des images du carrousel"
 - Ajouter les images se trouvant dans le dossier ``C:/xampp/apps/quai-antique/img`` à l'aide du formulaire

### L'application est désormais installée en local sur votre poste

