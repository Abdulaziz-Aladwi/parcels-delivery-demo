## About Application

Simple parcels delivery demo created with Symfony 5 where sender user can add new parcel and biker user can pick it up and update pick off and delivery dates, sender user can see parcels status updates.

## Prerequisites

1-PHP 7.4.33 <br/>
2-Composer 2
3-MySQL 5.7

## Installation

1-Configure database credentials in .env

2-Install dependencies using:

```bash
composer install
```

3-Migrate database files using:

```bash
php bin/console doctrine:migrations:migrate
```

4- Load Admin fixture to get Sender and Biker users using:

```bash
php bin/console doctrine:fixtures:load
```

5- Migrate database files for testing environment using:

```bash
APP_ENV=test php bin/console doctrine:migrations:migrate
```

6- To run tests:

```bash
 bin/phpunit
```
