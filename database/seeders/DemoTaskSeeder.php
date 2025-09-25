<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TaskCategory;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\TaskListOptions;

class DemoTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1. Reset related tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TaskListOptions::truncate();
        TaskList::truncate();
        Task::truncate();
        TaskCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // 1. Create TaskCategory
        $category = TaskCategory::create([
            'user_id' => 1, // adjust as needed
            'title' => 'Education',
            'description' => 'Educational related tasks',
        ]);

        // 2. Create Task
        $task = Task::create([
            'user_id' => 1, // adjust as needed
            'task_category_id' => $category->id,
            'type' => 'mcq',
            'code' => 'IHISTORY',
            'title' => 'History and Politics',
            'description' => 'MCQ Exam covering history and politics basics',
            'total_time' => 600, // 10 minutes
            'is_timebase' => true,
            'is_individual' => true,
        ]);

        $questions = [
            [
                'title' => "Who was the first President of India?",
                'options' => [
                    ['title' => 'Mahatma Gandhi', 'is_right' => false],
                    ['title' => 'Jawaharlal Nehru', 'is_right' => false],
                    ['title' => 'Rajendra Prasad', 'is_right' => true],
                    ['title' => 'Sardar Vallabhbhai Patel', 'is_right' => false],
                ],
            ],
            [
                'title' => "When did India gain independence?",
                'options' => [
                    ['title' => '26 January 1950', 'is_right' => false],
                    ['title' => '15 August 1947', 'is_right' => true],
                    ['title' => '2 October 1948', 'is_right' => false],
                    ['title' => '12 March 1930', 'is_right' => false],
                ],
            ],
            [
                'title' => "Who is known as the Father of the Nation?",
                'options' => [
                    ['title' => 'Subhas Chandra Bose', 'is_right' => false],
                    ['title' => 'Mahatma Gandhi', 'is_right' => true],
                    ['title' => 'Bal Gangadhar Tilak', 'is_right' => false],
                    ['title' => 'Bhagat Singh', 'is_right' => false],
                ],
            ],
            [
                'title' => "Which is the largest democracy in the world?",
                'options' => [
                    ['title' => 'United States', 'is_right' => false],
                    ['title' => 'India', 'is_right' => true],
                    ['title' => 'China', 'is_right' => false],
                    ['title' => 'Russia', 'is_right' => false],
                ],
            ],
            [
                'title' => "Who was the first Prime Minister of India?",
                'options' => [
                    ['title' => 'Mahatma Gandhi', 'is_right' => false],
                    ['title' => 'Rajendra Prasad', 'is_right' => false],
                    ['title' => 'Jawaharlal Nehru', 'is_right' => true],
                    ['title' => 'Indira Gandhi', 'is_right' => false],
                ],
            ],
            [
                'title' => "Which movement was led by Mahatma Gandhi in 1942?",
                'options' => [
                    ['title' => 'Non-Cooperation Movement', 'is_right' => false],
                    ['title' => 'Civil Disobedience Movement', 'is_right' => false],
                    ['title' => 'Quit India Movement', 'is_right' => true],
                    ['title' => 'Swadeshi Movement', 'is_right' => false],
                ],
            ],
            [
                'title' => "What is the capital of India?",
                'options' => [
                    ['title' => 'Mumbai', 'is_right' => false],
                    ['title' => 'Kolkata', 'is_right' => false],
                    ['title' => 'New Delhi', 'is_right' => true],
                    ['title' => 'Chennai', 'is_right' => false],
                ],
            ],
            [
                'title' => "Which political party led India’s independence struggle?",
                'options' => [
                    ['title' => 'Indian National Congress', 'is_right' => true],
                    ['title' => 'Bharatiya Janata Party', 'is_right' => false],
                    ['title' => 'Communist Party of India', 'is_right' => false],
                    ['title' => 'All India Forward Bloc', 'is_right' => false],
                ],
            ],
            [
                'title' => "Who wrote the Indian National Anthem?",
                'options' => [
                    ['title' => 'Bankim Chandra Chatterjee', 'is_right' => false],
                    ['title' => 'Rabindranath Tagore', 'is_right' => true],
                    ['title' => 'Sarojini Naidu', 'is_right' => false],
                    ['title' => 'Subhas Chandra Bose', 'is_right' => false],
                ],
            ],
            [
                'title' => "Which Article of the Indian Constitution guarantees equality?",
                'options' => [
                    ['title' => 'Article 21', 'is_right' => false],
                    ['title' => 'Article 15', 'is_right' => false],
                    ['title' => 'Article 14', 'is_right' => true],
                    ['title' => 'Article 19', 'is_right' => false],
                ],
            ],
        ];

        foreach ($questions as $q) {
            $taskList = TaskList::create([
                'task_id' => $task->id,
                'title' => $q['title'],
                'type' => 'que',
                'total_time' => 60,
                'is_timebase' => true,
            ]);

            foreach ($q['options'] as $opt) {
                TaskListOptions::create([
                    'task_list_id' => $taskList->id,
                    'title' => $opt['title'],
                    'type' => 'option',
                    'is_right' => $opt['is_right'],
                ]);
            }
        }
    }
}
