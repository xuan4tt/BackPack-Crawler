<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Test extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <50 ; $i++) { 
            DB::table('blog')->insert([
                'title' => rand(1,100),
                'content' => rand(1,100)
            ]);
        }
    }
}
