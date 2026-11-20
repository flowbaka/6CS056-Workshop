<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students - Student and Course Management</title>
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
        <h1>Students</h1>
        <p><a href="{{ route('students.create') }}">Create Student</a></p>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}">View</a>
                                <a href="{{ route('students.edit', $student) }}">Edit</a>
                                <form method="POST" action="{{ route('students.destroy', $student) }}" class="delete-form" data-confirm="Delete this student?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Delete student {{ $student->name }}">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No students found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
