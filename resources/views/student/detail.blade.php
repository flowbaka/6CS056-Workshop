<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $student->name }} - Student and Course Management</title>
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
        @php
            $birthday = $student->date_of_birth ? \Illuminate\Support\Carbon::parse($student->date_of_birth) : null;
        @endphp

        <h1>{{ $student->name }}</h1>
        <p><a href="{{ route('students.index') }}">Back to students</a></p>

        <dl>
            <dt>ID</dt>
            <dd>{{ $student->id }}</dd>
            <dt>Age</dt>
            <dd>{{ $birthday?->age ?? 'Not available' }}</dd>
            <dt>Email</dt>
            <dd>{{ $student->email }}</dd>
            <dt>Phone</dt>
            <dd>{{ $student->phone }}</dd>
            <dt>Address</dt>
            <dd>{{ $student->address ?? 'Not provided' }}</dd>
            <dt>Date of birth</dt>
            <dd>{{ $birthday?->format('d M Y') ?? 'Not provided' }}</dd>
            <dt>Created at</dt>
            <dd>{{ $student->created_at->format('j M Y, H:i') }}</dd>
            <dt>Updated at</dt>
            <dd>{{ $student->updated_at->format('j M Y, H:i') }}</dd>
        </dl>

        <a href="{{ route('students.edit', $student) }}">Edit student</a>
        <form method="POST" action="{{ route('students.destroy', $student) }}" class="delete-form" data-confirm="Delete this student?">
            @csrf
            @method('DELETE')
            <button type="submit" aria-label="Delete student {{ $student->name }}">Delete</button>
        </form>
    </main>
</body>
</html>
