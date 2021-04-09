<?php

use Illuminate\Database\Seeder;

class PageNodesTableSeederPawad extends Seeder
{
    public function run()
    {
        DB::table('page_nodes')->truncate();
        DB::table('page_contents')->truncate();

        $rootPage = App\PageNode::create([
            'id' => 'rootpage',
	        'title' => 'Pasacaou Water District',
	        'short_title' => 'PAWAD',
	        'created_by' => 'system'
        ]);

            $aboutUs = $rootPage->children()->create([
                'id' => str_random(14),
                'title' => 'About Us',
                'created_by' => 'superadmin'
            ]);

                $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'Historical Background',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'Agency\'s Mandate, Vision, Mission',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'Core Values',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'List of Officials',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'Organizational Structure 2017',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $aboutUs->children()->create([
                    'id' => str_random(14),
                    'title' => 'Facilities',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

            $transparency = $rootPage->children()->create([
            	'id' => str_random(14),
                'title' => 'Transparency',
                'created_by' => 'system'
            ]);

                $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'Annual Financial Plan',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'DBM approved Budget and Targets',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'Major Projects & Programs',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'Annual Procurement Plan',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'System of Ranking Delivery Units and Individuals',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'Agency Operational Manual',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $other = $transparency->children()->create([
                	'id' => str_random(14),
                    'title' => 'Other Good Governance Conditions',
                    'created_by' => 'superadmin'
                ]);

	                $other->children()->create([
	                	'id' => str_random(14),
	                    'title' => 'Citizen\'s Charter',
	                    'created_by' => 'system'
	                ])->pageContent()->create([
	                    'body' => 'No content yet.'
	                ]);

	                $other->children()->create([
	                	'id' => str_random(14),
	                    'title' => 'PhilGeps Posting',
	                    'created_by' => 'superadmin'
	                ])->pageContent()->create([
	                    'body' => 'No content yet.'
	                ]);

	                $other->children()->create([
	                	'id' => str_random(14),
	                    'title' => 'ARTA Compliance',
	                    'created_by' => 'superadmin'
	                ])->pageContent()->create([
	                    'body' => 'No content yet.'
	                ]);

	                $other->children()->create([
	                	'id' => str_random(14),
	                    'title' => 'SALN Submision/Filing',
	                    'created_by' => 'superadmin'
	                ])->pageContent()->create([
	                    'body' => 'No content yet.'
	                ]);

	                $other->children()->create([
	                	'id' => str_random(14),
	                    'title' => 'Ageing Cash Advances',
	                    'created_by' => 'superadmin'
	                ])->pageContent()->create([
	                    'body' => 'No content yet.'
	                ]);

	                $other->children()->create([
	                	'id' => str_random(14),
	                    'title' => 'Gender and Development Program',
	                    'created_by' => 'superadmin'
	                ])->pageContent()->create([
	                    'body' => 'No content yet.'
	                ]);

                $transparency->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

	        $services = $rootPage->children()->create([
	            'id' => str_random(14),
	            'title' => 'Services',
	            'created_by' => 'superadmin'
	        ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Application for New Service Connection',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Re-connection/Re-opening of Water Connection',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Collection',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Application for Senior Citizen Discount',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Change of Registration/Name',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Statement of Account Certification',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Request for Voluntary Disconnection of Service',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Reclassification of Service Connection',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Relocation of Water Meter',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Complaints on Abnormal/High Consumption',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Repair of SC Leakages(Before Meter)',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Replacement of Water Meter (Damaged/Stuck up Water Meter)',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Bulk Water Tending',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Inspection of SC with No Water or Low Pressure',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

                $services->children()->create([
                	'id' => str_random(14),
                    'title' => 'Attending to Customer Complaints',
                    'created_by' => 'superadmin'
                ])->pageContent()->create([
                    'body' => 'No content yet.'
                ]);

            $rootPage->children()->create([
            	'id' => str_random(14),
                'title' => 'Water Rates',
                'created_by' => 'superadmin'
            ])->pageContent()->create([
                'body' => 'No content yet.'
            ]);
    }
}
