<?php

use Illuminate\Database\Seeder;

class ReqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Req::class, 25)->create();
    }
}
