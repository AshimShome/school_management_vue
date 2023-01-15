<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\Session;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        $developer = User::create([
            'name' => 'Developer',
            'email' => 'developer@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $developer->assignRole('Admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        // Teacher
        $teacher = User::create([
            'name' => 'Teacher',
            'email' => 'teacher@mail.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);
        $teacher->assignRole('Teacher');
        $guardian = Staff::create([
            'user_id'         =>  $teacher->id,
            'department_id'   =>  Department::inRandomOrder()->first()->id,
            'designation'     =>    'teacher',
            'joining_date'     =>  '2020-01-01',
            'phone'        => '0168196343',
            'gender'      => 'male',
            'religion'      => 'muslim',
        ]);

        // Parent
        $guardianUser = User::create([
            'name' => 'Parent',
            'email' => 'parent@mail.com',
            'password' => bcrypt('password'),
            'role' => 'guardian',
            'email_verified_at' => now(),
        ]);
        $guardianUser->assignRole('Guardian');
        $guardian = Guardian::create([
            'user_id'               =>  $guardianUser->id,
            'session_id'               => Session::latest()->value('id'),
            'phone'                 => '+880',
            'occupation'            => 'Farmer',
        ]);

        // Student
        $studentUser = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);
        $studentUser->assignRole('Student');

        // Accountant
        $accountantUser = User::create([
            'name' => 'Accountant',
            'email' => 'accountant@mail.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);
        $accountantUser->assignRole('Accountant');

        $session = Session::orderByDesc('id')->first();
        $student = Student::create([
            'user_id'       =>  $studentUser->id,
            'parent_id'       =>  $guardian->id,
            'session_id'       =>  $session->id,
            'class_id'       =>  1,
            'section_id'       =>  1,
            'roll_no'       =>  1,
            'blood_group'   => 'A+',
            'admission_date'    => now(),
            'present_address'   =>  'Dhaka',
            'gender'   =>  'male',
            'date_of_birth' =>  now(),
            'blood_group'   =>  'A+',
        ]);
    }
}
