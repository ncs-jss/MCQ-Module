<?php
$factory->define(App\Queans::class, function (Faker\Generator $faker) {
    $event_id = App\Event::all()->pluck('id')->toArray();
    return [
        'que' => $faker->realText(200,2),
        'eventid' => $faker->randomElement($event_id),
        'quetype' => rand(0,1),
    ];
});