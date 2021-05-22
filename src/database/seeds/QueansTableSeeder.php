<?php

use Illuminate\Database\Seeder;

class QueansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Queans::class, 50)->create();
    }
}
