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

    public function test_payroll_index_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/payroll');
        $response->assertStatus(200);
    }

    public function test_payroll_create_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->get('/payroll/create');
        $response->assertStatus(200);
    }

    public function test_payroll_store(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $emp = \App\Models\Employee::first();
        $response = $this->actingAs($user)->post('/payroll', [
            'employee_id'  => $emp->id,
            'month'        => '2025-08',
            'basic_salary' => 50000,
            'allowances'   => 5000,
            'deductions'   => 2500,
            'net_pay'      => 52500,
            'status'       => 'pending',
        ]);
        $response->assertRedirect('/payroll');
        $this->assertDatabaseHas('payrolls', ['employee_id' => $emp->id, 'month' => '2025-08']);
    }

    public function test_payroll_show_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $payroll = \App\Models\Payroll::first();
        $response = $this->actingAs($user)->get('/payroll/' . $payroll->id);
        $response->assertStatus(200);
    }

    public function test_payroll_edit_renders(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $payroll = \App\Models\Payroll::first();
        $response = $this->actingAs($user)->get('/payroll/' . $payroll->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_payroll_update(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $payroll = \App\Models\Payroll::first();
        $response = $this->actingAs($user)->put('/payroll/' . $payroll->id, [
            'employee_id'  => $payroll->employee_id,
            'month'        => $payroll->month,
            'basic_salary' => 60000,
            'allowances'   => 6000,
            'deductions'   => 3000,
            'net_pay'      => 63000,
            'status'       => 'paid',
        ]);
        $response->assertRedirect('/payroll');
        $this->assertDatabaseHas('payrolls', ['id' => $payroll->id, 'net_pay' => 63000]);
    }

    public function test_payroll_destroy(): void
    {
        $user = \App\Models\User::where('email', 'admin@example.com')->first();
        $payroll = \App\Models\Payroll::first();
        $response = $this->actingAs($user)->delete('/payroll/' . $payroll->id);
        $response->assertRedirect('/payroll');
        $this->assertDatabaseMissing('payrolls', ['id' => $payroll->id]);
    }
}
