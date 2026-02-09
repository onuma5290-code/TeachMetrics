<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResult;
use App\Http\Controllers\Controller;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController
{
    public static function create(Request $request)
    {
        $validated = $request->validate([
            'student_code' => ['required', 'string', 'max:50', 'unique:students,student_code'],
            'password' => ['required', 'string', 'min:6'],
            'fullname' => ['required', 'string', 'max:150'],
            'department' => ['required', 'string', 'max:150'],
            'classroom' => ['required', 'string', 'max:50'],
        ], [
            'student_code.required' => 'กรุณากรอกรหัสนักศึกษา',
            'student_code.unique' => 'รหัสนักศึกษานี้ถูกใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องอย่างน้อย 6 ตัวอักษร',
            'fullname.required' => 'กรุณากรอกชื่อ-สกุล',
            'department.required' => 'กรุณาเลือกสาขา',
            'classroom.required' => 'กรุณาเลือกชั้น',
        ]);

        $result = StudentService::create($validated);
        if (!$result['success']) {
            return JsonResult::errors(null, $result['message']);
        }
        return JsonResult::success($result['data'], $result['message']);
    }
}
