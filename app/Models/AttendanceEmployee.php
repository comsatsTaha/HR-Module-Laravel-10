<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceEmployee extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function employee(){
        return $this->hasOne(Employee::class);
    }

   

}
