<?php

use Illuminate\Database\Seeder;

class SeedPostsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for($i=0; $i<50; $i++){
            \App\Pos::create([
                'user_id' => \App\User::inRandomOrder()->first()->id,
                'title' => $faker->title,
                'subtitle' => $faker->realText(150),
                'content' => $faker->realText(10000),
                'attachments' => null,
                'is_paid' => (rand(0,5) > 4)? true : false,
                'active' => true,
                'published_at' => \Carbon\Carbon::now()->subDays(rand(6,100))
            ]);
        }
    }
}
