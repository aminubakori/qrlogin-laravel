# Install Guidelines
Please ensure that you are using PHP version 5.5 and above. (Not tested on lower versions)

# Install Laravel
1. Open console and cd into the qrlogin-laravel folder.
2. Run 'composer install' to install all laravel and then 'php artisan key:generate'.
3. Create a new mysql database with the name 'qrlogin'.
4. From the qrlogin-laravel folder console, run 'php artisan migrate:install' and then 'php artisan migrate'

# Method 1. Using Virtual Local Domains
1. If you are using windows goto 'C:\wamp\bin\apache\apache2.4.9\conf' and open the 'httpd.conf' file.
2. At the end of the file copy and paste the content below:
```
NameVirtualHost 127.0.0.1
<VirtualHost 127.0.0.1>
    ServerName local.qrlogin.com
    DocumentRoot "C:/wamp/www/qrlogin-laravel/public"
    <Directory C:/wamp/www/qrlogin-laravel/public>
        Order Allow,Deny
        Allow from all
    </Directory>
</VirtualHost>
```
3. Goto 'C:\Windows\System32\Drivers\etc' and open the 'hosts' file.
4. Copy and paste the content below
```
127.0.0.1       local.qrlogin.com
```
5. Restart Apache and goto http://local.qrlogin.com on your browser.

# Method 2. Using localhost
1. Goto '/path/to/qrlogin-laravel/app/config/' and open 'app.php'.
2. On line '29' change 'url' to 'http://localhost'
```
'url' => 'http://localhost',
```
3. Navigate your browser to 'http://localhost/qrlogin-laravel/public'

Happy Hacking ;)