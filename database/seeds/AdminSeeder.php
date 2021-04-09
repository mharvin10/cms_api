<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $system = App\User::create([
            'id' => 'system',
            'name' => 'n/a',
            'username' => 'n/a',
            'email' => 'n/a',
            'password' => 'n/a',
            'created_by' => 'system',
        ]);

        $superadmin = App\User::create([
          'id' => 'superadmin',
	        'name' => 'Administrator',
	        'username' => 'superadmin',
	        'email' => 'admin@email.com',
	        'password' => bcrypt('superadmin'),
	        'suspended' => 0,
          'created_by' => 'system',
	        'remember_token' => str_random(10),
        ])
        ->components()
        ->attach([
            'administrators',
            'webpages',
            'main_menu',
            'links',
            'news',
            'announcements',
            'job_vacancies',
            'carousel',
            'calendar',
            'albums'
        ]);
    }
}
