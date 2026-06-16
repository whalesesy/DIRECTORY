<?php

namespace Tests\Feature;

use App\Models\CountyLine;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default admin user
        $this->admin = User::factory()->create([
            'email' => 'admin@kisii.go.ke',
            'password' => bcrypt('password'),
        ]);
    }

    /**
     * Test admin login page accessibility.
     */
    public function test_admin_login_page_is_accessible(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('Admin Portal');
    }

    /**
     * Test admin login with valid credentials.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@kisii.go.ke',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    /**
     * Test admin login with invalid credentials.
     */
    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@kisii.go.ke',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test admin logout.
     */
    public function test_admin_can_logout(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    /**
     * Test protected routes are guarded.
     */
    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $protectedRoutes = [
            route('admin.dashboard'),
            route('admin.departments.index'),
            route('admin.staff.index'),
            route('admin.county-lines.index'),
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect(route('admin.login'));
        }
    }

    /**
     * Test admin dashboard displays metrics.
     */
    public function test_dashboard_displays_correct_metrics(): void
    {
        Department::factory()->count(3)->create();
        Staff::factory()->count(10)->create();
        CountyLine::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('System Overview');
        $response->assertSee('3'); // Departments count
        $response->assertSee('10'); // Staff count
        $response->assertSee('2'); // County lines count
    }

    /**
     * Test Department CRUD.
     */
    public function test_admin_can_perform_department_crud(): void
    {
        // 1. Index
        $department = Department::factory()->create(['name' => 'Department Alpha']);
        $response = $this->actingAs($this->admin)->get(route('admin.departments.index'));
        $response->assertStatus(200);
        $response->assertSee('Department Alpha');

        // 2. Create Page
        $response = $this->actingAs($this->admin)->get(route('admin.departments.create'));
        $response->assertStatus(200);

        // 3. Store
        $response = $this->actingAs($this->admin)->post(route('admin.departments.store'), [
            'name' => 'Department Beta',
            'short_name' => 'Beta',
            'icon' => 'Heart',
            'accent_color' => '#123456',
            'sort_order' => 5,
        ]);
        $response->assertRedirect(route('admin.departments.index'));
        $this->assertDatabaseHas('departments', ['name' => 'Department Beta']);

        // 4. Edit Page
        $response = $this->actingAs($this->admin)->get(route('admin.departments.edit', $department->id));
        $response->assertStatus(200);
        $response->assertSee('Department Alpha');

        // 5. Update
        $response = $this->actingAs($this->admin)->put(route('admin.departments.update', $department->id), [
            'name' => 'Department Alpha Updated',
            'short_name' => 'Alpha',
            'icon' => 'Star',
            'accent_color' => '#654321',
            'sort_order' => 2,
        ]);
        $response->assertRedirect(route('admin.departments.index'));
        $this->assertDatabaseHas('departments', ['name' => 'Department Alpha Updated']);

        // 6. Delete
        $response = $this->actingAs($this->admin)->delete(route('admin.departments.destroy', $department->id));
        $response->assertRedirect(route('admin.departments.index'));
        $this->assertDatabaseMissing('departments', ['id' => $department->id]);
    }

    /**
     * Test Staff CRUD.
     */
    public function test_admin_can_perform_staff_crud(): void
    {
        $department = Department::factory()->create();
        $staff = Staff::factory()->create([
            'department_id' => $department->id,
            'name' => 'John Doe',
        ]);

        // 1. Index
        $response = $this->actingAs($this->admin)->get(route('admin.staff.index'));
        $response->assertStatus(200);
        $response->assertSee('John Doe');

        // 2. Create Page
        $response = $this->actingAs($this->admin)->get(route('admin.staff.create'));
        $response->assertStatus(200);

        // 3. Store
        $response = $this->actingAs($this->admin)->post(route('admin.staff.store'), [
            'department_id' => $department->id,
            'name' => 'Jane Smith',
            'role' => 'Secretary',
            'ext' => '201',
            'email' => 'jane@kisii.go.ke',
            'office_message' => 'Hello',
            'sort_order' => 1,
            'is_senior' => 1,
            'is_active' => 1,
        ]);
        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', ['name' => 'Jane Smith', 'is_senior' => true]);

        // 4. Edit Page
        $response = $this->actingAs($this->admin)->get(route('admin.staff.edit', $staff->id));
        $response->assertStatus(200);
        $response->assertSee('John Doe');

        // 5. Update
        $response = $this->actingAs($this->admin)->put(route('admin.staff.update', $staff->id), [
            'department_id' => $department->id,
            'name' => 'John Doe Updated',
            'role' => 'Manager',
            'ext' => '202',
            'email' => 'john@kisii.go.ke',
            'sort_order' => 3,
        ]);
        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', ['name' => 'John Doe Updated', 'role' => 'Manager']);

        // 6. Delete
        $response = $this->actingAs($this->admin)->delete(route('admin.staff.destroy', $staff->id));
        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseMissing('staff', ['id' => $staff->id]);
    }

    /**
     * Test CountyLine CRUD.
     */
    public function test_admin_can_perform_county_line_crud(): void
    {
        $line = CountyLine::factory()->create([
            'label' => 'Airtel Hotline',
            'number' => '0730000000',
        ]);

        // 1. Index
        $response = $this->actingAs($this->admin)->get(route('admin.county-lines.index'));
        $response->assertStatus(200);
        $response->assertSee('Airtel Hotline');

        // 2. Create Page
        $response = $this->actingAs($this->admin)->get(route('admin.county-lines.create'));
        $response->assertStatus(200);

        // 3. Store
        $response = $this->actingAs($this->admin)->post(route('admin.county-lines.store'), [
            'label' => 'Safaricom Hotline',
            'number' => '0700000000',
            'sort_order' => 1,
            'is_active' => 1,
        ]);
        $response->assertRedirect(route('admin.county-lines.index'));
        $this->assertDatabaseHas('county_lines', ['label' => 'Safaricom Hotline']);

        // 4. Edit Page
        $response = $this->actingAs($this->admin)->get(route('admin.county-lines.edit', $line->id));
        $response->assertStatus(200);
        $response->assertSee('Airtel Hotline');

        // 5. Update
        $response = $this->actingAs($this->admin)->put(route('admin.county-lines.update', $line->id), [
            'label' => 'Airtel Hotline Updated',
            'number' => '0731111111',
            'sort_order' => 2,
        ]);
        $response->assertRedirect(route('admin.county-lines.index'));
        $this->assertDatabaseHas('county_lines', ['label' => 'Airtel Hotline Updated', 'number' => '0731111111']);

        // 6. Delete
        $response = $this->actingAs($this->admin)->delete(route('admin.county-lines.destroy', $line->id));
        $response->assertRedirect(route('admin.county-lines.index'));
        $this->assertDatabaseMissing('county_lines', ['id' => $line->id]);
    }

    /**
     * Test dashboard updates route returns a JSON response containing stats.
     */
    public function test_dashboard_updates_route_returns_json_response(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard.updates'));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            'stats' => [
                'departments_count',
                'staff_count',
                'county_lines_count',
            ],
            'recentStaff',
        ]);
    }
}
