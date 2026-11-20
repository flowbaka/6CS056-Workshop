<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['name', 'email', 'phone', 'address', 'date_of_birth'];
}
