### Install

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

1. Clone the project.
1. Go to the project root directory. 
1. Run `composer install`.
1. Copy `.env.example` into `.env` and adjust database parameters in `.env` file. 
1. Run `php create-database.php` to create database.
1. Run `php yii migrate` to create tables and insert initial data.
1. Run `php yii serve` and open in browser [http://localhost:8080](http://localhost:8080)


INSTALLATION of VUE.JS APP
--------------------------

You must have [Node.js](https://nodejs.org) installed.<br>
Go to the `vue` folder.<br>


## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Create email_log table

```
php yii migrate --migrationPath=@vendor/intermundia/yii2-mailer/migrations
```