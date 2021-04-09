<?php

use Illuminate\Database\Seeder;

class PageNodesTableSeederBasud extends Seeder
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

        // for basud
        $rootPage = App\PageNode::create([
            'id' => 'rootpage',
	        'title' => 'Municipality of Basud, Camarines Norte',
	        'short_title' => 'Basud, Cam Norte',
	        'created_by' => 'system'
        ]);

            // government
            $government = $rootPage->children()->create([
                'id' => str_random(14),
                'title' => 'Government',
                'created_by' => 'system'
            ]);

                // office of the mayor
                $mayor = $government->children()->create([
                    'id' => str_random(14),
                    'title' => 'Office of the Mayor',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                // elected officials
                $officials = $government->children()->create([
                    'id' => str_random(14),
                    'title' => 'Elected Officials',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                // departments and offices
                $departments = $government->children()->create([
                    'id' => str_random(14),
                    'title' => 'Department and Offices',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

            // transparency
            $transparency = $rootPage->children()->create([
            	'id' => str_random(14),
                'title' => 'Transparency',
                'created_by' => 'system'
            ]);

                // budget
                $budget = $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'Budget Reports',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                // procurement
                $procurement = $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'Procurments',
                    'created_by' => 'system'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $transparency->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

            // services
            $services = $rootPage->children()->create([
                'id' => str_random(14),
                'title' => 'Services',
                'created_by' => 'superadmin'
            ]);

                // transparency seal
                $tax = $services->children()->create([
                    'id' => str_random(14),
                    'title' => 'Taxes and Fees',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                // business permit and licensing
                $business = $services->children()->create([
                    'id' => str_random(14),
                    'title' => 'Business Permits and Licensing',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                // social and legal services
                $social = $services->children()->create([
                    'id' => str_random(14),
                    'title' => 'Social and Legal Services',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

            // tourism
            $tourism = $rootPage->children()->create([
                'id' => str_random(14),
                'title' => 'Tourism',
                'created_by' => 'superadmin'
            ]);

            // tourism
            $barangays = $rootPage->children()->create([
                'id' => str_random(14),
                'title' => 'Barangays',
                'created_by' => 'superadmin'
            ]);
    }
}
