<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResult;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'teacher_code' => ['required', 'string', 'max:50', 'unique:teachers,teacher_code'],
            'password' => ['required', 'string', 'min:6'],
            'fullname' => ['required', 'string', 'max:150'],

            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*.subject_name' => ['required', 'string', 'max:150'],
            'subjects.*.department' => ['required', 'string', 'max:150'],
            'subjects.*.classroom' => ['required', 'string', 'max:50'],
        ], [
            'teacher_code.required' => 'กรุณากรอกรหัสอาจารย์',
            'teacher_code.unique' => 'รหัสอาจารย์นี้ถูกใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องอย่างน้อย 6 ตัวอักษร',
            'fullname.required' => 'กรุณากรอกชื่อ-สกุล',

            'subjects.required' => 'กรุณาเพิ่มรายวิชาที่สอนอย่างน้อย 1 รายวิชา',
            'subjects.min' => 'กรุณาเพิ่มรายวิชาที่สอนอย่างน้อย 1 รายวิชา',
            'subjects.*.subject_name.required' => 'กรุณากรอกชื่อรายวิชา',
            'subjects.*.department.required' => 'กรุณาเลือกสาขา',
            'subjects.*.classroom.required' => 'กรุณาเลือกชั้น',
        ]);

        $result = TeacherService::create($validated);
        if (!$result['success']) {
            return JsonResult::errors(null, $result['message'], 500);
        }
        return JsonResult::success($result['data'], $result['message']);
    }
}
