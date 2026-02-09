<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResult;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public static function loginStudent(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'กรุณาใส่ข้อมูลให้ครบถ้วน!',
            'password.required' => 'กรุณาใส่ข้อมูลให้ครบถ้วน!',
        ]);
        $result = AuthService::loginStudent($validated);
        if ($result['success'] == false) {
            return JsonResult::errors($result['data'], $result['message']);
        }
        return JsonResult::success($result['data'], $result['message']);
    }
    public static function loginTeacher(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'กรุณาใส่ข้อมูลให้ครบถ้วน!',
            'password.required' => 'กรุณาใส่ข้อมูลให้ครบถ้วน!',
        ]);
        $result = AuthService::loginTeacher($validated);
        if ($result['success'] == false) {
            return JsonResult::errors($result['data'], $result['message']);
        }
        return JsonResult::success($result['data'], $result['message']);
    }
    public function logout(Request $request)
    {
        if (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        }
        if (Auth::guard('teacher')->check()) {
            Auth::guard('teacher')->logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'user_code' => ['required'],
            'password' => ['required'],
            'user_type' => ['required', 'in:student,teacher'],
        ]);

        $data = [
            'username' => $validated['user_code'],
            'password' => $validated['password'],
        ];

        if ($validated['user_type'] === 'student') {
            $result = AuthService::loginStudent($data);
        } else {
            $result = AuthService::loginTeacher($data);
        }

        if ($result['success'] === false) {
            // For web tests, redirect back with errors
            return back()->withErrors(['login' => $result['message']]);
        }

        // Redirect to intended dashboard
        return redirect($result['data']['redirect']);
    }
}
