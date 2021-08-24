<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numOfRows = 10;
        $tags = [];

        $i = 0;
        while($i < $numOfRows) {
            $i++;
            $tags[] = ['name' => strtoupper("Tag-$i")];
        }

        DB::table('tags')->insert($tags);
    }
}
