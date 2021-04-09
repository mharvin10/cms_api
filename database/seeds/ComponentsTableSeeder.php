<?php

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('components')->truncate();

		App\Component::create([
            'id' => 'administrators',
	        'name' => 'Administrators'
        ]);

		App\Component::create([
            'id' => 'webpages',
	        'name' => 'Webpages'
        ]);

		App\Component::create([
            'id' => 'main_menu',
	        'name' => 'Main Menu'
        ]);

		App\Component::create([
            'id' => 'links',
	        'name' => 'Links'
        ]);

		App\Component::create([
            'id' => 'news',
	        'name' => 'News'
        ]);

		App\Component::create([
            'id' => 'announcements',
	        'name' => 'Announcements'
        ]);

		App\Component::create([
            'id' => 'job_vacancies',
	        'name' => 'Job Vacancies'
        ]);

		App\Component::create([
            'id' => 'carousel',
	        'name' => 'Carousel'
        ]);

		App\Component::create([
            'id' => 'calendar',
	        'name' => 'Calendar'
        ]);

		App\Component::create([
            'id' => 'albums',
	        'name' => 'Albums'
        ]);
    }
}
