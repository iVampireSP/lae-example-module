<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    // auto increment
    public $incrementing = false;
    public $timestamps = false;
}
