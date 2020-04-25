# banque-securisee



## .htaccess

### Activer l'override de .htaccess dans MAMP

1. Go to httpd.conf

```bash
vim /Applications/MAMP/conf/apache/httpd.conf
```

2. Find this bloc

```
<Directory />
    Options Indexes FollowSymLinks
    AllowOverride None
</Directory>
```

3. Replace `None` with `All`
4. Restart server.

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
<!-- ### Contrôlehttp://localhost:8888/banque-securisee/controller/myController.php?action=disconnect&loginPage=http://www.google.com -->

## Chiffrer mot de passe

1. Pour chiffrer mot de passe et le stocker dans la BD

   Aller https://www.jdoodle.com/php-online-editor/ pour générer hashedPwd avec la fonction 

   ```php
   <?php
   echo password_hash("<mot_de_passe>", PASSWORD_DEFAULT);
   ?>
   ```

2. Changer ton `mot_de_passe` correspondant dans la BD avec phpmyadmin

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

1. 在服务器端生成密钥，继而生成请求，并发送给CA签名

   ```bash
   #服务器端生成DES密钥和证书认证请求
   openssl genrsa -out server.key -des3 2048
   openssl req -new -key server.key -out server.csr
   #发送服务器生成的请求到CA服务器
   #在CA服务器使用XCA软件对请求进行签名，并将证书发回给服务器
   ```
   
2. Apache 服务器设置ssl模式

   修改本站的apache conf文件

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
   
   sr03@sr03:~$ sudo vim /etc/apache2/sites-available/000-default_redirect.conf 
   <VirtualHost *:80>
           ServerName sr03.utc
           ServerAdmin webmaster@localhost
           Redirect / https://sr03.utc/
   </VirtualHost>
   
   sudo a2enmod ssl
   sudo a2ensite 000-default_redirect.conf
   sudo a2ensite 000-default.conf
   
   sudo apache2ctl configtest #使用sudo避免出现某些文件因为权限不够而说文件不存在的奇怪提示
   sudo systemctl start apache2.service
   ```

#### Côté client

1. 在客户端生成密钥，继而生成请求，并发送给CA签名

   ```bash
   ##客户端
   openssl genrsa -out client1.key -des3 2048 
   #sr03p20
   openssl req -new -key client1.key -out client1.csr
   ```

   与之前对服务器签名类似，我们使用XCA签名，并导出证书

2. 在浏览器导入客户证书

   ps：在firefox导入客户端证书时需要将证书格式转换成**p12**

   ```
   openssl pkcs12 -export -clcerts -in sr03.utc.crt -inkey client1.key -		out client.sr03.utc.p12
   ```