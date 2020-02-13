# Laravel Seeder Once
This library allows you to run your Larvel seeders only once. No matter how many time artisan command `db:seed` will be called. Done seeds names are stored in database.

## How it works
Works similarly to migrations. First creates table in database, then logs all seeds that are using trait SeederOnce.php. Mechanism of logging data into database is heavily inspired by Laravel migration mechanism from package illuminate/database.

## How to use it

### First create seeders table in database. 
Use this command:
``` bash
php artisan db:intall
```

### Second step is to add trait SeederOnce.php to seeds that you want to be run only once. 
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
This will prevent to seed class SomeSeeder if was already seeded before. All other classes without SeederOnce.php will behave as usual.