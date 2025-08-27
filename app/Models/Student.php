<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ledger;

class Student extends Model
{
    use HasFactory;
     public function ledgers()
    {
        return $this->hasMany(Ledger::class, 'student_id', 'id');
    }
}






