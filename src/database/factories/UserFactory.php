<?php
$factory->define(App\User::class, function (Faker\Generator $faker) {
	$currentyear = date("Y");
	$currentyear = $currentyear-2000;
	if(rand(0,1)==0)
		$rollno = NULL;
	else
		$rollno = rand($currentyear,$currentyear-4).'091'.rand(10,16).str_pad(rand(1,120),3,0,STR_PAD_LEFT);
    return [
        'name' => $faker->name,
        'admno' => rand($currentyear,$currentyear-4).$faker->randomElement(['cse','it','ece','me','ee','eee','ce']).str_pad(rand(1,120),3,0,STR_PAD_LEFT),
        'rollno' => $rollno,
        'email' => $faker->email,
        'type' => rand(0,2),
        'remember_token' => str_random(10),
    ];
});