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
                    'ext' => '',
                    'email' => 'governor@kisii.go.ke',
                    'message' => 'We are committed to transforming Kisii County through inclusive governance, sustainable development, and improved service delivery for all residents.',
                ],
                'staff' => [
                    ['name' => '', 'role' => 'Secretary Governor', 'ext' => '65001'],
                    ['name' => '', 'role' => 'Secretary Governor', 'ext' => '65002'],
                    ['name' => 'Onyiego Dominic', 'role' => 'Personal Assistant', 'ext' => '65050'],
                    ['name' => 'Kenani Onchari', 'role' => 'Economic Advisor', 'ext' => '65009'],
                    ['name' => 'John Nyamiobo', 'role' => 'Political Advisor', 'ext' => '65010'],
                    ['name' => 'Ombasa', 'role' => 'Director Admin', 'ext' => '65052'],
                    ['name' => 'Patrick Chogo', 'role' => 'Cabinet Affairs', 'ext' => '65143'],
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
                    'name' => 'H.E. Elijah Julius Obebo',
                    'role' => 'Deputy Governor, Kisii County',
                    'ext' => '',
                    'email' => 'deputygovernor@kisii.go.ke',
                    'message' => 'Our focus on community health, education, and women empowerment continues to drive our development agenda forward.',
                ],
                'staff' => [
                    ['name' => 'Jackline Mogoba', 'role' => 'Sec. Dep. Governor', 'ext' => '65004'],
                    ['name' => 'Phane Onyancha', 'role' => 'PA/Protocol DG', 'ext' => '65051'],
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
                    'name' => 'Patrick Lumumba',
                    'role' => 'County Secretary',
                    'ext' => '65007',
                    'email' => 'countysec@kisii.go.ke',
                    'message' => 'The office of the County Secretary coordinates all government functions and ensures efficient service delivery across all departments.',
                ],
                'staff' => [
                    ['name' => 'Janet', 'role' => 'Sec CS', 'ext' => '65006'],
                ]
            ],
            [
                'slug' => 'chief of staff',
                'name' => 'Chief Of Staff',
                'short_name' => 'CoS',
                'icon' => 'Shield',
                'accent_color' => '#1B4F8A',
                'sort_order' => 4,
                'senior' => [
                    'name' => 'Henry Nyanchoka',
                    'role' => 'County Chief of Staff',
                    'ext' => '',
                    'email' => 'chiefofstaff@kisii.go.ke',
                    'message' => 'The office of the Chief of Staff coordinates all administrative operations and strategic initiatives of the Governor\'s executive team.',
                ],
                'staff' => [
                    ['name' => 'Nancy Mogoi', 'role' => 'Sec Chief of Staff', 'ext' => '65048'],
                    ['name' => 'Maseme Machuka', 'role' => 'Dir. Comm', 'ext' => '65095'],
                ]
            ],
            [
                'slug' => 'ict',
                'name' => 'ICT',
                'short_name' => 'ICT',
                'icon' => 'Monitor',
                'accent_color' => '#2A6CB5',
                'sort_order' => 5,
                'senior' => [
                    'name' => 'Eng. Kevin Nyagaka',
                    'role' => 'Chief Officer, ICT',
                    'ext' => '',
                    'email' => 'ict@kisii.go.ke',
                    'message' => 'We are driving digital transformation to make government services accessible, efficient and transparent for all Kisii County residents.',
                ],
                'staff' => [
                    ['name' => 'Victor Odoyo', 'role' => 'Head of ICT', 'ext' => '65011'],
                    ['name' => 'Eric Nyasae', 'role' => 'System Admin', 'ext' => '65008'],
                    ['name' => 'Sese/Oucho', 'role' => 'ICT Treasury', 'ext' => '65020'],
                    ['name' => 'Jefuneh/Onyatta', 'role' => 'Networks and Web', 'ext' => '65019'],
                    ['name' => 'Kegoro/Ogega', 'role' => 'Inventory and H/W', 'ext' => '65099'],
                ]
            ],
            [
                'slug' => 'agriculture',
                'name' => 'Agriculture',
                'short_name' => 'Agriculture',
                'icon' => 'Sprout',
                'accent_color' => '#1F7A3A',
                'sort_order' => 6,
                'senior' => [
                    'name' => 'Esman N. Onsarigo',
                    'role' => 'CEC, Agriculture',
                    'ext' => '65113',
                    'email' => 'agriculture@kisii.go.ke',
                    'message' => 'Kisii County\'s fertile highlands and hardworking farmers are our greatest asset. We support sustainable farming practices that feed the nation.',
                ],
                'staff' => [
                    ['name' => 'Janet/Rael', 'role' => 'Reception C.O. Block', 'ext' => '65104'],
                    ['name' => '', 'role' => 'Chief Officer', 'ext' => '65105'],
                    ['name' => 'Joshua Omache', 'role' => 'Administrator', 'ext' => '65106'],
                    ['name' => 'Nyamumbo', 'role' => 'Monitoring and E', 'ext' => '65107'],
                    ['name' => 'Soire', 'role' => 'CDA', 'ext' => '65108'],
                    ['name' => 'Mr. Khisa', 'role' => 'ASDSP', 'ext' => '65109'],
                    ['name' => 'Margaret', 'role' => 'Procurement', 'ext' => '65110'],
                    ['name' => 'Damaris Musembi', 'role' => 'ICT', 'ext' => '65111'],
                    ['name' => 'Yunia', 'role' => 'Reception CEC Block', 'ext' => '65112'],
                    ['name' => 'Chris Momanyi', 'role' => 'Accounts', 'ext' => '65114'],
                    ['name' => 'John Katimbwa', 'role' => 'PA to the CEC', 'ext' => '65115'],
                ]
            ],
            [
                'slug' => 'communication',
                'name' => 'Communication',
                'short_name' => 'Communication',
                'icon' => 'Megaphone',
                'accent_color' => '#E8C04A',
                'sort_order' => 7,
                'senior' => [
                    'name' => 'Kenani/Peris',
                    'role' => 'Comm Executive',
                    'ext' => '65093',
                    'email' => 'communication@kisii.go.ke',
                    'message' => 'Promoting transparency and public engagement through effective communication.',
                ],
                'staff' => [
                    ['name' => 'Maseme Machuka', 'role' => 'Dir. Comm', 'ext' => '65095'],
                ]
            ],
            [
                'slug' => 'finance',
                'name' => 'Treasury - Finance',
                'short_name' => 'Finance',
                'icon' => 'DollarSign',
                'accent_color' => '#D4A017',
                'sort_order' => 8,
                'senior' => [
                    'name' => 'John B. Momanyi',
                    'role' => 'CEC Finance',
                    'ext' => '65018',
                    'email' => 'finance@kisii.go.ke',
                    'message' => 'Prudent financial management and transparent budget execution remain our core commitments to the people of Kisii County.',
                ],
                'staff' => [
                    ['name' => 'Beatrice Ochoki', 'role' => 'CO Finance', 'ext' => '65024'],
                    ['name' => 'Alice Nyamota', 'role' => 'Sec CEC', 'ext' => '65017'],
                    ['name' => 'Edna Marita', 'role' => 'Sec CFO', 'ext' => '65025'],
                    ['name' => 'Chacha Nyakebati', 'role' => 'Dep. Dir Finance', 'ext' => '65026'],
                    ['name' => 'Daniel Njuguna', 'role' => 'Dir Finance', 'ext' => '65036'],
                    ['name' => 'Dennis Abuga', 'role' => 'Sec CO Finance', 'ext' => '65038'],
                    ['name' => 'Risper', 'role' => 'Sec. Omosa', 'ext' => '65069'],
                ]
            ],
            [
                'slug' => 'accounts',
                'name' => 'Accounts',
                'short_name' => 'Accounts',
                'icon' => 'BarChart3',
                'accent_color' => '#2E9B52',
                'sort_order' => 9,
                'senior' => [
                    'name' => 'John Nyandanyi',
                    'role' => 'Head of Accounts',
                    'ext' => '65013',
                    'email' => 'accounts@kisii.go.ke',
                    'message' => 'Ensuring accurate accounting, financial reporting, and compliance across all county operations.',
                ],
                'staff' => [
                    ['name' => 'Lukio Obwoge', 'role' => 'Dep Head of Acc', 'ext' => '65034'],
                    ['name' => 'Benard Omosa', 'role' => 'Administrator', 'ext' => '65037'],
                    ['name' => 'Risper/Amisi', 'role' => 'IFMIS Pool', 'ext' => '65027'],
                    ['name' => '', 'role' => 'Data Capture Office', 'ext' => '65029'],
                    ['name' => 'Thomas Arori', 'role' => 'Acc. Finance', 'ext' => '65088'],
                    ['name' => '', 'role' => 'Accounts Pool', 'ext' => '65047'],
                    ['name' => 'Cyrus/Ezekiel', 'role' => 'IFMIS Finance', 'ext' => '65039'],
                ]
            ],
            [
                'slug' => 'procurement',
                'name' => 'Procurement',
                'short_name' => 'Procurement',
                'icon' => 'FileText',
                'accent_color' => '#1B4F8A',
                'sort_order' => 10,
                'senior' => [
                    'name' => 'Janet Nyangena',
                    'role' => 'Dep. Head of Proc',
                    'ext' => '65032',
                    'email' => 'procurement@kisii.go.ke',
                    'message' => 'Committed to fair, transparent, and efficient procurement processes for Kisii County.',
                ],
                'staff' => [
                    ['name' => 'Purity', 'role' => 'Sec. Procurement', 'ext' => '65042'],
                    ['name' => 'Mayaka/Nancy', 'role' => 'Secretariat', 'ext' => '65043'],
                    ['name' => 'Mageto/Joyce/Monica', 'role' => 'Proc Pool', 'ext' => '65044'],
                    ['name' => 'Kitum Kimosop', 'role' => 'Dep. Dir Proc', 'ext' => '65041'],
                    ['name' => 'Elijah Kianga', 'role' => 'Dep. Dir Proc', 'ext' => '65030'],
                    ['name' => 'Siro', 'role' => 'Proc Secretariat', 'ext' => '65040'],
                ]
            ],
            [
                'slug' => 'lands',
                'name' => 'Lands & Urban Development',
                'short_name' => 'Lands',
                'icon' => 'Map',
                'accent_color' => '#145A28',
                'sort_order' => 11,
                'senior' => [
                    'name' => '',
                    'role' => 'Chief Officer',
                    'ext' => '65116',
                    'email' => 'lands@kisii.go.ke',
                    'message' => 'Orderly land use, modern urban planning and affordable housing are at the heart of our development vision for Kisii County.',
                ],
                'staff' => [
                    ['name' => '', 'role' => 'Sec to CO', 'ext' => '65117'],
                    ['name' => 'Salman Metobo', 'role' => 'ICT', 'ext' => '65118'],
                    ['name' => 'Samwel Nyakangi', 'role' => 'Dir. Town Admin', 'ext' => '65119'],
                    ['name' => 'Issa Obaga', 'role' => 'Dir. LHPPUD Admin', 'ext' => '65120'],
                    ['name' => 'Jefferson Akunga', 'role' => 'Dep Dir Admin', 'ext' => '65121'],
                    ['name' => 'Wesley Onsongo', 'role' => 'Dep Dir Admin', 'ext' => '65122'],
                    ['name' => "Beverley Mung'alla", 'role' => 'Customer Care', 'ext' => '65123'],
                    ['name' => '', 'role' => 'Admin Officer', 'ext' => '65124'],
                    ['name' => 'David Oyagi', 'role' => 'Enforcement Officer', 'ext' => '65125'],
                    ['name' => 'Haron Oyaro', 'role' => 'Engineer Urban', 'ext' => '65142'],
                ]
            ],
            [
                'slug' => 'admin',
                'name' => 'County Administration',
                'short_name' => 'Administration',
                'icon' => 'Building2',
                'accent_color' => '#1B4F8A',
                'sort_order' => 12,
                'senior' => [
                    'name' => 'Dr. Walter Okibo',
                    'role' => 'CEC Admin',
                    'ext' => '65064',
                    'email' => 'admin@kisii.go.ke',
                    'message' => 'Effective administration is the backbone of service delivery. We coordinate all sub-county and ward offices to serve every resident.',
                ],
                'staff' => [
                    ['name' => 'Geoffrey Mogire', 'role' => 'CO Admin', 'ext' => '65070'],
                ]
            ],
            [
                'slug' => 'strategy',
                'name' => 'Strategy',
                'short_name' => 'Strategy',
                'icon' => 'Target',
                'accent_color' => '#E8C04A',
                'sort_order' => 13,
                'senior' => [
                    'name' => 'Onchieku',
                    'role' => 'Director Strategy',
                    'ext' => '65097',
                    'email' => 'strategy@kisii.go.ke',
                    'message' => 'Formulating strategic plans and development frameworks to guide county growth and resource allocation.',
                ],
                'staff' => [
                    ['name' => '', 'role' => 'Dep Dir.', 'ext' => '65152'],
                    ['name' => '', 'role' => 'Sec. Strategy', 'ext' => '65153'],
                    ['name' => '', 'role' => 'Principal Economist', 'ext' => '65154'],
                ]
            ],
            [
                'slug' => 'trade',
                'name' => 'Trade',
                'short_name' => 'Trade',
                'icon' => 'BarChart3',
                'accent_color' => '#1F7A3A',
                'sort_order' => 14,
                'senior' => [
                    'name' => 'Ednah N. Kangwana',
                    'role' => 'CEC Trade',
                    'ext' => '65065',
                    'email' => 'trade@kisii.go.ke',
                    'message' => 'Promoting trade, industrial development, and enterprise growth in Kisii County.',
                ],
                'staff' => [
                    ['name' => 'Clive Kenani', 'role' => 'CO Trade', 'ext' => '65023'],
                    ['name' => 'Rose', 'role' => 'Sec CEC/CO Trade', 'ext' => '65067'],
                    ['name' => '', 'role' => 'Dir. Liq. Admin', 'ext' => '65066'],
                    ['name' => '', 'role' => 'Sec. Dir. Liquor', 'ext' => '65155'],
                    ['name' => '', 'role' => 'Liquor Pool', 'ext' => '65145'],
                ]
            ],
            [
                'slug' => 'payroll',
                'name' => 'Payroll',
                'short_name' => 'Payroll',
                'icon' => 'DollarSign',
                'accent_color' => '#D4A017',
                'sort_order' => 15,
                'senior' => [
                    'name' => '',
                    'role' => 'Payroll Manager',
                    'ext' => '65094',
                    'email' => 'payroll@kisii.go.ke',
                    'message' => 'Ensuring accurate, transparent, and timely compensation processing for all county public servants.',
                ],
                'staff' => [
                    ['name' => '', 'role' => 'Payroll Pool', 'ext' => '65148'],
                ]
            ],
            [
                'slug' => 'audit',
                'name' => 'Audit',
                'short_name' => 'Audit',
                'icon' => 'Shield',
                'accent_color' => '#0F3460',
                'sort_order' => 16,
                'senior' => [
                    'name' => '',
                    'role' => 'Head of Audit',
                    'ext' => '65013',
                    'email' => 'audit@kisii.go.ke',
                    'message' => 'Providing independent assurance and oversight on the county\'s internal controls and financial governance.',
                ],
                'staff' => [
                    ['name' => '', 'role' => 'Audit Pool', 'ext' => '65015'],
                ]
            ],
            [
                'slug' => 'culture',
                'name' => 'Culture, Youth, Sports & Social Services',
                'short_name' => 'Culture & Sports',
                'icon' => 'Heart',
                'accent_color' => '#E8C04A',
                'sort_order' => 17,
                'senior' => [
                    'name' => '',
                    'role' => 'CEC Culture',
                    'ext' => '65126',
                    'email' => 'culture@kisii.go.ke',
                    'message' => 'Empowering youth, supporting sports, promoting cultural heritage, and protecting vulnerable groups in our community.',
                ],
                'staff' => [
                    ['name' => '', 'role' => 'Office Contact', 'ext' => '65016'],
                ]
            ],
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
                Staff::create([
                    'department_id' => $dept->id,
                    'name' => $sData['name'],
                    'role' => $sData['role'],
                    'is_senior' => false,
                    'ext' => $sData['ext'],
                    'is_active' => true,
                    'sort_order' => $sOrder++,
                ]);
            }
        }
    }
}
