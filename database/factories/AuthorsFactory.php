<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Authors::class, function (Faker $faker) {
    return [
        'firstName' => $faker->name,
        'secondName' => $faker->lastName,

    ];
});
