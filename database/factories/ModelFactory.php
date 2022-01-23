<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),

    ];
});
$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'en'=>[ 'title' => $faker->name,
                'body' => $faker->name],
        'ar'=>[ 'title' => $faker->name,
                'body' => $faker->name],
        'post_type_id' => 1,
        'created_by' => 1,
        'slug'=>"",
        'created_at'=>date("Y-m-d H:i:n"),
        'pub_date'=>date("Y-m-d H:i:n"),
        'is_published'=>1
    ];
});
