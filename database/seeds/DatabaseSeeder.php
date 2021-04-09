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
        $this->call([
            // ComponentsTableSeeder::class,
            // AdminSeeder::class,
            // PageNodesTableSeeder::class,
            // PageNodesTableSeederBasud::class,
            // PageNodesTableSeederPawad::class,
            // NavigationsTableSeeder::class
        ]);

        // DB::table('news')->truncate();
        // factory(\App\News::class, 30)->create();
    }
}
