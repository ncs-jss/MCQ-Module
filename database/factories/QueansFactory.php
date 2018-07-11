<?php
$factory->define(App\Queans::class, function (Faker\Generator $faker) {
	$que = App\Queans::select('eventid', DB::raw('count(eventid) as total'))->groupBy('eventid')->orderBy('total')->first();
	if(empty($que))
	{
	    $event_id = App\Event::all()->pluck('id')->toArray();
	    return [
	        'que' => $faker->realText(200,2),
	        'eventid' => $faker->randomElement($event_id),
	        'quetype' => rand(0,1),
	    ];
	}
	else
	{
		$event_id = $que->toArray()['eventid'];
	    return [
	        'que' => $faker->realText(200,2),
	        'eventid' => $event_id,
	        'quetype' => rand(0,1),
	    ];
	}
});