<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(TagsTableSeeder::class);
        Article::factory(20)->create();

        Article::all()->each(function($article) {
            $limit = rand(1,7);
            $tagsId = Tag::inRandomOrder('id')->take($limit)->get()->pluck('id');

            $article->tags()->attach($tagsId);
        });
        
    }
}
