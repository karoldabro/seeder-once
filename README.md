[![Build Status](https://travis-ci.com/karoldabro/seeder-once.svg?branch=master)](https://travis-ci.com/karoldabro/seeder-once)
[![Latest Stable Version](https://poser.pugx.org/kdabrow/seeder-once/v)](//packagist.org/packages/kdabrow/seeder-once)
[![Monthly Downloads](https://poser.pugx.org/kdabrow/seeder-once/d/monthly)](//packagist.org/kdabrow/seeder-once)
# Laravel Seeder Once
This library allows you to run your Larvel seeders only once. <br> No matter how many times artisan command `db:seed` will be called. Done seeders will be never executed again.

## How it works
Works similarly to migrations. First creates table in database, then logs all seeds that are using trait `Kdabrow\SeederOnce\SeederOnce`. In nutshell this will prevent to execute method run() if it was executed in the past. <br> Mechanism of logging data into database is heavily inspired by Laravel migration mechanism from package illuminate/database.

## How to use it

### 1. Install it. 
By composer:
```bash
composer require kdabrow/seeder-once
```

In Lumen do not forget to register provider in bootstrap/app.php
```php
$app->register(Kdabrow\SeederOnce\Providers\SeederOnceProvider::class);
```

### 2. Create seeders table in database. 
Use this command:
``` bash
php artisan db:install
```
This step is optional. Trait SeederOnce will detect if table with seeds exists. If not will create it automatically.

### 3. Add trait SeederOnce to seeders that you want to be run only once. 
So result should look like this:
```php
use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class SomeSeeder extends Seeder
{
    use SeederOnce;

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
This will prevent to seed class SomeSeeder if was already seeded before. All other classes without trait SeederOnce.php will behave as usual.
