<?php

namespace App\Modules\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'guard_name',
    ];
}
