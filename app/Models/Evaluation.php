<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluations';
    protected $primaryKey = 'evaluation_id';
    public $timestamps = true;

    protected $fillable = [
        'subject_id',
        'student_id',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
        'question_5',
        'question_6',
        'question_7',
        'question_8',
        'question_9',
        'question_10',
        'question_11',
        'question_12',
        'question_13',
        'question_14',
        'question_15',
        'evaluation_note',
        'created_at',
    ];
    protected $casts = [
        'teacher_id' => 'int',
        'student_id' => 'int',
        'subject_id' => 'int',
        'q1' => 'int',
        'q2' => 'int',
        'q3' => 'int',
        'q4' => 'int',
        'q5' => 'int',
        'q6' => 'int',
        'q7' => 'int',
        'q8' => 'int',
        'q9' => 'int',
        'q10' => 'int',
        'q11' => 'int',
        'q12' => 'int',
        'q13' => 'int',
        'q14' => 'int',
        'q15' => 'int',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(TeacherSubject::class, 'subject_id', 'subject_id');
    }
}
