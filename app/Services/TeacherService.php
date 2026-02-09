<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class TeacherService
{
    public static function create($data)
    {
        try {
            $teacher = DB::transaction(function () use ($data) {
                $t = Teacher::create([
                    'teacher_code' => $data['teacher_code'],
                    'password' => Hash::make($data['password']),
                    'fullname' => $data['fullname'],
                ]);
                foreach (($data['subjects'] ?? []) as $s) {
                    TeacherSubject::create([
                        'teacher_id' => $t->teacher_id,
                        'subject_name' => $s['subject_name'],
                        'department' => $s['department'],
                        'classroom' => $s['classroom'],
                    ]);
                }
                return $t->load('subjects');
            });

            return [
                'success' => true,
                'data' => $teacher,
                'message' => 'สมัครอาจารย์สำเร็จ',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }
    }
    public static function getTeacherForStudent()
    {
        $student = auth('student')->user();   // ✅ เพิ่มบรรทัดนี้

        if (!$student) {
            return collect([]); // กัน error ถ้าไม่ได้ login
        }

        return Teacher::with(['subjects' => function ($q) use ($student) {
            $q->where('classroom', $student->classroom);
        }])
            ->whereHas('subjects', function ($q) use ($student) {
                $q->where('classroom', $student->classroom);
            })
            ->get();
    }
    public static function getTeacherAll()
    {
        return Teacher::with('subjects')->get();
    }
}
