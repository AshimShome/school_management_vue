<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Create roles
        $roleAdmin = Role::create(['guard_name' => 'api', 'name' => 'Admin']);
        $roleTeacher = Role::create(['guard_name' => 'api', 'name' => 'Teacher']);
        $roleAccountant = Role::create(['guard_name' => 'api', 'name' => 'Accountant']);
        $roleGuardian = Role::create(['guard_name' => 'api', 'name' => 'Guardian']);
        $roleStudent = Role::create(['guard_name' => 'api', 'name' => 'Student']);

        //  permission List as array
        $permissions = [
            // =========academic============

            // attendance
            'student-attendance-list',
            'student-attendance-create',
            'teacher-attendance-list',
            'teacher-attendance-create',

            // session
            'session-list',
            'session-create',
            'session-edit',
            'session-delete',

            // department
            'department-list',
            'department-create',
            'department-edit',
            'department-delete',

            // routine
            'routine-list',
            'routine-create',
            'routine-edit',
            'routine-delete',

            // class room
            'class-room-list',
            'class-room-create',
            'class-room-edit',
            'class-room-delete',

            // class
            'class-list',
            'class-create',
            'class-edit',
            'class-delete',

            // section
            'section-list',
            'section-create',
            'section-edit',
            'section-delete',

            // subject
            'subject-list',
            'subject-create',
            'subject-edit',
            'subject-delete',

            // syllabus
            'syllabus-list',
            'syllabus-create',
            'syllabus-edit',
            'syllabus-delete',

            // homework
            'homework-list',
            'homework-create',
            'homework-edit',
            'homework-delete',

            // =========roles and users============

            // role
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            // user
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-view',

            // student
            'student-list',
            'student-create',
            'student-edit',
            'student-delete',
            'student-view',

            // parent
            'parent-list',
            'parent-create',
            'parent-edit',
            'parent-delete',
            'parent-view',

            // teacher
            'teacher-list',
            'teacher-create',
            'teacher-edit',
            'teacher-delete',
            'teacher-view',

            // staff
            'accountant-list',
            'accountant-create',
            'accountant-edit',
            'accountant-delete',
            'accountant-view',

            // =========exam============

            // exam
            'exam-list',
            'exam-create',
            'exam-edit',
            'exam-delete',

            // exam schedule
            'exam-schedule-list',
            'exam-schedule-create',
            'exam-schedule-edit',
            'exam-schedule-delete',

            // exam mark
            'exam-mark-list',
            'exam-mark-distribution',

            // exam result rule
            'exam-rule-list',
            'exam-rule-create',
            'exam-rule-edit',
            'exam-rule-delete',

            // exam result
            'exam-result-list',

            // report and announcement
            'student-report',
            'teacher-report',
            'staff-report',
            'class-report',
            'class-routine-report',
            'student-attendance-report',
            'teacher-attendance-report',
            'exam-schedule-report',

            // message-notification
            'message-notification-send',

            // calendar
            'calendar-list',
            'calendar-create',
            'calendar-edit',
            'calendar-delete',

            // promotion
            'promotion-list',
            'promotion-student',

            //========accounting===========

            // fee type
            'fee-type-list',
            'fee-type-create',
            'fee-type-edit',
            'fee-type-delete',

            // fee
            'fee-list',
            'fee-create',
            'fee-edit',
            'fee-delete',

            // expense type
            'expense-type-list',
            'expense-type-create',
            'expense-type-edit',
            'expense-type-delete',

            // expense
            'expense-list',
            'expense-create',
            'expense-edit',
            'expense-delete',

            // setting
            'setting-list',
            'setting-edit',
        ];

        //==================================================
        //================ Admin permissions===============
        //==================================================
        for ($i = 0; $i < count($permissions); $i++) {
            $permission = Permission::create(['guard_name' => 'api', 'name' => $permissions[$i]]);
            $roleAdmin->givePermissionTo($permission);
            $permission->assignRole($roleAdmin);
        }

        //==================================================
        //================ Teacher permissions===============
        //==================================================
        $teacher_permissions = [
            // attendance
            'student-attendance-list',
            'student-attendance-create',

            // routine
            'routine-list',
            'routine-create',
            'routine-edit',
            'routine-delete',

            // syllabus
            'syllabus-list',
            'syllabus-create',
            'syllabus-edit',
            'syllabus-delete',

            // homework
            'homework-list',
            'homework-create',
            'homework-edit',
            'homework-delete',

            // exam
            'exam-list',
            'exam-create',
            'exam-edit',
            'exam-delete',

            // exam schedule
            'exam-schedule-list',
            'exam-schedule-create',
            'exam-schedule-edit',
            'exam-schedule-delete',

            // exam mark
            'exam-mark-list',
            'exam-mark-distribution',

            // exam result rule
            'exam-rule-list',
            'exam-rule-create',
            'exam-rule-edit',
            'exam-rule-delete',
            'exam-result-list',

            // report
            'student-report',
            'teacher-report',
            'staff-report',
            'class-report',
            'class-routine-report',
            'student-attendance-report',
            'exam-schedule-report',

            // message-notification
            'message-notification-send',

            // promotion
            'promotion-list',
            'promotion-create',
            'promotion-edit',
            'promotion-delete',
        ];
        foreach ($teacher_permissions as $permission) {
            $permission = Permission::where('name', $permission)->first();
            $roleTeacher->givePermissionTo($permission);
        }

        //==================================================
        //================ Accountant permissions===============
        //==================================================
        $accountant_permissions = [
            // fee type
            'fee-type-list',
            'fee-type-create',
            'fee-type-edit',
            'fee-type-delete',

            // fee
            'fee-list',
            'fee-create',
            'fee-edit',
            'fee-delete',

            // expense type
            'expense-type-list',
            'expense-type-create',
            'expense-type-edit',
            'expense-type-delete',

            // expense
            'expense-list',
            'expense-create',
            'expense-edit',
            'expense-delete',
        ];
        foreach ($accountant_permissions as $permission) {
            $permission = Permission::where('name', $permission)->first();
            $roleAccountant->givePermissionTo($permission);
        }
    }
}
