<?php

namespace App\Http\Controllers;

use App\Models\TeacherSubject;
use App\Services\EvaluateService;
use Illuminate\Http\Request;

class EvaluateController extends Controller
{
    public function show($id)
    {
        $student = auth('student')->user();

        $subject = TeacherSubject::with('teacher')
            ->where('subject_id', $id)
            ->firstOrFail();

        return view('evaluate', [
            'student' => $student,
            'subject' => $subject,
        ]);
    }

    public function create(Request $request, $subject_id)
    {
        $student = auth('student')->user();
        
        // Return error if not authenticated
        if (!$student) {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }
        
        // Merge subject_id from route parameter into request data so validation passes
        $request->merge(['subject_id' => $subject_id]);

        $rules = [
            'subject_id' => ['required', 'integer'],
            'evaluation_note' => ['nullable', 'string', 'max:255'],
        ];
        for ($i = 1; $i <= 15; $i++) {
            $rules["question_$i"] = ['required', 'integer', 'between:1,5'];
        }
        $validated = $request->validate($rules, [
            'subject_id.required' => 'ไม่พบรายวิชา',
        ]);
        
        $result = EvaluateService::create(
            (int)$student->student_id,
            (int)$validated['subject_id'],
            $validated
        );
        
        if (!$result['success']) {
            // Redirect with error message - don't keep input to prevent resubmission
            return redirect('/dashboard_student')->with('error', $result['message']);
        }
        
        return redirect('/dashboard_student')->with('success', $result['message']);
    }
}
