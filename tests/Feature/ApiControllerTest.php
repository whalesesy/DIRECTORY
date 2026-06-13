<?php

namespace Tests\Feature;

use App\Models\CountyLine;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public API endpoints are accessible and return correct data structures.
     */
    public function test_api_endpoints_return_active_data_only(): void
    {
        // 1. Setup Active and Inactive Departments
        $activeDept = Department::factory()->create([
            'name' => 'Active Department',
            'slug' => 'active-dept',
            'is_active' => true,
        ]);

        $inactiveDept = Department::factory()->create([
            'name' => 'Inactive Department',
            'slug' => 'inactive-dept',
            'is_active' => false,
        ]);

        // 2. Setup Staff for Active Department (Active & Inactive, Senior & Regular)
        $activeSenior = Staff::factory()->create([
            'department_id' => $activeDept->id,
            'name' => 'Active Senior Staff',
            'is_senior' => true,
            'is_active' => true,
            'email' => 'senior@active.com',
            'office_message' => 'Active and ready.',
        ]);

        $inactiveSenior = Staff::factory()->create([
            'department_id' => $activeDept->id,
            'name' => 'Inactive Senior Staff',
            'is_senior' => true,
            'is_active' => false,
            'email' => 'senior@inactive.com',
        ]);

        $activeRegular = Staff::factory()->create([
            'department_id' => $activeDept->id,
            'name' => 'Active Regular Staff',
            'is_senior' => false,
            'is_active' => true,
        ]);

        $inactiveRegular = Staff::factory()->create([
            'department_id' => $activeDept->id,
            'name' => 'Inactive Regular Staff',
            'is_senior' => false,
            'is_active' => false,
        ]);

        // 3. Setup County Lines
        $activeLine = CountyLine::factory()->create([
            'label' => 'Active Line',
            'number' => '0700000001',
            'is_active' => true,
        ]);

        $inactiveLine = CountyLine::factory()->create([
            'label' => 'Inactive Line',
            'number' => '0700000002',
            'is_active' => false,
        ]);

        // --- Test Departments List ---
        $response = $this->getJson('/api/departments');
        $response->assertStatus(200);

        // Active department must be returned
        $response->assertJsonFragment(['name' => 'Active Department']);
        // Inactive department must NOT be returned
        $response->assertJsonMissing(['name' => 'Inactive Department']);

        // Active staff must be returned
        $response->assertJsonFragment(['name' => 'Active Senior Staff']);
        $response->assertJsonFragment(['name' => 'Active Regular Staff']);
        // Inactive staff must NOT be returned
        $response->assertJsonMissing(['name' => 'Inactive Senior Staff']);
        $response->assertJsonMissing(['name' => 'Inactive Regular Staff']);

        // --- Test Single Department Detail ---
        // Active department works
        $response = $this->getJson('/api/departments/active-dept');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Active Department']);
        $response->assertJsonFragment(['name' => 'Active Senior Staff']);
        $response->assertJsonFragment(['name' => 'Active Regular Staff']);
        $response->assertJsonMissing(['name' => 'Inactive Senior Staff']);
        $response->assertJsonMissing(['name' => 'Inactive Regular Staff']);

        // Inactive department returns 404
        $response = $this->getJson('/api/departments/inactive-dept');
        $response->assertStatus(404);

        // --- Test County Lines ---
        $response = $this->getJson('/api/county-lines');
        $response->assertStatus(200);
        $response->assertJsonFragment(['label' => 'Active Line']);
        $response->assertJsonMissing(['label' => 'Inactive Line']);
    }

    /**
     * Test that the rate limiting middleware is applied to API routes.
     */
    public function test_api_routes_have_rate_limiting_headers(): void
    {
        $response = $this->getJson('/api/county-lines');
        $response->assertStatus(200);
        
        // Assert rate limiting headers are present
        $response->assertHeader('X-RateLimit-Limit');
        $response->assertHeader('X-RateLimit-Remaining');
    }
}
