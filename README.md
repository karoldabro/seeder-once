<p align="center">
<img alt="GitHub Workflow Status (branch)" src="https://img.shields.io/github/workflow/status/karoldabro/seeder-once/tests/master">
<img alt="Packagist Version" src="https://img.shields.io/packagist/v/kdabrow/seeder-once">
<img alt="Packagist Downloads" src="https://img.shields.io/packagist/dm/kdabrow/seeder-once">
<img alt="Scrutinizer code quality (GitHub/Bitbucket)" src="https://img.shields.io/scrutinizer/quality/g/karoldabro/seeder-once/master">
</p>

# Laravel Seeder Once
This library allows you to run your Laravel seeders only once. <br> No matter how many times artisan command `db:seed` is called. Done seeders will never be executed again.

## How it works
Works similarly to migrations. First creates table in database, then logs all seeds that extend abstract class `Kdabrow\SeederOnce\SeederOnce`. In nutshell this will prevent to execute method run() if was executed in the past. Mechanism of logging data into database is heavily inspired by Laravel migration mechanism from package illuminate/database.

## How to use it

### 1. Install it

By composer:

| php                | laravel / lumen | seeder-once                                        |
|--------------------|-----------------|----------------------------------------------------|
| 8.1, 8.2           | 10.0            | ```composer require "kdabrow/seeder-once: ^4.0"``` |
| 8.0, 8.1           | 9.21            | ```composer require "kdabrow/seeder-once: ^3.0"``` |
| 7.3, 7.4, 8.0      | 8.0, 9.0        | ```composer require "kdabrow/seeder-once: ^2.2"``` |
| 7.2, 7.3, 7.4, 8.0 | 6.0, 7.0        | ```composer require "kdabrow/seeder-once: ^1.2"``` |

In Lumen do not forget to register provider in bootstrap/app.php
```php
$app->register(Kdabrow\SeederOnce\Providers\SeederOnceProvider::class);
```

### 2. Create seeders table in database
Use this command:
``` bash
php artisan db:install
```
This step is optional. Trait SeederOnce detects if table exists. If not, creates it automatically.

### 3. Extend seeders that you want to be run only once with SeederOnce

So result should look like this:
```php
use Kdabrow\SeederOnce\SeederOnce;

class SomeSeeder extends SeederOnce
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}
```
This prevents to seed class SomeSeeder if was already seeded before.  
**Tip**: Always replace class Seeder with SeederOnce. Otherwise, `db:seed` command might print unexpected results.

## Configuration

### Run seeder many times
It is possible to overwrite default functionality by change parameter $seedOnce to false:
```php
use Kdabrow\SeederOnce\SeederOnce;

class DatabaseSeeder extends SeederOnce
{
    public bool $seedOnce = false;
    
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}
```
Such seeder will run like normal laravel seeder (as many times as called).

### Configuration file
It is possible to publish configuration file:
```shell
php artisan vendor:publish --tag=seederonce.config
```
#### Table name
Default table name is: seeders

#### Console output
By default, seeder-once changes output of db:seed console command. Seeders that were run in the past will not be printed in the command output. It's possible to change that behaviour in configuration or by env variable:
```shell
SEEDER_ONCE_PRINT_OUTPUT=true
```
Output for already run seeders looks like this:
```shell
Database\Seeders\SomeSeeder was already seeded ..................... DONE
```

## Other

### IMPORTANT NOTE ABOUT PREVIOUS VERSIONS
In previous versions SeederOnce was a trait. Because Laravel console output changed in version 9.21 I was forced to change trait into abstract class. 
**If you want to keep using trait use seeder-once version 2.2. Only problem is that output from command db:seed is quite messy.**
