<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Test;
use Faker\Generator as Faker;

$factory->define(Test::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'subject' => $faker->sentence,
        'user_id' => factory(\App\User::class)->create()->id
    ];
});
