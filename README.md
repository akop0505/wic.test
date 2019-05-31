
###Places

### Instruction to install the project


#### Required

```bash
PHP >=7.0
cUrl
PDO
MySql >= 5.7
```

## Installation

<h4>1. Clone the project</h4>

```bash
git clone https://github.com/akop0505/wic.test.git
```

<h4>2. Create new VirtualHost to root folder of the project</h4>

<p>Example:</p>

```ini
<VirtualHost *:80>
        <Directory /var/www/project_root_folder/>
                AllowOverride All
                Require all granted
                Options Indexes FollowSymLinks
        </Directory>
        ServerName places.local
        ServerAlias www.places.local
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/project_root_folder
</VirtualHost>

```
<h4>3. Create new data base and import the dump</h4>

```bash
root_folder/script.sql
```
<h4>4. Set DB configs in db.php</h4>

```bash
root_folder/config/db.php
```

<h4>5. Open in browser</h4>

[your_virtual_host/public/index.html](your_virtual_host/public/index.html)

