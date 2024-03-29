<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function allowance(){
        return $this->belongsToMany(Allowance::class,'salary_structure_allowance');
    }
}
