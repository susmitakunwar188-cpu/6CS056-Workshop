<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Student::truncate();
        Course::truncate();

        Student::create([
            'name' => 'Karuna Neupane',
            'email' => 'karuna@gmail.com',
            'phone' => '9812345678',
            'address' => 'Kathmandu',
            'date_of_birth' => '2002-05-10',
        ]);

        Student::create([
            'name' => 'Susmita Kunwar',
            'email' => 'sushi@gmail.com',
            'phone' => '9800000000',
            'address' => 'Pokhara',
            'date_of_birth' => '2001-08-15',
        ]);

        Student::create([
            'name' => 'Dipika Rijal',
            'email' => 'dipu@gmail.com',
            'phone' => '9801234567',
            'address' => 'Lalitpur',
            'date_of_birth' => '2002-11-20',
        ]);

        Student::create([
            'name' => 'Shikha Pandey',
            'email' => 'shikhu@gmail.com',
            'phone' => '9812309874',
            'address' => 'Bhaktapur',
            'date_of_birth' => '2003-01-25',
        ]);

        Course::create([
            'name' => 'Advanced Full Stack Development',
            'description' => 'Comprehensive full stack module covering MVC architecture, Blade layouts, and database operations.',
            'duration' => 12,
            'fee' => 1000000.00,
            'difficulty' => 'Hard',
            'is_active' => true,
        ]);
    }
}
