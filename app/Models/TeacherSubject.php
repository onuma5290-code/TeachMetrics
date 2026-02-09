<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    protected $table = 'teacher_subjects';
    protected $primaryKey = 'subject_id';

    protected $fillable = [
        'teacher_id',
        'subject_name',
        'department',
        'classroom'
    ];

    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id',
            'teacher_id'
        );
    }
}
