<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Student and Course Management</title>
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
        <h1>Student and Course Management</h1>
        <p>Use the links below to manage students and courses.</p>

        <ul>
            <li><a href="{{ route('students.index') }}">Manage students</a></li>
            <li><a href="{{ route('courses.index') }}">Manage courses</a></li>
        </ul>
    </main>
</body>
</html>
