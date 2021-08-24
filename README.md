<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## About 

Requirements:

- PHP -v: 7.4
- Laravel -v: 8.54  
- Database : SQLite;

Simple example of a REST API with Laravel 8.x. Test Assignment for "Eclipse Digital Studio".

## Usage

### 1. Clone project && install depenencies: 
```
    $ composer install
```

### 2. Create "database.sqlite" file in /database/ folder and run migrations:
```
   $ php artisan migrate OR php artisan migrate --seed
```

## 3.Getting with Curl

```
    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X GET http://127.0.0.1:8000/api/articles

    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X POST -d '{"title":"Article title", "content":"Article content","tags":"Tag1, tag2, tag3, ..., tag-n"}' http://127.0.0.1:8000/api/articles

    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X PATCH -d {"title":"Article title", "content":"Article content","tags":"Tag1, tag2, tag3, ..., tag-n"}' http://127.0.0.1:8000/api/articles/:id

    $ curl -H 'content-type: application/json' -H 'Accept: application/json' -v -X DELETE http://127.0.0.1:8000/api/articles/:id

```


