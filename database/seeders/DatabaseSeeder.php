<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $user2 = User::factory()->create([
            'name' => 'student',
            'email' => 'student@example.com',
            'password' => 'password',
            'section_id' => 1,
        ]);
        $user3 = User::factory()->create([
            'name' => 'teacher',
            'email' => 'teacher@example.com',
            'password' => 'password',
        ]);

        $role = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'student']);
        $role3 = Role::create(['name' => 'instructor']);

        $permission = Permission::create(['name' => 'edit modules']);
        $user->assignRole($role);
        $user2->assignRole($role2);
        $user3->assignRole($role3);

        DB::table('modules')->insert([
            [
                'name' => 'Introduction to Programming',
                'description' => 'A beginner-friendly course introducing programming concepts.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Web Development',
                'description' => 'Learn how to develop web applications using modern technologies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Database Management',
                'description' => 'Explore the concepts and techniques of managing databases.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Learn how to build mobile applications for Android and iOS platforms.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Data Structures and Algorithms',
                'description' => 'Study fundamental data structures and algorithms used in computer science.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('lectures')->insert([
            [
                'module_id' => 1, // Assuming 'Introduction to Programming' module has ID 1
                'name' => 'Introduction to Variables',
                'description' => 'Understanding variables and their usage in programming.',
                'content' => 'This lecture covers the basic concepts of variables in programming...',
                'file' => 'intro_to_variables.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_id' => 2, // Assuming 'Web Development' module has ID 2
                'name' => 'HTML Basics',
                'description' => 'Learning the basics of HTML for web development.',
                'content' => 'HTML stands for Hyper Text Markup Language...',
                'file' => 'html_basics.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more lectures as needed
        ]);

        DB::table('activities')->insert([
            [
                'lecture_id' => 1, // Assuming 'Introduction to Variables' lecture has ID 1
                'name' => 'Variable Quiz',
                'description' => 'A quiz to test your understanding of variables.',
                'type' => 'Quiz',
                'time' => 30, // Time in minutes
                'dateGiven' => now(),
                'deadline' => now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lecture_id' => 1, // Assuming 'HTML Basics' lecture has ID 2
                'name' => 'HTML Exercise',
                'description' => 'Practice exercise to reinforce HTML concepts.',
                'type' => 'Fill in the blanks',
                'time' => 45, // Time in minutes
                'dateGiven' => now(),
                'deadline' => now()->addDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more activities as needed
        ]);

        DB::table('sections')->insert([
            [
                'name' => 'Section A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Section B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sections as needed
        ]);

        DB::table('questions')->insert([
            [
                'activity_id' => 1,
                'question' => '1. What is the keyword for variable declaration integer?',
                'points' => 2,
            ],

            [
                'activity_id' => 1,
                'question' => '2. What is the keyword for variable declaration integer?',
                'points' => 2,
            ],

            [
                'activity_id' => 1,
                'question' => '3. What is the keyword for variable declaration integer?',
                'points' => 2,
            ],

            [
                'activity_id' => 1,
                'question' => '4. What is the keyword for variable declaration integer?',
                'points' => 2,
            ],

            [
                'activity_id' => 2,
                'question' => '1. This ___ the day that we met. ___ am sorry I forgot our anniversary, but I promise to make it up to you with a special dinner tonight. ___ was such a memorable moment when our eyes first locked, and ___ knew right then that ___ had found someone truly special.',
                'points' => 5,
            ],

            [
                'activity_id' => 2,
                'question' => '2. This ___ the day that we met. ___ am sorry I forgot our anniversary, but I promise to make it up to you with a special dinner tonight. ___ was such a memorable moment when our eyes first locked, and ___ knew right then that ___ had found someone truly special.',
                'points' => 5,
            ]
        ]);

        DB::table('choices')->insert([
            [
                'question_id' => 1,
                'choice' => 'int',
                'is_correct' => true,
            ],
            [
                'question_id' => 1,
                'choice' => 'boolean',
                'is_correct' => false,
            ],
            [
                'question_id' => 2,
                'choice' => 'int',
                'is_correct' => true,
            ],
            [
                'question_id' => 2,
                'choice' => 'string',
                'is_correct' => false,
            ],
            [
                'question_id' => 3,
                'choice' => 'int',
                'is_correct' => true,
            ],
            [
                'question_id' => 3,
                'choice' => 'boolean',
                'is_correct' => false,
            ],
            [
                'question_id' => 4,
                'choice' => 'int',
                'is_correct' => true,
            ],
            [
                'question_id' => 4,
                'choice' => 'boolean',
                'is_correct' => false,
            ],

            [
                'question_id' => 5,
                'choice' => 'is',
                'is_correct' => true,
            ],
            [
                'question_id' => 5,
                'choice' => 'I',
                'is_correct' => true,
            ],
            [
                'question_id' => 5,
                'choice' => 'It',
                'is_correct' => true,
            ],
            [
                'question_id' => 5,
                'choice' => 'I',
                'is_correct' => true,
            ],
            [
                'question_id' => 5,
                'choice' => 'I',
                'is_correct' => true,
            ], [
                'question_id' => 6,
                'choice' => 'is',
                'is_correct' => true,
            ],
            [
                'question_id' => 6,
                'choice' => 'I',
                'is_correct' => true,
            ],
            [
                'question_id' => 6,
                'choice' => 'It',
                'is_correct' => true,
            ],
            [
                'question_id' => 6,
                'choice' => 'I',
                'is_correct' => true,
            ],
            [
                'question_id' => 6,
                'choice' => 'I',
                'is_correct' => true,
            ]

        ]);


    }
}
