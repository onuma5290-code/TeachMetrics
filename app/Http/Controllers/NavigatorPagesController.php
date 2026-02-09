<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Services\EvaluateService;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigatorPagesController extends Controller
{
    public function dashboard_student(Request $request)
    {
        // If not authenticated as student, redirect to login
        if (!auth('student')->check()) {
            return redirect('/login');
        }
        $student = auth('student')->user();
        
        // Get list of subjects this student has already evaluated
        $evaluatedSubjects = Evaluation::where('student_id', $student->student_id)
            ->pluck('subject_id')
            ->toArray();
        
        $data = [
            'student' => $student,
            'teacher_lists' => TeacherService::getTeacherForStudent(),
            'evaluated_subjects' => $evaluatedSubjects,
        ];
        return view('dashboard-student')->with($data);
    }
    public function evaluate($subject_id)
    {
        // Only students can access evaluation page
        if (!auth('student')->check()) {
            if (auth('teacher')->check()) {
                abort(403);
            }
            return redirect('/login');
        }
        
        try {
            $student = auth('student')->user();
            $subject = EvaluateService::show($subject_id);
            
            $data = [
                'subject_id' => $subject_id,
                'student' => $student,
                'subject' => $subject,
            ];
            return view('evaluate')->with($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/dashboard_student')->with('error', 'ไม่พบรายวิชา');
        }
    }
    public function dashboard_teacher(Request $request)
    {
        // If not authenticated as teacher, but authenticated as student => 403
        if (!auth('teacher')->check()) {
            if (auth('student')->check()) {
                abort(403);
            }
            return redirect('/login');
        }
        $teacher = auth('teacher')->user();
        $data = [
            'teacher' => $teacher,
            'score_lists' => EvaluateService::getScoreByTeacherId($teacher->teacher_id),
        ];
        return view('dashboard-teacher')->with($data);
    }
}
