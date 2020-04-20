# banque-securisee





## Activer l'override de .htaccess dans MAMP

1. Go to httpd.conf

```bash
vim /Applications/MAMP/conf/apache/httpd.conf
```

2. Find

```
<Directory />
    Options Indexes FollowSymLinks
    AllowOverride None
</Directory>
```

3. Replace `None` with `All`
4. Restart server.

## .htaccess

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

### Contrôle 

http://localhost:8888/banque-securisee/controller/myController.php?action=disconnect&loginPage=http://www.google.com