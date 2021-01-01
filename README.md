**Projet 7 : Créer un webservice exposant une API**


Création d'un API REST pour la société BileMo, une entreprise fictive de vente de téléphone portable.

**Environnement de développement**

* Symfony 4.4
* Apache 2.4.37
* PHP 7.3
* MySQL 5.7
    
**Informations sur l'API**

* le token nécessaire pour s'identifier sur l'API s'obtient par l'envoie des identifiants sur l'URI /login_check.

* Les requêtes "GET" sont uniquement accessibles aux utilisateurs authentifié.

* Les autres requêtes "POST" / "DELETE" ne sont possible que pour les utilisateurs possédant le rôle ROLE_ADMIN.

**Installation**

1. Clonez ou téléchargez le repository Github dans le dossier voulu : 

    git clone https://github.com/Fatah59/projet7_BileMoAPI.git
 
2. Configurez les variables d'environnement nécessaire à la connexion à la base de donnnées en créeant un fichier .env.local 
 
3. Téléchargez et installez les dépendances du projet avec la commande : 
 
    `composer install`
    
4. Créez la base de données, si elle n'existe pas déjà, en se plaçant dans le répertoire du projet avec la commande : 

    `php bin/console doctrine:database:create`

5. Créez les tables de la base de données via les migrations avec les commandes :

    `php bin/console make:migration` 
    
    `php bin/console doctrine:migrations:migrate`

6. Modifier la passphrase à la ligne JWT_PASSPHRASE du fichier .env puis déplacez cette information dans votre fichier .env.local. Ensuite, générez les clées SSH (<a href="https://slproweb.com/products/Win32OpenSSL.html" rel="nofollow">Solution pour OpenSSL sur Windows</a>) avec les commandes suivantes : 

    `$ mkdir -p config/jwt` 
    
    `$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096`
    
    `$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`

7. Si besoin, installez les fixtures afin de charger une série de données fictives en base de données.

8. Félictations le projet est installé correctement, vous pouvez commencer à l'utiliser !