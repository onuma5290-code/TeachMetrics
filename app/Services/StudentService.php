<?php

namespace App\Services;

use App\Helpers\JsonResult;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentService
{
    public static function create($data)
    {
        try {
            $student = Student::create([
                'student_code' => $data['student_code'],
                'password' => Hash::make($data['password']),
                'fullname' => $data['fullname'],
                'department' => $data['department'],
                'classroom' => $data['classroom'],
            ]);

            return [
                'success' => true,
                'data' => $student,
                'message' => 'สมัครนักเรียนสำเร็จ'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
}
