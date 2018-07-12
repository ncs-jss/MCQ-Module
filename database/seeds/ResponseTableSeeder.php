<?php

use Illuminate\Database\Seeder;

class ResponseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Response::class, 250)->create();
    }
}
