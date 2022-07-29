# Product Store

This project is my answer to WebJump assessment test.

### Requirements

* PHP 8.1 or newer.
* MySQL database.

### Installation

After cloning the repository, install the dependencies by running the following command in your application's root folder:

```composer install```

You may use the dockerfile found in *docker/* to setup the necessary environment.

```cd docker```
```docker-compose up -d```

Create a *.env* file in the root folder by copying *.env.example* and add your MySQL credentials.

```cp .env.example .env```

For database setup, run the SQL script found in *docs/database.sql*.

Point your virtual host document root to application's public directory. 

If you are not using tools like WAMP or Apache, you may use PHP built-in server, or the pre-defined composer script.

```php -S localhost:80 -t public```

```composer serve```

### Features

* Web routes.
* CSRF Middleware protection.
* Database class using PHP's PDO.
* View class, powered by [Twig Template Engine](https://twig.symfony.com/).
* [Rakit\Validation Library](https://github.com/rakit/validation) for validation and rules support.
* Application error logging, powered by [Monolog](https://seldaek.github.io/monolog/).
* Helper class to deal with session and flash data.
* Simple collection implementation.

### Useful Scripts

• Run Laravel Pint code style fixer:

```composer lint```