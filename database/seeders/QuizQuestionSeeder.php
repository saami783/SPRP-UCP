<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Database\Factories\QuizQuestionFactory;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = QuizQuestionFactory::questionSet();

        QuizQuestion::query()->delete();

        QuizQuestion::factory()
            ->count(count($questions))
            ->sequence(...$questions)
            ->create();
    }
}
