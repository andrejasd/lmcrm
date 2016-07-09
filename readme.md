# LM CRM on Laravel PHP Framework

### Instalation

* Create database
* Clone project:
```sh
$ git clone git@bitbucket.org:shnshn/lmcrm.git
```
* Create and config ***.env*** file
* Install packages:
```sh
$ composer install
```
* Generate unique key:
```sh
$ php artisan key:generate
```
* Create necessary tables:
```sh
$ php artisan migrate
```
or restore from file /database/lmcrm.sql
* Add users:
```sh
$ php artisan db:seed --class=SentinelDatabaseSeeder
```

***CreativeMakers***