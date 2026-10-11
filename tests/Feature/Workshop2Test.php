<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Workshop2Test extends TestCase
{
    use RefreshDatabase;

    public function test_students_index_displays_list(): void
    {
        $student = Student::create([
            'name' => 'Karuna Neupane',
            'email' => 'karuna@gmail.com',
            'phone' => '9812345678',
            'address' => 'Kathmandu',
            'date_of_birth' => '2002-05-10',
        ]);

        $response = $this->get(route('students.index'));
        $response->assertStatus(200);
        $response->assertSee('Karuna Neupane');
        $response->assertSee('karuna@gmail.com');
    }

    public function test_students_create_form_renders(): void
    {
        $response = $this->get(route('students.create'));
        $response->assertStatus(200);
        $response->assertSee('Create Student');
    }

    public function test_students_store_saves_and_redirects(): void
    {
        $data = [
            'name' => 'Ram Bahadur',
            'email' => 'ram@gmail.com',
            'phone' => '9812345678',
            'address' => 'Kathmandu',
            'date_of_birth' => '2000-01-01',
        ];

        $response = $this->post(route('students.store'), $data);
        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('students', ['email' => 'ram@gmail.com']);
    }

    public function test_students_show_displays_details_and_age(): void
    {
        $student = Student::create([
            'name' => 'Ram Bahadur',
            'email' => 'ram@gmail.com',
            'phone' => '9812345678',
            'address' => 'Kathmandu',
            'date_of_birth' => '2000-01-01',
        ]);

        $response = $this->get(route('students.show', $student));
        $response->assertStatus(200);
        $response->assertSee('Ram Bahadur');
        $this->assertNotNull($student->age);
    }

    public function test_students_update_updates_and_ignores_unique_email(): void
    {
        $student = Student::create([
            'name' => 'Ram Bahadur',
            'email' => 'ram@gmail.com',
            'phone' => '9812345678',
            'address' => 'Kathmandu',
            'date_of_birth' => '2000-01-01',
        ]);

        $response = $this->put(route('students.update', $student), [
            'name' => 'Ram Bahadur Updated',
            'email' => 'ram@gmail.com',
            'phone' => '9812345678',
            'address' => 'Pokhara',
            'date_of_birth' => '2000-01-01',
        ]);

        $response->assertRedirect(route('students.show', $student));
        $this->assertDatabaseHas('students', ['name' => 'Ram Bahadur Updated', 'address' => 'Pokhara']);
    }

    public function test_students_destroy_deletes_student(): void
    {
        $student = Student::create([
            'name' => 'Delete Me',
            'email' => 'delete@gmail.com',
            'phone' => '9812345678',
            'address' => 'Nowhere',
            'date_of_birth' => '2001-01-01',
        ]);

        $response = $this->delete(route('students.destroy', $student));
        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_courses_index_and_crud(): void
    {
        $course = Course::create([
            'name' => 'Advanced Full Stack Development',
            'description' => 'Laravel MVC & Blade Components',
            'duration' => 12,
            'fee' => 1000000.00,
            'difficulty' => 'Hard',
            'is_active' => true,
        ]);

        $response = $this->get(route('courses.index'));
        $response->assertStatus(200);
        $response->assertSee('Advanced Full Stack Development');

        $detailResponse = $this->get(route('courses.show', $course));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Laravel MVC & Blade Components');

        $updateResponse = $this->put(route('courses.update', $course), [
            'name' => 'Advanced Full Stack Development Refactored',
            'description' => 'Updated description',
            'duration' => 14,
            'fee' => 1200000.00,
            'difficulty' => 'Medium',
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect(route('courses.show', $course));
        $this->assertDatabaseHas('courses', ['name' => 'Advanced Full Stack Development Refactored']);

        $deleteResponse = $this->delete(route('courses.destroy', $course));
        $deleteResponse->assertRedirect(route('courses.index'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
