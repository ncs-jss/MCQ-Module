<?php
$factory->define(App\Req::class, function (Faker\Generator $faker) {
    $user_id = App\User::all()->pluck('id')->toArray();
    $event_id = App\Event::all()->pluck('id')->toArray();
    return [
        'userid' => $faker->randomElement($user_id),
        'eventid' => $faker->randomElement($event_id),
        'status' => rand(0,1),
    ];
});