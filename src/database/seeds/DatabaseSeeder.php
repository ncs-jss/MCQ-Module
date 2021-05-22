<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SubjectTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(QueansTableSeeder::class);
        $this->call(OptionTableSeeder::class);
        $this->call(ResponseTableSeeder::class);
        $this->call(ReqTableSeeder::class);
    }
}
