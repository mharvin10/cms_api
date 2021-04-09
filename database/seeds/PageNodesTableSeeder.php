<?php

use Illuminate\Database\Seeder;

class PageNodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('page_nodes')->truncate();
        DB::table('page_contents')->truncate();

        $rootPage = App\PageNode::create([
            'id' => 'rootpage',
  	        'title' => 'Organization Name',
  	        'short_title' => 'Organization',
  	        'created_by' => 'system'
        ]);

            $aboutUs = $rootPage->children()->create([
                'id' => str_random(14),
                'title' => 'About Us',
                'created_by' => 'system'
            ]);

                $mv = $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'Mission and Vision',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $history = $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'History',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $orgStructure = $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'Organizational Structure',
                    'created_by' => 'system'
                ]);

                    $administration = $orgStructure->children()->create([
                        'id' => str_random(14),
                        'title' => 'Administration',
                        'created_by' => 'system'
                    ])->pageContent()->create([
                        'body' => 'No content yet.'
                    ]);

            $departmentsAndOffices = $rootPage->children()->create([
            	'id' => str_random(14),
                'title' => 'Departments & Offices',
                'created_by' => 'system'
            ]);

                $offices = $departmentsAndOffices->children()->create([
                	'id' => str_random(14),
                    'title' => 'Offices',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $departments = $departmentsAndOffices->children()->create([
                	'id' => str_random(14),
                    'title' => 'Departments',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $departmentsAndOffices->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

        $contact = $rootPage->children()->create([
            'id' => str_random(14),
            'title' => 'Contact',
            'created_by' => 'system'
        ])->pageContent()->create([
            'body' => 'No content yet.'
        ]);
    }
}
