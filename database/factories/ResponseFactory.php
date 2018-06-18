<?php
$factory->define(App\Response::class, function (Faker\Generator $faker) {
    $user_id = App\User::all()->where('type','0')->pluck('id')->toArray();
    $que_id = $faker->randomElement(App\QueAns::all()->pluck('id')->toArray());
    $option_id = App\Option::all()->where('queid',$que_id)->pluck('id')->toArray();
    shuffle($option_id);
    $count = count($option_id);
    if($count!=0)
    {
        $rand = rand(1, $count);
        $random_keys = array_rand($option_id, $rand);
        $opt = [];
        for($i=0; $i<$rand; $i++)
            $opt[$i] = $option_id[$i];
        $opt = implode(',',$opt);
    }
    else
    {
        $opt = "";
    }
    return [
        'userid' => $faker->randomElement($user_id),
        'queid' => $que_id,
        'ans' => $opt,
    ];
});