<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\DB;

class EvaluateService
{
    public static function create(int $studentId, int $subjectId, array $data): array
    {
        try {
            $exists = Evaluation::where('student_id', $studentId)
                ->where('subject_id', $subjectId)
                ->exists();

            if ($exists) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'คุณได้ประเมินรายวิชานี้ไปแล้ว'
                ];
            }

            $payload = [
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'evaluation_note' => $data['evaluation_note'] ?? null,
            ];

            for ($i = 1; $i <= 15; $i++) {
                $payload["question_$i"] = (int)($data["question_$i"] ?? 0);
            }

            $row = Evaluation::create($payload);

            return [
                'success' => true,
                'data' => $row,
                'message' => 'บันทึกแบบประเมินเรียบร้อยแล้ว'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'data' => null,
                'message' => $th->getMessage()
            ];
        }
    }
    public static function show($subject_id)
    {
        $student = auth('student')->user();
        return TeacherSubject::with('teacher')
            ->where('subject_id', $subject_id)
            ->firstOrFail();
    }

    public static function getScoreByTeacherId($teacherId, $filters = [])
    {
        $query = DB::table('evaluations as e')
            ->join('teacher_subjects as s', 'e.subject_id', '=', 's.subject_id')
            ->where('s.teacher_id', $teacherId);

        // Optional filters
        if (!empty($filters['subject_id'])) {
            $query->where('e.subject_id', $filters['subject_id']);
        }

        // ✅ จำนวนผู้ประเมิน (distinct student)
        $count = (clone $query)
            ->distinct('e.student_id')
            ->count('e.student_id');

        // ✅ ค่าเฉลี่ย 15 ข้อ
        $avgRow = (clone $query)->selectRaw("
            AVG(question_1)  as q1,
            AVG(question_2)  as q2,
            AVG(question_3)  as q3,
            AVG(question_4)  as q4,
            AVG(question_5)  as q5,
            AVG(question_6)  as q6,
            AVG(question_7)  as q7,
            AVG(question_8)  as q8,
            AVG(question_9)  as q9,
            AVG(question_10) as q10,
            AVG(question_11) as q11,
            AVG(question_12) as q12,
            AVG(question_13) as q13,
            AVG(question_14) as q14,
            AVG(question_15) as q15
        ")->first();

        $labels = self::questionLabels();

        $items = [];

        for ($i = 1; $i <= 15; $i++) {
            $key = "q{$i}";
            $items[] = [
                'key' => $key,
                'q'   => $labels[$i],
                'avg' => $avgRow?->$key ? round($avgRow->$key, 2) : 0.00
            ];
        }

        return [
            'count' => $count,
            'items' => $items,
        ];
    }


    public static function questionLabels(): array
    {
        return [
            1  => '1. อาจารย์เตรียมการสอนมาเป็นอย่างดี',
            2  => '2. อาจารย์อธิบายเนื้อหาได้ชัดเจนและเข้าใจง่าย',
            3  => '3. อาจารย์สอนตรงตามแผนการสอนที่กำหนดไว้',
            4  => '4. เนื้อหาที่สอนมีความเหมาะสมกับระดับผู้เรียน',
            5  => '5. เนื้อหามีความทันสมัยและสอดคล้องกับสถานการณ์ปัจจุบัน',
            6  => '6. อาจารย์เชื่อมโยงเนื้อหากับการนำไปใช้งานจริงได้ดี',
            7  => '7. อาจารย์ใช้สื่อการสอนได้อย่างเหมาะสม',
            8  => '8. สื่อการสอนช่วยให้นักเรียนเข้าใจบทเรียนได้ดียิ่งขึ้น',
            9  => '9. อาจารย์กระตุ้นให้นักเรียนมีส่วนร่วมในการเรียนการสอน',
            10 => '10. อาจารย์เปิดโอกาสให้นักเรียนซักถามและแสดงความคิดเห็น',
            11 => '11. บรรยากาศในการเรียนการสอนเป็นกันเองและน่าเรียน',
            12 => '12. อาจารย์ตรงต่อเวลาในการสอน',
            13 => '13. อาจารย์มีความรับผิดชอบต่อหน้าที่การสอน',
            14 => '14. อาจารย์ปฏิบัติต่อนักเรียนอย่างเป็นธรรมและให้เกียรติ',
            15 => '15. ความพึงพอใจโดยรวมต่อการเรียนการสอนของอาจารย์',
        ];
    }
}
