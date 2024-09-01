<?php

namespace App\Modules\Languages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Language extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'created_by',
        'updated_by'
    ];
}
