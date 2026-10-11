@php
    $student = $student ?? new \App\Models\Student();
@endphp

<x-students.form :student="$student" />
