# banque-securisee

Créneau de TD: Lundi 10:15 - 13:15

Group1: Nguyen Tran Khanh Linh & LYU Jiawen

## Configuration de base de donnée

Toutes les requêtes SQL ont été stockées dans le fichier, vous pouvez l'exécuter dans la console de phpmyadmin.

## Chiffrement de mot de passe

1. Pour chiffrer mot de passe et le stocker dans la BD

   Aller https://www.jdoodle.com/php-online-editor/ pour générer hashedPwd avec la fonction 

   ```php
   <?php
   echo password_hash("<mot_de_passe>", PASSWORD_DEFAULT);
   ?>
   ```

2. Changer votre `mot_de_passe` correspondant dans la BD avec phpmyadmin

## .htaccess

### Activer l'override de .htaccess dans MAMP

1. Aller au fichier `httpd.conf`

```bash
vim /Applications/MAMP/conf/apache/httpd.conf
```

2. Trouver ce bloc là

```
<Directory />
    Options Indexes FollowSymLinks
    AllowOverride None
</Directory>
```

3. Replacer `None` par `All`
4. Redémarrer le serveur

### Contrôle d'access de dossier config

https://www.whoishostingthis.com/resources/htaccess/

1. Créer le fichier de `.htpasswd` (chaque personne)

   ```bash
   htpasswd -c /usr/local/etc/.htpasswd sr03
   ##mot de passe: sr03
   ```

2. Créer le fichier de `.htaccess` dans `/banque-securisee/config`(déjà fait)

   ```
   AuthUserFile /usr/local/etc/.htpasswd
   AuthName "sr03"
   AuthType Basic
   <Limit GET POST>
   require user sr03
   </Limit>
   ```

## Installation de Composer

Mac OS X

```bash
brew install composer
##dans le projet php
#D'abord créer un fichier composer.json (déjà créé) et puis 
composer install
```

## Configuration de HTTPS

#### Côté serveur

1. Générer la clé privée au côté serveur et l'envoyer au serveur de CA pour signer

   ```bash
   #Dans la machine de serveur, générer la clé privé en utilisant openssl et chosir une algorithme pertinent(ici on choisit DES3 et le longeur de la clé est 2048bits)
   openssl genrsa -out server.key -des3 2048
   #générer un fichier csr et l'envoyer au serveur CA pour générer le certificat de serveur
   openssl req -new -key server.key -out server.csr
   ```
   
2. Modifier la configuration de l'Apache pour le mode SSL

   ```bash
sr03@sr03:~$ sudo vim /etc/apache2/sites-available/000-default.conf
   <IfModule mod_ssl.c>
           <VirtualHost *:443>
                   ServerName sr03.utc
   								...
                   SSLEngine on
                   SSLCertificateFile /etc/ssl/certs/sr03.utc.crt
                   SSLCertificateKeyFile /etc/ssl/private/server.key
                   SSLCertificateChainFile /etc/ssl/certs/servercertchain.cert.pem
                   SSLCACertificateFile /etc/ssl/certs/clientcertchain.cert.pem
                   SSLVerifyClient require
                   SSLVerifyDepth 3
           </VirtualHost>
   </IfModule>
   
   ##créer un fichier pour redirection
   sr03@sr03:~$ sudo vim /etc/apache2/sites-available/000-default_redirect.conf 
   <VirtualHost *:80>
           ServerName sr03.utc
           ServerAdmin webmaster@localhost
           Redirect / https://sr03.utc/
   </VirtualHost>
   
   ## activer le mode ssl
   sudo a2enmod ssl
   sudo a2ensite 000-default_redirect.conf
   sudo a2ensite 000-default.conf
   
   #mettre la clé et le certificat selon le chemin indiqué dans la configuration
   
   sudo apache2ctl configtest
   #Si c'est ok, vour pouvez redémarrer votre serveur
   sudo systemctl start apache2.service
   
   ```

#### Côté client

1. Générer la clé privée au côté client et l'envoyer au serveur de CA pour signer

   ```bash
   ##dans la machine de client
   openssl genrsa -out client1.key -des3 2048 
   openssl req -new -key client1.key -out client1.csr
   ```
   
Cette procédure est similaire que cela au coté serveur.
   
2. Importer le certificat dans le navigateur

   ps：Il faut importer le certificat en format **p12** dans firefox

   ```bash
   openssl pkcs12 -export -clcerts -in sr03.utc.crt -inkey client1.key -		out client.sr03.utc.p12
   ```