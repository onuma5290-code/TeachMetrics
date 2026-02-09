<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    protected $table = 'teachers';

    protected $primaryKey = 'teacher_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'teacher_id',
        'teacher_code',
        'password',
        'fullname'
    ];

    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'teacher_code';
    }

    public function subjects()
    {
        return $this->hasMany(
            TeacherSubject::class,
            'teacher_id',
            'teacher_id'
        );
    }
}
