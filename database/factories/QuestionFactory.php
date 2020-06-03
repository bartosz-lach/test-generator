<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph(),
        'user_id' => factory(\App\User::class)->create()->id,
        'test_id' => factory(\App\Test::class)->create()->id,

    ];
});
