<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->name }} - Student and Course Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav aria-label="Main navigation">
        <a href="{{ route('home') }}">Home</a> |
        <a href="{{ route('students.index') }}">Students</a> |
        <a href="{{ route('courses.index') }}">Courses</a>
    </nav>
    <hr>

    <main>
        @if (session('success'))
            <p class="success" role="status">{{ session('success') }}</p>
        @endif
        <h1>{{ $course->name }}</h1>
        <p><a href="{{ route('courses.index') }}">Back to courses</a></p>

        <dl>
            <dt>Description</dt>
            <dd>{{ $course->description }}</dd>
            <dt>Duration</dt>
            <dd>{{ $course->duration }} {{ (int) $course->duration === 1 ? 'week' : 'weeks' }}</dd>
            <dt>Fee</dt>
            <dd>{{ number_format((float) $course->fee, 2) }}</dd>
            <dt>Difficulty</dt>
            <dd>{{ $course->difficulty }}</dd>
            <dt>Status</dt>
            <dd>{{ $course->is_active ? 'Active' : 'Inactive' }}</dd>
            <dt>Created at</dt>
            <dd>{{ $course->created_at->format('j M Y, H:i') }}</dd>
            <dt>Updated at</dt>
            <dd>{{ $course->updated_at->format('j M Y, H:i') }}</dd>
        </dl>

        <a href="{{ route('courses.edit', $course) }}">Edit course</a>
        <form method="POST" action="{{ route('courses.destroy', $course) }}" class="delete-form" data-confirm="Delete this course?">
            @csrf
            @method('DELETE')
            <button type="submit" aria-label="Delete course {{ $course->name }}">Delete</button>
        </form>
    </main>
</body>
</html>
