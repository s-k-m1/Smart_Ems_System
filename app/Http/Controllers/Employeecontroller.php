<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Show the employee management page (list of employees).
     *
     * NOTE: Right now this returns dummy/hardcoded data so the
     * front-end can be built and tested without a database.
     *
     * When the Employee model + migration are ready, replace the
     * $employees array below with something like:
     *
     *     $employees = Employee::all();
     *
     * and make sure the column names match what the Blade view expects
     * (id, name, department, position, status, email, phone, joined,
     * address, image, plus the stats fields).
     */
    public function index()
    {
        $employees = [
            [
                'id' => 'EMP-1024',
                'name' => 'Aarav Sharma',
                'department' => 'Software Engineering',
                'position' => 'Senior Backend Developer',
                'status' => 'Active',
                'email' => 'aarav.sharma@company.com',
                'phone' => '+977 980-123-4567',
                'joined' => 'March 12, 2021',
                'address' => 'Baneshwor, Kathmandu, Nepal',
                'image' => 'https://placehold.co/200x200/6366f1/ffffff?text=AS',
                'stats' => [
                    'present_days' => 224,
                    'leave_taken' => 6,
                    'salary' => 'Rs. 85,000',
                    'projects' => 14,
                ],
            ],
            [
                'id' => 'EMP-1031',
                'name' => 'Priya Adhikari',
                'department' => 'Human Resources',
                'position' => 'HR Manager',
                'status' => 'Active',
                'email' => 'priya.adhikari@company.com',
                'phone' => '+977 981-234-5678',
                'joined' => 'July 4, 2019',
                'address' => 'Lalitpur, Kathmandu, Nepal',
                'image' => 'https://placehold.co/200x200/ec4899/ffffff?text=PA',
                'stats' => [
                    'present_days' => 230,
                    'leave_taken' => 4,
                    'salary' => 'Rs. 95,000',
                    'projects' => 9,
                ],
            ],
            [
                'id' => 'EMP-1045',
                'name' => 'Bibek Thapa',
                'department' => 'Sales & Marketing',
                'position' => 'Marketing Executive',
                'status' => 'Inactive',
                'email' => 'bibek.thapa@company.com',
                'phone' => '+977 982-345-6789',
                'joined' => 'January 22, 2022',
                'address' => 'Pokhara, Nepal',
                'image' => 'https://placehold.co/200x200/f59e0b/ffffff?text=BT',
                'stats' => [
                    'present_days' => 180,
                    'leave_taken' => 12,
                    'salary' => 'Rs. 60,000',
                    'projects' => 5,
                ],
            ],
            [
                'id' => 'EMP-1052',
                'name' => 'Sita Gurung',
                'department' => 'Finance',
                'position' => 'Accountant',
                'status' => 'Active',
                'email' => 'sita.gurung@company.com',
                'phone' => '+977 983-456-7890',
                'joined' => 'September 15, 2020',
                'address' => 'Patan, Lalitpur, Nepal',
                'image' => 'https://placehold.co/200x200/10b981/ffffff?text=SG',
                'stats' => [
                    'present_days' => 219,
                    'leave_taken' => 8,
                    'salary' => 'Rs. 70,000',
                    'projects' => 11,
                ],
            ],
            [
                'id' => 'EMP-1067',
                'name' => 'Rohan Khadka',
                'department' => 'Software Engineering',
                'position' => 'UI/UX Designer',
                'status' => 'Active',
                'email' => 'rohan.khadka@company.com',
                'phone' => '+977 984-567-8901',
                'joined' => 'May 30, 2023',
                'address' => 'Bhaktapur, Nepal',
                'image' => 'https://placehold.co/200x200/3b82f6/ffffff?text=RK',
                'stats' => [
                    'present_days' => 150,
                    'leave_taken' => 3,
                    'salary' => 'Rs. 65,000',
                    'projects' => 7,
                ],
            ],
            [
                'id' => 'EMP-1078',
                'name' => 'Maya Rai',
                'department' => 'Customer Support',
                'position' => 'Support Team Lead',
                'status' => 'Inactive',
                'email' => 'maya.rai@company.com',
                'phone' => '+977 985-678-9012',
                'joined' => 'November 8, 2018',
                'address' => 'Boudha, Kathmandu, Nepal',
                'image' => 'https://placehold.co/200x200/8b5cf6/ffffff?text=MR',
                'stats' => [
                    'present_days' => 200,
                    'leave_taken' => 10,
                    'salary' => 'Rs. 55,000',
                    'projects' => 8,
                ],
            ],
        ];

        // Pass the $employees array to the view as "employees".
        return view('empdetail', [
            'employees' => $employees,
        ]);
    }
}