<?php
$factory->define(App\User::class, function (Faker\Generator $faker) {
	$currentyear = date("Y");
	$currentyear = $currentyear-2000;
    return [
        'name' => $faker->name,
        'admno' => rand($currentyear,$currentyear-4).$faker->randomElement(['cse','it','ece','me','ee','eee','ce']).str_pad(rand(1,120),3,0,STR_PAD_LEFT),
        'rollno' => rand($currentyear,$currentyear-4).'091'.rand(10,16).str_pad(rand(1,120),3,0,STR_PAD_LEFT),
        'type' => rand(0,2),
    ];
});