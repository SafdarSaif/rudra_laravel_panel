<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Ledger extends Model
{
    use HasFactory;
     protected $table = 'ledgers'; // if not default

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}




