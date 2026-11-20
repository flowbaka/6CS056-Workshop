<?php

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

Route::view('/', 'welcome')->name('home');

Route::get('/students', function (): View {
    return view('student.list', ['students' => Student::all()]);
})->name('students.index');

Route::get('/students/create', function (): View {
    return view('student.create', ['student' => new Student]);
})->name('students.create');

Route::post('/students', function (Request $request): RedirectResponse {
    $email = $request->input('email');
    if (is_string($email)) {
        $request->merge(['email' => Str::lower($email)]);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:students,email',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    if (isset($validated['date_of_birth'])) {
        $validated['date_of_birth'] = Carbon::parse($validated['date_of_birth'])->toDateString();
    }

    $student = Student::create($validated);

    return redirect()->route('students.index')->with('success', "Student {$student->name} created successfully!");
})->name('students.store');

Route::get('/students/{student}', function (string $studentId): View {
    return view('student.detail', ['student' => Student::findOrFail($studentId)]);
})->whereNumber('student')->name('students.show');

Route::get('/students/{student}/edit', function (string $studentId): View {
    return view('student.edit', ['student' => Student::findOrFail($studentId)]);
})->whereNumber('student')->name('students.edit');

Route::match(['put', 'patch'], '/students/{student}', function (Request $request, string $studentId): RedirectResponse {
    $student = Student::findOrFail($studentId);
    $email = $request->input('email');
    if (is_string($email)) {
        $request->merge(['email' => Str::lower($email)]);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student)],
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    if (isset($validated['date_of_birth'])) {
        $validated['date_of_birth'] = Carbon::parse($validated['date_of_birth'])->toDateString();
    }

    $student->update($validated);

    return redirect()->route('students.show', $student)->with('success', 'Student updated successfully!');
})->whereNumber('student')->name('students.update');

Route::delete('/students/{student}', function (string $studentId): RedirectResponse {
    Student::findOrFail($studentId)->delete();

    return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
})->whereNumber('student')->name('students.destroy');

Route::get('/courses', function (): View {
    return view('course.list', ['courses' => Course::all()]);
})->name('courses.index');

Route::get('/courses/create', function (): View {
    return view('course.create', ['course' => new Course]);
})->name('courses.create');

Route::post('/courses', function (Request $request): RedirectResponse {
    $request->merge(['is_active' => $request->input('is_active', false)]);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:10000'],
        'duration' => ['required', 'integer', 'min:1', 'max:65535'],
        'fee' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
        'difficulty' => ['required', Rule::in(Course::DIFFICULTIES)],
        'is_active' => ['boolean'],
    ], attributes: ['duration' => 'duration in weeks', 'is_active' => 'active status']);

    $course = Course::create($validated);

    return redirect()->route('courses.index')->with('success', "Course {$course->name} created successfully!");
})->name('courses.store');

Route::get('/courses/{course}', function (string $courseId): View {
    return view('course.detail', ['course' => Course::findOrFail($courseId)]);
})->whereNumber('course')->name('courses.show');

Route::get('/courses/{course}/edit', function (string $courseId): View {
    return view('course.edit', ['course' => Course::findOrFail($courseId)]);
})->whereNumber('course')->name('courses.edit');

Route::match(['put', 'patch'], '/courses/{course}', function (Request $request, string $courseId): RedirectResponse {
    $course = Course::findOrFail($courseId);
    $request->merge(['is_active' => $request->input('is_active', false)]);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:10000'],
        'duration' => ['required', 'integer', 'min:1', 'max:65535'],
        'fee' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
        'difficulty' => ['required', Rule::in(Course::DIFFICULTIES)],
        'is_active' => ['boolean'],
    ], attributes: ['duration' => 'duration in weeks', 'is_active' => 'active status']);

    $course->update($validated);

    return redirect()->route('courses.show', $course)->with('success', 'Course updated successfully!');
})->whereNumber('course')->name('courses.update');

Route::delete('/courses/{course}', function (string $courseId): RedirectResponse {
    Course::findOrFail($courseId)->delete();

    return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
})->whereNumber('course')->name('courses.destroy');
