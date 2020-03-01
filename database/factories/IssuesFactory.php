<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Issue;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    return [
        'project_id' => '1',
        'post_user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'assigned_user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'type' => $faker->randomElement(['Task', 'Bug', 'Request', 'Other']),
        'subject' => $faker->sentence(5),
        'description' => $faker->text(),
        'priority' => $faker->randomElement(['high', 'normal', 'low']),
        'severity' => $faker->randomElement(['high', 'normal', 'low']),
        'category' => $faker->randomElement(['User Interface', 'Functionality', 'Database']),
        'version' => $faker->randomElement(['1.1', '1.2', '1.3']),
        'due_date' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'status' => $faker->randomElement(['Open', 'In Progress', 'Resolved', 'Closed']),
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
    ];
});
