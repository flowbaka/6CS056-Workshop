<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['name', 'description', 'duration', 'fee', 'difficulty', 'is_active'];

    public const DIFFICULTIES = ['Easy', 'Medium', 'Hard'];

    /** @var array<string, mixed> */
    protected $attributes = ['is_active' => true];
}
