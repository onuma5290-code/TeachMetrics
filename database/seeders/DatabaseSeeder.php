<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherSubject;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Test Student
        if (!Student::where('student_code', 'studenttest')->exists()) {
            Student::create([
                'student_code' => 'studenttest',
                'password' => Hash::make('123456'), // Password for testing
                'fullname' => 'Test Student Account',
                'department' => 'Information Technology',
                'classroom' => 'IT-3/1',
            ]);
        }

        // 2. Create Test Teacher
        $teacher = Teacher::where('teacher_code', 'teachertest')->first();
        if (!$teacher) {
            $teacher = Teacher::create([
                'teacher_code' => 'teachertest',
                'password' => Hash::make('123456'), // Password for testing
                'fullname' => 'Test Teacher Account',
            ]);
        }

        // 3. Create Subjects for the Teacher (so Student can evaluate)
        $subjects = [
            ['name' => 'System Testing 101', 'dept' => 'Information Technology', 'class' => 'IT-3/1'],
            ['name' => 'Database Design', 'dept' => 'Information Technology', 'class' => 'IT-3/1'],
            ['name' => 'Web Development', 'dept' => 'Information Technology', 'class' => 'IT-3/1'],
        ];

        foreach ($subjects as $subject) {
            if (!TeacherSubject::where('subject_name', $subject['name'])->exists()) {
                TeacherSubject::create([
                    'teacher_id' => $teacher->teacher_id,
                    'subject_name' => $subject['name'],
                    'department' => $subject['dept'],
                    'classroom' => $subject['class'],
                ]);
            }
        }

        $this->command->info('Test Data Created Successfully!');
        $this->command->info('Student Login: studenttest / 123456');
        $this->command->info('Teacher Login: teachertest / 123456');
        $this->command->info('Subjects: System Testing 101, Database Design, Web Development - All for IT-3/1');
    }
}
