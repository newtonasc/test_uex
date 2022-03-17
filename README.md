# test_uex

###Required

* PHP 8

* NODE 16

```
git clone git@github.com:newtonasc/test_uex.git
```

#DATABASE

###Docker MySql

```
docker-compose up -d uex_db
```

#API

### ENV configuration

```
DB_HOST= HOST

DB_PORT=3306

DB_DATABASE=uex_db

#DB_USERNAME=user_uex for production

#DB_PASSWORD=29NaN1f53a for production

DB_USERNAME=root

DB_PASSWORD=38Ecf3c881
```

####Obs HOST **if docker container use uex_db else use host ip**

```
php artisan migrate
php artisan DB:seed
```

###Optional 

```
Seed database contacts
```

###Configure server
```
cd test_uex/Api
Install dependencies
composer install
```

###Create API Key

```
php artisan key:generate
```

###Start server

```
php artisan serve
```

##URL API

```
http://localhost:8000/
```

###Run Tests

```
./vendor/bin/phpunit ./tests/Unit
```

#FRONT

```
cd Front
npm install
npm start
```

**Para utilizar docker**

```
Docker
npm run build
```

##Na raiz do projeto 

```
docker-compose up -d
```
