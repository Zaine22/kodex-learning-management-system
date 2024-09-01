<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $fillable=['user_id','professional_field_id','work_experience_year','teaching_experience_year','approve_status','approve_by'];
}
