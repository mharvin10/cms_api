<?php

use Illuminate\Database\Seeder;

class NavigationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('navigations')->truncate();

        foreach (range(1, 5) as $item) {
            $user = App\Navigation::create([
                'type' => 'main'
            ]);
        }
    }
}
