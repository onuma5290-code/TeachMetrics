# Test Plan: Teacher Evaluation System (TeachMetrics)

## 1. Introduction
เอกสารนี้ระบุแผนการทดสอบ (Test Plan) สำหรับระบบประเมินการสอนของครู (Teacher Evaluation System) ซึ่งพัฒนาด้วย Laravel Framework การทดสอบจะครอบคลุมฟังก์ชันการทำงานหลัก (Functional Testing) สิทธิ์การเข้าถึง (Authentication/Authorization) และความถูกต้องของข้อมูล (Data Integrity)

## 2. Test Strategy
*   **Unit Testing**: ทดสอบการทำงานของ Service และ Model (e.g., `EvaluateService`, `TeacherService`)
*   **Feature Testing**: ทดสอบ Flow การใช้งานผ่าน HTTP Request (Routes & Controllers)
*   **Database Testing**: ทดสอบการบันทึกและดึงข้อมูลจากฐานข้อมูล MySQL

## 3. Test Scopes & Cases

### 3.1 Authentication & Authorization (ระบบยืนยันตัวตน)
| Test ID | Feature | Test Case Description | Expected Result |
| :--- | :--- | :--- | :--- |
| **AUTH-01** | Student Register | ลงทะเบียนนักเรียนด้วยข้อมูลที่ถูกต้อง | บันทึกข้อมูลลงตาราง `students` และ Redirect ไปหน้า Login |
| **AUTH-02** | Teacher Register | ลงทะเบียนครูด้วยข้อมูลที่ถูกต้อง | บันทึกข้อมูลลงตาราง `teachers` และ Redirect ไปหน้า Login |
| **AUTH-03** | Login (Student) | ล็อกอินด้วย Student Account | เข้าสู่หน้า `/dashboard_student` ได้สำเร็จ |
| **AUTH-04** | Login (Teacher) | ล็อกอินด้วย Teacher Account | เข้าสู่หน้า `/dashboard_teacher` ได้สำเร็จ |
| **AUTH-05** | Unauthorized Access | พยายามเข้า `/dashboard_teacher` โดยไม่ได้ล็อกอิน | Redirect กลับไปหน้า Login หรือแสดง Error 401/403 |
| **AUTH-06** | Role Isolation | ใช้ Student Account พยายามเข้าหน้า Teacher Dashboard | Access Denied / Redirect กลับ |

### 3.2 Student Module (ส่วนของนักเรียน)
| Test ID | Feature | Test Case Description | Expected Result |
| :--- | :--- | :--- | :--- |
| **STU-01** | View Dashboard | เข้าหน้า Dashboard นักเรียน | แสดงรายชื่อครู/วิชาที่ลงทะเบียนเรียน (`teacher_lists`) |
| **STU-02** | View Evaluation Form | คลิกเลือกวิชาเพื่อทำการประเมิน (`/evaluate/{id}`) | แสดงแบบฟอร์มประเมินพร้อมข้อมูลรายวิชาที่ถูกต้อง |
| **STU-03** | Submit Evaluation | กรอกคะแนนครบ 15 ข้อ และบันทึก | ข้อมูลถูกบันทึกลงตาราง `evaluations` ครบถ้วน |
| **STU-04** | Validate Input | กดส่งแบบประเมินโดยไม่กรอกคะแนนบางข้อ | ระบบแจ้งเตือนให้กรอกให้ครบ (Validation Error) |
| **STU-05** | Note Submission | กรอกข้อเสนอแนะ (`evaluation_note`) | ข้อความถูกบันทึกถูกต้อง |

### 3.3 Teacher Module (ส่วนของครู)
| Test ID | Feature | Test Case Description | Expected Result |
| :--- | :--- | :--- | :--- |
| **TCH-01** | View Dashboard | เข้าหน้า Dashboard ครู | แสดงข้อมูลส่วนตัวและรายการรายวิชาที่สอน |
| **TCH-02** | View Scores | ดูคะแนนประเมินใน Dashboard | แสดงคะแนนรวมหรือคะแนนเฉลี่ยที่ดึงจาก `EvaluateService::getScoreByTeacherId` ได้ถูกต้อง |

## 4. Database Verification
*   **Table `evaluations`**: ตรวจสอบว่า `subject_id` และ `student_id` เชื่อมโยงถูกต้อง และคะแนน `question_1` ถึง `question_15` เป็นตัวเลข 1-5
*   **Table `students`/`teachers`**: ตรวจสอบการ Hash Password ก่อนบันทึก

## 5. Tools
*   **PHPUnit**: สำหรับรัน Automated Tests
*   **Postman/Browser**: สำหรับทำ Manual Testing
