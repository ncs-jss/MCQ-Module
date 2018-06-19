<?php
$factory->define(App\Option::class, function (Faker\Generator $faker) {
    $que_id = App\Queans::all()->pluck('id')->toArray();
    return [
        'queid' => $faker->randomElement($que_id),
        'ans' => $faker->realText(200,2),
        'iscorrect' => rand(0,1),
    ];
});