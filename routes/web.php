<?php

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/', fn () => redirect()->route('students.index'));

/* ===================== STUDENTS ===================== */

// List
Route::get('/students', function () {
    return view('student.list', ['students' => Student::all()]);
})->name('students.index');

// Create form
Route::get('/students/create', function () {
    return view('student.create');
})->name('students.create');

// Store
Route::post('/students', function (Request $request) {
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255|unique:students,email',
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
})->name('students.store');

// Detail
Route::get('/students/{id}', function ($id) {
    return view('student.detail', ['student' => Student::findOrFail($id)]);
})->name('students.show');

// Edit form
Route::get('/students/{id}/edit', function ($id) {
    return view('student.edit', ['student' => Student::findOrFail($id)]);
})->name('students.edit');

// Update
Route::put('/students/{id}', function (Request $request, $id) {
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => ['required', 'email', 'max:255',
                            Rule::unique('students')->ignore($student->id)],
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student->update($validated);

    return redirect('/students/' . $student->id)
        ->with('success', 'Student updated successfully!');
})->name('students.update');

// Delete
Route::delete('/students/{id}', function ($id) {
    Student::findOrFail($id)->delete();

    return redirect('/students')->with('success', 'Student deleted successfully!');
})->name('students.destroy');

/* ===================== COURSES ===================== */

$courseRules = [
    'name'        => 'required|string|max:255',
    'description' => 'nullable|string|max:1000',
    'duration'    => 'required|integer|min:1|max:520',
    'fee'         => 'required|numeric|min:0|max:99999999.99',
    'difficulty'  => ['required', Rule::in(['Easy', 'Medium', 'Hard'])],
    'is_active'   => 'required|boolean',
];

Route::get('/courses', function () {
    return view('course.list', ['courses' => Course::all()]);
})->name('courses.index');

Route::get('/courses/create', function () {
    return view('course.create');
})->name('courses.create');

Route::post('/courses', function (Request $request) use ($courseRules) {
    $course = Course::create($request->validate($courseRules));

    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");
})->name('courses.store');

Route::get('/courses/{id}', function ($id) {
    return view('course.detail', ['course' => Course::findOrFail($id)]);
})->name('courses.show');

Route::get('/courses/{id}/edit', function ($id) {
    return view('course.edit', ['course' => Course::findOrFail($id)]);
})->name('courses.edit');

Route::put('/courses/{id}', function (Request $request, $id) use ($courseRules) {
    $course = Course::findOrFail($id);
    $course->update($request->validate($courseRules));

    return redirect('/courses/' . $course->id)
        ->with('success', 'Course updated successfully!');
})->name('courses.update');

Route::delete('/courses/{id}', function ($id) {
    Course::findOrFail($id)->delete();

    return redirect('/courses')->with('success', 'Course deleted successfully!');
})->name('courses.destroy');