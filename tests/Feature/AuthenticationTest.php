<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test AUTH-01: Student Registration
     */
    public function test_student_can_register_successfully(): void
    {
        $studentData = [
            'student_code' => '12345',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'fullname' => 'Test Student',
            'department' => 'Computer Science',
            'classroom' => 'CS-3/1',
        ];

        $response = $this->post('/register_student', $studentData);

        // Check if student was created in database
        $this->assertDatabaseHas('students', [
            'student_code' => '12345',
            'fullname' => 'Test Student',
            'department' => 'Computer Science',
            'classroom' => 'CS-3/1',
        ]);

        // Check password is hashed
        $student = Student::where('student_code', '12345')->first();
        $this->assertTrue(Hash::check('password123', $student->password));
    }

    /**
     * Test AUTH-02: Teacher Registration
     */
    public function test_teacher_can_register_successfully(): void
    {
        $teacherData = [
            'teacher_code' => 'T001',
            'password' => 'teacherpass',
            'password_confirmation' => 'teacherpass',
            'fullname' => 'Test Teacher',
            'subjects' => [
                [
                    'subject_name' => 'Programming 101',
                    'department' => 'Computer Science',
                    'classroom' => 'CS-3/1',
                ]
            ]
        ];

        $response = $this->post('/register_teacher', $teacherData);

        // Check teacher was created
        $this->assertDatabaseHas('teachers', [
            'teacher_code' => 'T001',
            'fullname' => 'Test Teacher',
        ]);

        // Check subject was created
        $this->assertDatabaseHas('teacher_subjects', [
            'subject_name' => 'Programming 101',
            'department' => 'Computer Science',
            'classroom' => 'CS-3/1',
        ]);
    }

    /**
     * Test AUTH-03: Student Login
     */
    public function test_student_can_login(): void
    {
        // Create test student
        $student = Student::create([
            'student_code' => 'studenttest',
            'password' => Hash::make('123456'),
            'fullname' => 'Test Student',
            'department' => 'IT',
            'classroom' => 'IT-3/1',
        ]);

        $response = $this->post('/login', [
            'user_code' => 'studenttest',
            'password' => '123456',
            'user_type' => 'student',
        ]);

        // Check if authenticated
        $this->assertAuthenticatedAs($student, 'student');
    }

    /**
     * Test AUTH-04: Teacher Login
     */
    public function test_teacher_can_login(): void
    {
        // Create test teacher
        $teacher = Teacher::create([
            'teacher_code' => 'teachertest',
            'password' => Hash::make('123456'),
            'fullname' => 'Test Teacher',
        ]);

        $response = $this->post('/login', [
            'user_code' => 'teachertest',
            'password' => '123456',
            'user_type' => 'teacher',
        ]);

        // Check if authenticated
        $this->assertAuthenticatedAs($teacher, 'teacher');
    }

    /**
     * Test AUTH-05: Unauthorized Access
     */
    public function test_guest_cannot_access_teacher_dashboard(): void
    {
        $response = $this->get('/dashboard_teacher');

        // Should redirect to login or return 401/403
        $response->assertStatus(302); // Redirect
    }

    /**
     * Test AUTH-06: Role Isolation
     */
    public function test_student_cannot_access_teacher_dashboard(): void
    {
        $student = Student::create([
            'student_code' => 'student001',
            'password' => Hash::make('password'),
            'fullname' => 'Student User',
            'department' => 'IT',
            'classroom' => 'IT-3/1',
        ]);

        $response = $this->actingAs($student, 'student')
            ->get('/dashboard_teacher');

        // Should be denied
        $response->assertStatus(403); // Or 302 depending on middleware
    }
}
