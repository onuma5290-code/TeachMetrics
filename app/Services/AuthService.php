<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public static function loginStudent($data)
    {
        try {
            $student = Student::where('student_code', $data['username'])->first();

            if (!$student) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'ไม่พบรหัสนักเรียนในระบบ'
                ];
            }

            if (!Hash::check($data['password'], $student->password)) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'รหัสผ่านไม่ถูกต้อง'
                ];
            }

            $login = Auth::guard('student')->attempt([
                'student_code' => $data['username'],
                'password' => $data['password'],
            ]);

            if (!$login) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'ไม่สามารถเข้าสู่ระบบได้'
                ];
            }

            request()->session()->regenerate();

            return [
                'success' => true,
                'data' => [
                    'user' => Auth::guard('student')->user(),
                    'redirect' => '/dashboard_student'
                ],
                'message' => 'เข้าสู่ระบบสำเร็จ'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'เกิดข้อผิดพลาด: ' . $th->getMessage()
            ];
        }
    }
    public static function loginTeacher(array $data): array
    {
        try {
            $teacher = Teacher::where('teacher_code', $data['username'])->first();
            if (!$teacher) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'ไม่พบรหัสครูในระบบ'
                ];
            }
            if (!Hash::check($data['password'], $teacher->password)) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'รหัสผ่านไม่ถูกต้อง'
                ];
            }
            $login = Auth::guard('teacher')->attempt([
                'teacher_code' => $data['username'],
                'password' => $data['password'],
            ]);
            if (!$login) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'ไม่สามารถเข้าสู่ระบบได้'
                ];
            }
            request()->session()->regenerate();
            return [
                'success' => true,
                'data' => [
                    'user' => Auth::guard('teacher')->user(),
                    'redirect' => '/dashboard_teacher'
                ],
                'message' => 'เข้าสู่ระบบสำเร็จ'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'เกิดข้อผิดพลาด: ' . $th->getMessage()
            ];
        }
    }
}
