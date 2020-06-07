<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name'   => $faker->name,
        'budget' => $faker->randomFloat(2, 0, 6)
    ];
});
