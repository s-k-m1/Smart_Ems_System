<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewRenderTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_hr_dashboard_renders(): void
    {
        $user = \App\Models\User::where('email', 'hr@example.com')->first();
        $response = $this->actingAs($user)->get('/hr/dashboard');
        $response->assertStatus(200);
    }

    public function test_employee_dashboard_renders(): void
    {
        $user = \App\Models\User::where('email', 'employee@example.com')->first();
        $response = $this->actingAs($user)->get('/employee/dashboard');
        $response->assertStatus(200);
    }

    public function test_employees_index_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/employees');
        $response->assertStatus(200);
    }

    public function test_employees_create_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/employees/create');
        $response->assertStatus(200);
    }

    public function test_attendance_index_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/attendance');
        $response->assertStatus(200);
    }

    public function test_attendance_report_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/attendance/report');
        $response->assertStatus(200);
    }

    public function test_notifications_index_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/notifications');
        $response->assertStatus(200);
    }

    public function test_notifications_create_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/notifications/create');
        $response->assertStatus(200);
    }

    public function test_leave_page_renders(): void
    {
        $user = \App\Models\User::where('email', 'employee@example.com')->first();
        $response = $this->actingAs($user)->get('/leave');
        $response->assertStatus(200);
    }

    public function test_report_page_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/report');
        $response->assertStatus(200);
    }
}
