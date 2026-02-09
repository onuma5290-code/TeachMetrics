<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['student_code', 'password', 'fullname', 'department', 'classroom'];
    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'student_code';
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'student_id', 'student_id');
    }
}
