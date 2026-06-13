<?php

namespace Database\Seeders;

use App\Models\CountyLine;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KisiiDirectorySeeder extends Seeder
{
    public function run(): void
    {
        // Default Admin User
        $adminEmail = config('services.admin.email');
        $adminPassword = config('services.admin.password');

        if (app()->environment('production') && (empty($adminEmail) || empty($adminPassword))) {
            throw new \Exception('Admin credentials must be configured in environment variables for production.');
        }

        $adminEmail = $adminEmail ?: 'admin@kisii.go.ke';
        $adminPassword = $adminPassword ?: 'password';

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin User',
                'password' => Hash::make($adminPassword),
            ]
        );

        // County Lines
        $countyLines = [
            ['label' => 'Safaricom', 'number' => '0709727000', 'sort_order' => 1],
            ['label' => 'Airtel', 'number' => '0730184000', 'sort_order' => 2],
        ];

        foreach ($countyLines as $line) {
            CountyLine::updateOrCreate(
                ['number' => $line['number']],
                [
                    'label' => $line['label'],
                    'sort_order' => $line['sort_order'],
                    'is_active' => true,
                ]
            );
        }

        // Departments & Staff Data from departments.js
        $departmentsData = [
            [
                'slug' => 'governor',
                'name' => "Governor's Office",
                'short_name' => 'Governor',
                'icon' => 'Shield',
                'accent_color' => '#1B4F8A',
                'sort_order' => 1,
                'senior' => [
                    'name' => 'H.E. Simba Arati',
                    'role' => 'Governor, Kisii County',
                    'ext' => '100',
                    'email' => 'governor@kisii.go.ke',
                    'message' => 'We are committed to transforming Kisii County through inclusive governance, sustainable development, and improved service delivery for all residents.',
                ],
                'staff' => [
                    ['name' => 'Susan Nyamweya', 'role' => 'Chief of Staff', 'ext' => '101'],
                    ['name' => 'James Makori', 'role' => 'Senior Private Secretary', 'ext' => '102'],
                    ['name' => 'Grace Moraa', 'role' => 'Protocol Officer', 'ext' => '103'],
                    ['name' => 'Peter Omari', 'role' => 'Public Communications', 'ext' => '104'],
                    ['name' => 'Alice Kerubo', 'role' => "Governor's Aide", 'ext' => '105'],
                ]
            ],
            [
                'slug' => 'deputy',
                'name' => "Deputy Governor's Office",
                'short_name' => 'Deputy Governor',
                'icon' => 'Star',
                'accent_color' => '#D4A017',
                'sort_order' => 2,
                'senior' => [
                    'name' => 'H.E. Dr. Janet Ong\'era',
                    'role' => 'Deputy Governor, Kisii County',
                    'ext' => '110',
                    'email' => 'deputygovernor@kisii.go.ke',
                    'message' => 'Our focus on community health, education, and women empowerment continues to drive our development agenda forward.',
                ],
                'staff' => [
                    ['name' => 'Robert Nyagaka', 'role' => 'Senior Advisor', 'ext' => '111'],
                    ['name' => 'Mary Gesare', 'role' => 'Private Secretary', 'ext' => '112'],
                    ['name' => 'David Onkundi', 'role' => 'Liaison Officer', 'ext' => '113'],
                ]
            ],
            [
                'slug' => 'countySec',
                'name' => 'County Secretary',
                'short_name' => 'County Sec.',
                'icon' => 'FileText',
                'accent_color' => '#0F3460',
                'sort_order' => 3,
                'senior' => [
                    'name' => 'Dr. Benard Motari',
                    'role' => 'County Secretary & Head of Public Service',
                    'ext' => '120',
                    'email' => 'countysec@kisii.go.ke',
                    'message' => 'The office of the County Secretary coordinates all government functions and ensures efficient service delivery across all departments.',
                ],
                'staff' => [
                    ['name' => 'Lydia Bwari', 'role' => 'Deputy County Secretary', 'ext' => '121'],
                    ['name' => 'Moses Momanyi', 'role' => 'Director Administration', 'ext' => '122'],
                    ['name' => 'Faith Kemunto', 'role' => 'Records Management', 'ext' => '123'],
                    ['name' => 'Isaac Ombati', 'role' => 'Public Service Officer', 'ext' => '124'],
                ]
            ],
            [
                'slug' => 'ict',
                'name' => 'ICT & Communication',
                'short_name' => 'ICT',
                'icon' => 'Monitor',
                'accent_color' => '#2A6CB5',
                'sort_order' => 4,
                'senior' => [
                    'name' => 'Eng. Kevin Nyagaka',
                    'role' => 'Chief Officer, ICT & Communication',
                    'ext' => '130',
                    'email' => 'ict@kisii.go.ke',
                    'message' => 'We are driving digital transformation to make government services accessible, efficient and transparent for all Kisii County residents.',
                ],
                'staff' => [
                    ['name' => 'Anne Bonareri', 'role' => 'ICT Director', 'ext' => '131'],
                    ['name' => 'Brian Obino', 'role' => 'Systems Administrator', 'ext' => '132'],
                    ['name' => 'Caroline Moraa', 'role' => 'Network Engineer', 'ext' => '133'],
                    ['name' => 'Dennis Otieno', 'role' => 'Web & Digital Media', 'ext' => '134'],
                    ['name' => 'Esther Nyakundi', 'role' => 'Data Management', 'ext' => '135'],
                ]
            ],
            [
                'slug' => 'agriculture',
                'name' => 'Agriculture',
                'short_name' => 'Agriculture',
                'icon' => 'Sprout',
                'accent_color' => '#1F7A3A',
                'sort_order' => 5,
                'senior' => [
                    'name' => 'Dr. Elkana Ombati',
                    'role' => 'Chief Officer, Agriculture',
                    'ext' => '140',
                    'email' => 'agriculture@kisii.go.ke',
                    'message' => 'Kisii County\'s fertile highlands and hardworking farmers are our greatest asset. We support sustainable farming practices that feed the nation.',
                ],
                'staff' => [
                    ['name' => 'Ruth Nyamota', 'role' => 'Director Crop Production', 'ext' => '141'],
                    ['name' => 'Samuel Mogaka', 'role' => 'Director Livestock', 'ext' => '142'],
                    ['name' => 'Tabitha Morengi', 'role' => 'Agricultural Extension', 'ext' => '143'],
                    ['name' => 'Philip Omosa', 'role' => 'Irrigation & Water Mgmt', 'ext' => '144'],
                    ['name' => 'Naomi Bosibori', 'role' => 'Cooperative Development', 'ext' => '145'],
                ]
            ],
            [
                'slug' => 'finance',
                'name' => 'Finance & Treasury',
                'short_name' => 'Finance',
                'icon' => 'DollarSign',
                'accent_color' => '#D4A017',
                'sort_order' => 6,
                'senior' => [
                    'name' => 'CPA John Mose',
                    'role' => 'Chief Officer, Finance & Treasury',
                    'ext' => '150',
                    'email' => 'finance@kisii.go.ke',
                    'message' => 'Prudent financial management and transparent budget execution remain our core commitments to the people of Kisii County.',
                ],
                'staff' => [
                    ['name' => 'Josephine Kengara', 'role' => 'County Accountant', 'ext' => '151'],
                    ['name' => 'Leonard Onserio', 'role' => 'Budget Director', 'ext' => '152'],
                    ['name' => 'Margaret Nyaboke', 'role' => 'Internal Audit', 'ext' => '153'],
                    ['name' => 'Nicholas Mwangi', 'role' => 'Procurement Officer', 'ext' => '154'],
                    ['name' => 'Priscilla Omari', 'role' => 'Financial Analyst', 'ext' => '155'],
                ]
            ],
            [
                'slug' => 'lands',
                'name' => 'Lands & Urban Development',
                'short_name' => 'Lands',
                'icon' => 'Map',
                'accent_color' => '#145A28',
                'sort_order' => 7,
                'senior' => [
                    'name' => 'Arch. George Nyamweya',
                    'role' => 'Chief Officer, Lands & Urban Development',
                    'ext' => '160',
                    'email' => 'lands@kisii.go.ke',
                    'message' => 'Orderly land use, modern urban planning and affordable housing are at the heart of our development vision for Kisii County.',
                ],
                'staff' => [
                    ['name' => 'Hellen Mochama', 'role' => 'Director Physical Planning', 'ext' => '161'],
                    ['name' => 'Isaiah Motari', 'role' => 'Land Registrar', 'ext' => '162'],
                    ['name' => 'Janet Bosibori', 'role' => 'Housing Officer', 'ext' => '163'],
                    ['name' => 'Kenneth Areba', 'role' => 'Surveyor', 'ext' => '164'],
                ]
            ],
            [
                'slug' => 'admin',
                'name' => 'County Administration',
                'short_name' => 'Administration',
                'icon' => 'Building2',
                'accent_color' => '#1B4F8A',
                'sort_order' => 8,
                'senior' => [
                    'name' => 'Madam Lilian Nyangau',
                    'role' => 'Chief Officer, Administration',
                    'ext' => '170',
                    'email' => 'admin@kisii.go.ke',
                    'message' => 'Effective administration is the backbone of service delivery. We coordinate all sub-county and ward offices to serve every resident.',
                ],
                'staff' => [
                    ['name' => 'Lucas Omweri', 'role' => 'Director Administration', 'ext' => '171'],
                    ['name' => 'Martha Kerubo', 'role' => 'Human Resource Manager', 'ext' => '172'],
                    ['name' => 'Newton Onsarigo', 'role' => 'Sub-County Coordinator', 'ext' => '173'],
                    ['name' => 'Olive Nyabura', 'role' => 'Ward Admin Officer', 'ext' => '174'],
                    ['name' => 'Patrick Orina', 'role' => 'Fleet & Logistics', 'ext' => '175'],
                ]
            ],
            [
                'slug' => 'revenue',
                'name' => 'Revenue & Trade',
                'short_name' => 'Revenue',
                'icon' => 'BarChart3',
                'accent_color' => '#2E9B52',
                'sort_order' => 9,
                'senior' => [
                    'name' => 'Mr. Quickson Mosoti',
                    'role' => 'Chief Officer, Revenue & Trade',
                    'ext' => '180',
                    'email' => 'revenue@kisii.go.ke',
                    'message' => 'We are modernising revenue collection to ensure every shilling goes back to serve the people of Kisii County.',
                ],
                'staff' => [
                    ['name' => 'Rachel Nyakundi', 'role' => 'Director Revenue', 'ext' => '181'],
                    ['name' => 'Simon Ongaki', 'role' => 'Trade Licensing Officer', 'ext' => '182'],
                    ['name' => 'Teresia Gesare', 'role' => 'Market Development', 'ext' => '183'],
                    ['name' => 'Ursus Omosa', 'role' => 'Revenue Inspector', 'ext' => '184'],
                ]
            ],
            [
                'slug' => 'social',
                'name' => 'Social Services & Culture',
                'short_name' => 'Social Services',
                'icon' => 'Heart',
                'accent_color' => '#E8C04A',
                'sort_order' => 10,
                'senior' => [
                    'name' => 'Dr. Beatrice Mochama',
                    'role' => 'Chief Officer, Social Services & Culture',
                    'ext' => '190',
                    'email' => 'social@kisii.go.ke',
                    'message' => 'We champion the rights of vulnerable groups, promote culture and arts, and build a caring society where no one is left behind.',
                ],
                'staff' => [
                    ['name' => 'Vivian Nyaboke', 'role' => 'Director Social Welfare', 'ext' => '191'],
                    ['name' => 'Walter Otieno', 'role' => 'Culture & Heritage Officer', 'ext' => '192'],
                    ['name' => 'Xenia Moraa', 'role' => 'Gender & Youth Affairs', 'ext' => '193'],
                    ['name' => 'Yasmin Kerubo', 'role' => 'Children Services', 'ext' => '194'],
                    ['name' => 'Zedekia Mwamba', 'role' => 'Sports Development', 'ext' => '195'],
                ]
            ]
        ];

        foreach ($departmentsData as $deptData) {
            $dept = Department::updateOrCreate(
                ['slug' => $deptData['slug']],
                [
                    'name' => $deptData['name'],
                    'short_name' => $deptData['short_name'],
                    'icon' => $deptData['icon'],
                    'accent_color' => $deptData['accent_color'],
                    'sort_order' => $deptData['sort_order'],
                    'is_active' => true,
                ]
            );

            // Add/update senior staff member
            Staff::updateOrCreate(
                [
                    'department_id' => $dept->id,
                    'is_senior' => true,
                ],
                [
                    'name' => $deptData['senior']['name'],
                    'role' => $deptData['senior']['role'],
                    'ext' => $deptData['senior']['ext'],
                    'email' => $deptData['senior']['email'],
                    'office_message' => $deptData['senior']['message'],
                    'is_active' => true,
                    'sort_order' => 0,
                ]
            );

            // Add/update regular staff members
            $sOrder = 1;
            foreach ($deptData['staff'] as $sData) {
                Staff::updateOrCreate(
                    [
                        'department_id' => $dept->id,
                        'name' => $sData['name'],
                        'is_senior' => false,
                    ],
                    [
                        'role' => $sData['role'],
                        'ext' => $sData['ext'],
                        'is_active' => true,
                        'sort_order' => $sOrder++,
                    ]
                );
            }
        }
    }
}
