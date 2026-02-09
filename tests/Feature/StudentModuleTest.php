<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentModuleTest extends TestCase
{
    use RefreshDatabase;

    protected Student $student;
    protected Teacher $teacher;
    protected TeacherSubject $subject;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test student
        $this->student = Student::create([
            'student_code' => 'studenttest',
            'password' => Hash::make('123456'),
            'fullname' => 'Test Student',
            'department' => 'Information Technology',
            'classroom' => 'IT-3/1',
        ]);

        // Create test teacher
        $this->teacher = Teacher::create([
            'teacher_code' => 'teachertest',
            'password' => Hash::make('123456'),
            'fullname' => 'Test Teacher',
        ]);

        // Create test subject
        $this->subject = TeacherSubject::create([
            'teacher_id' => $this->teacher->teacher_id,
            'subject_name' => 'Programming 101',
            'department' => 'Information Technology',
            'classroom' => 'IT-3/1',
        ]);
    }

    /**
     * Test STU-01: View Dashboard
     */
    public function test_student_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->student, 'student')
            ->get('/dashboard_student');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard-student');
        $response->assertViewHas('student');
        $response->assertViewHas('teacher_lists');
    }

    /**
     * Test STU-02: View Evaluation Form
     */
    public function test_student_can_view_evaluation_form(): void
    {
        $response = $this->actingAs($this->student, 'student')
            ->get('/evaluate/' . $this->subject->subject_id);

        $response->assertStatus(200);
        $response->assertViewIs('evaluate');
        $response->assertViewHas('subject');
        $response->assertViewHas('subject_id', $this->subject->subject_id);
    }

    /**
     * Test STU-03: Submit Evaluation
     */
    public function test_student_can_submit_complete_evaluation(): void
    {
        $evaluationData = [
            'question_1' => 5,
            'question_2' => 4,
            'question_3' => 5,
            'question_4' => 3,
            'question_5' => 4,
            'question_6' => 5,
            'question_7' => 4,
            'question_8' => 5,
            'question_9' => 3,
            'question_10' => 4,
            'question_11' => 5,
            'question_12' => 4,
            'question_13' => 5,
            'question_14' => 4,
            'question_15' => 5,
            'evaluation_note' => 'Great teacher!',
        ];

        $response = $this->actingAs($this->student, 'student')
            ->post('/evaluate/' . $this->subject->subject_id, $evaluationData);

        // Check database
        $this->assertDatabaseHas('evaluations', [
            'subject_id' => $this->subject->subject_id,
            'student_id' => $this->student->student_id,
            'question_1' => 5,
            'question_15' => 5,
            'evaluation_note' => 'Great teacher!',
        ]);
    }

    /**
     * Test STU-04: Validate Input (Missing Questions)
     */
    public function test_evaluation_requires_all_questions(): void
    {
        $incompleteData = [
            'question_1' => 5,
            'question_2' => 4,
            // Missing questions 3-15
        ];

        $response = $this->actingAs($this->student, 'student')
            ->post('/evaluate/' . $this->subject->subject_id, $incompleteData);

        // Should have validation errors
        $response->assertSessionHasErrors();
    }

    /**
     * Test STU-05: Note Submission
     */
    public function test_evaluation_note_is_saved_correctly(): void
    {
        $evaluationData = [
            'question_1' => 5,
            'question_2' => 4,
            'question_3' => 5,
            'question_4' => 3,
            'question_5' => 4,
            'question_6' => 5,
            'question_7' => 4,
            'question_8' => 5,
            'question_9' => 3,
            'question_10' => 4,
            'question_11' => 5,
            'question_12' => 4,
            'question_13' => 5,
            'question_14' => 4,
            'question_15' => 5,
            'evaluation_note' => 'อาจารย์สอนดีมาก ขอบคุณครับ',
        ];

        $response = $this->actingAs($this->student, 'student')
            ->post('/evaluate/' . $this->subject->subject_id, $evaluationData);

        $evaluation = Evaluation::where('student_id', $this->student->student_id)
            ->where('subject_id', $this->subject->subject_id)
            ->first();

        $this->assertEquals('อาจารย์สอนดีมาก ขอบคุณครับ', $evaluation->evaluation_note);
    }

    /**
     * Test: Student cannot evaluate same subject twice
     */
    public function test_student_cannot_evaluate_same_subject_twice(): void
    {
        // First evaluation
        $evaluationData = $this->getCompleteEvaluationData();

        $this->actingAs($this->student, 'student')
            ->post('/evaluate/' . $this->subject->subject_id, $evaluationData);

        // Try to evaluate again
        $response = $this->actingAs($this->student, 'student')
            ->post('/evaluate/' . $this->subject->subject_id, $evaluationData);

        // Should show error message
        $response->assertSessionHas('error', 'คุณได้ประเมินรายวิชานี้ไปแล้ว');
    }

    /**
     * Helper method to get complete evaluation data
     */
    private function getCompleteEvaluationData(): array
    {
        return [
            'question_1' => 5,
            'question_2' => 4,
            'question_3' => 5,
            'question_4' => 3,
            'question_5' => 4,
            'question_6' => 5,
            'question_7' => 4,
            'question_8' => 5,
            'question_9' => 3,
            'question_10' => 4,
            'question_11' => 5,
            'question_12' => 4,
            'question_13' => 5,
            'question_14' => 4,
            'question_15' => 5,
            'evaluation_note' => 'Test note',
        ];
    }
}
