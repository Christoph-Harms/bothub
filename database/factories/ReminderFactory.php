<?php

use BotHub\Bots\Alfred\Models\Reminder;
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

$factory->define(Reminder::class, function (Faker $faker) {
    return [
        'chat_id' => $faker->randomNumber(),
        'message' => $faker->sentence(),
        'remind_at' => $faker->dateTimeInInterval('+5 minutes', '+5 days'),
    ];
});
