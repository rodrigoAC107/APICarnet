<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Item;
use App\Role;
use App\User;
use App\Person;
use App\License;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;
    return [
        'role_id' => $faker->randomElement([1,2,3]),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt('secret'), // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Person::class, function (Faker $faker) {
   
    return [
        'person_object' => 'P' . $faker->numberBetween($min = 100000, $max = 999999),
        'dni' => $faker->numberBetween($min = 10000000, $max = 99999999),
        'name' => $faker->name,
        'lastname' => $faker->lastname,
        'blood_type' => $faker->randomElement(['A+', 'B+', 'O+', 'O-']),
        'address' => $faker->streetAddress,
        'business' => $faker->company,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'image' => $faker->randomElement(['1.jpg', '2.jpg','3.jpg']),
        
    ];
});

$factory->define(License::class, function (Faker $faker) {

    $persona = Person::inRandomOrder()->take(10)->get();

    return [
        'person_id' => $persona->random()->id,
        'date_awarded' => $fecha = $faker->dateTimeBetween($startDate = '2010-01-01', $endDate = 'now'),
        'date_expiration' => $faker->dateTimeBetween($startDate = $fecha, $endDate = '+2 years') 
    ];
});

