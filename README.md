### Install

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

1. Clone the project.
1. Go to the project root directory. 
1. Run `composer install`.
1. Copy `.env.example` into `.env` and adjust database parameters in `.env` file. 
1. Create database.
1. Run `./migrate` to create tables and insert initial data.
1. Run `php yii serve` and open in browser [http://localhost:8080](http://localhost:8080)

### Install with Docker

1. Copy `.env.example` into `.env` and DON'T CHANGE PARAMS.
1. Run docker `docker-compose up -d`
1. Run docker bash `docker-compose exec php bash`
   1. Install composer `composer install`
   1. Run migration `./migrate`
1. Stop docker `docker-compose down`

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

## Chat setup
```
cd chat-server
npm install
```

### Compiles and run chat for development
```
npm run start
```
