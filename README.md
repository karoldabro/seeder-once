# Laravel Seeder Once
This library allows you to run your Larvel seeders only once. <br> No matter how many times artisan command `db:seed` will be called. Done seeders will be never executed again.

## How it works
Works similarly to migrations. First creates table in database, then logs all seeds that are using trait `Kdabrow\SeederOnce\SeederOnce`. In nutshell this will prevent to execute method run() if it was executed in the past. <br> Mechanism of logging data into database is heavily inspired by Laravel migration mechanism from package illuminate/database.

## How to use it

### 1. create seeders table in database. 
Use this command:
``` bash
php artisan db:intall
```
If you will not do it, but use somewhere SeederOnce trait then SeederOnceException will be thrown.

### 2.Add trait SeederOnce to seeds that you want to be run only once. 
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