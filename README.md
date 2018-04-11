<p align="center">
    <h1 align="center">Training project: medical record.</h1>
    <h3>(based on Yii 2 Advanced Project Template)</h3>
    <br>
</p>

The template includes three tiers:
1. back end - REST API for medical record,
2. console - console commands & migrations,
3. front end - web-interface for medical record.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.


DIRECTORY STRUCTURE (default Yii 2 Advanced Project Template)
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
INSTALLATION
------------

* Clone project from remote repository using Git
* You can then install the application dependencies using the following command:

~~~
composer install
~~~

NOTE: If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

* Setup Nginx virtual hosts 


NGINX VHOST CONFIGURATION FOR LOCAL WORKSTATION
-----------------------------------------------------------------------

/etc/nginx/sites-available/medic.local
```
server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80;
        listen [::]:80;

        root /var/www/html/proj1_MD_advanced/frontend/web;
        index index.php;

        server_name medic.local;

        access_log  /var/www/html/proj1_MD_advanced/log/front-access.log;
        error_log  /var/www/html/proj1_MD_advanced/log/front-error.log;

        location / {
                try_files $uri $uri/ /index.php$is_args$args;
        }

        location ~ ^/assets/.*\.php$ {
                deny all;
        }

        location ~ \.php$ {
                try_files $uri =404;
                fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }

        location ~* /\. {
                deny all;
        }
}

server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80;
        listen [::]:80;

        root /var/www/html/proj1_MD_advanced/backend/web;
        index index.php;

        server_name api.medic.local;

        access_log  /var/www/html/proj1_MD_advanced/log/back-access.log;
        error_log  /var/www/html/proj1_MD_advanced/log/back-error.log;

        location / {
                try_files $uri $uri/ /index.php$is_args$args;
        }

        location ~ ^/assets/.*\.php$ {
                deny all;
        }

        location ~ \.php$ {
                try_files $uri =404;
                fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }

        location ~* /\. {
                deny all;
        }
}


```

ENABLE NGINX VHOSTS
-------------------

```
#!bash

sudo ln -s /etc/nginx/sites-available/medic.local /etc/nginx/sites-enabled/medic.local
sudo service nginx reload
```


HOSTS CONFIGURATION
-------------------

/etc/hosts
```
127.0.0.1       medic.local
127.0.0.1       api.medic.local

```


GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

1. get composer.phar
2. php composer.phar install
3. Run command `php init` to initialize the application with a specific environment.
4. Create a new database and adjust the `components['db']` configuration in `common/config/main-local.php` accordingly.
*Note that you should create own schema for your development purposes (`common/config/main-local.php`). In other words every developer must have their own schema.
5. Create a new development test database and setup configuration for it under `common/config/test-local.php`.
6. Apply migrations with console command `php yii migrate`. 
7. Apply migrations to test db with console command `php yii_test migrate`. 



FILLING BY TEST DATA
---------------

Now you have installed the application. But you have not any data in it.
So you can fill the database by test data through fixtures:
`php yii fixture "*"`
Now you have three doctors and can test the web-interface:
1. email: "pepe.luis@mail.com"  ---  password: "iampepe"
2. email: "zizu@mail.com"       ---  password: "iamzizu"
3. email: "h.gv@mail.com"       ---  password: "iamhosep"