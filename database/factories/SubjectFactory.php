<?php
$factory->define(App\Subject::class, function () {
    return [
        'name' => str_random(10),
    ];
});