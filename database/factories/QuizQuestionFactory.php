<?php

namespace Database\Factories;

use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizQuestion>
 */
class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $correctAnswer = $this->faker->numberBetween(1, 4);

        $question = [
            'question' => $this->faker->sentence(12) . '?',
            'answer_1' => $this->faker->sentence(6),
            'answer_2' => $this->faker->sentence(6),
            'answer_3' => $this->faker->sentence(6),
            'answer_4' => $this->faker->sentence(6),
            'correct_answer' => $correctAnswer,
        ];

        return self::markCorrectAnswer($question);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function questionSet(): array
    {
        return array_map(
            fn (array $question) => self::markCorrectAnswer($question),
            [
            [
                'question' => 'You see another player rob a store while you\'re undercover as a police officer. In real life, you wouldn\'t know about the robbery beforehand. What should you do in-game?',
                'answer_1' => 'Ignore it, you weren\'t there to witness the crime.',
                'answer_2' => 'Call for backup and confront the robber.',
                'answer_3' => 'Wait for the robber to leave and then investigate the scene.',
                'answer_4' => 'Message the robber and ask them why they robbed the store.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'You\'re in a car chase with the police. Your car is smoking and about to explode. You can ram another player\'s car to stop yours. Is this allowed?',
                'answer_1' => 'Yes, it\'s the only way to save yourself.',
                'answer_2' => 'No, you can\'t force roleplay situations on other players.',
                'answer_3' => 'Only if the other player is also involved in the chase.',
                'answer_4' => 'Yes, but you\'re responsible for any damage you cause.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'You discover a hidden stash of illegal weapons while exploring the woods. What can you do?',
                'answer_1' => 'Announce your find in global chat and ask who wants to buy them.',
                'answer_2' => 'Keep them for yourself and use them in future situations.',
                'answer_3' => 'Report your findings to the police and roleplay how you discovered them.',
                'answer_4' => 'Sell them on a third-party website for real money.',
                'correct_answer' => 3,
            ],
            [
                'question' => 'You are a paramedic and arrive at a scene where a player is critically injured. Another player, not a medical professional, keeps trying to heal the injured player with bandages. What should you do?',
                'answer_1' => 'Ignore them and treat the injured player yourself.',
                'answer_2' => 'Verbally abuse them for interfering with medical care.',
                'answer_3' => 'Explain calmly that only paramedics can treat critical injuries and ask them to step aside.',
                'answer_4' => 'Let them try their best, maybe they can save the player.',
                'correct_answer' => 3,
            ],
            [
                'question' => 'You are arrested by the police for a crime you committed in-game.  What should you do?',
                'answer_1' => 'Argue with the officers and try to escape.',
                'answer_2' => 'Roleplay being arrested and cooperate with the police within reason.',
                'answer_3' => 'Log out of the server and rejoin to avoid punishment.',
                'answer_4' => 'Threaten to report the arresting officers for false arrest.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'You are disappointed with a recent interaction with another player. What is the best course of action?',
                'answer_1' => 'Publicly shame the player in chat and call them names.',
                'answer_2' => 'Report the incident to the server admins with evidence.',
                'answer_3' => 'Seek revenge on the player in-game.',
                'answer_4' => 'Ignore it and hope it doesn\'t happen again.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'You are roleplaying as a police officer and see another player breaking the law. What should you do?',
                'answer_1' => 'Ignore the crime, it\'s not your responsibility.',
                'answer_2' => 'Roleplay investigating the crime and make an arrest if necessary.',
                'answer_3' => 'Message the player and ask them to stop breaking the law.',
                'answer_4' => 'Report the player to the admins and let them handle it.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'While running a clothing store, a player offers to buy a large amount of expensive clothes at once for an unrealistic price. What should you do?',
                'answer_1' => 'Accept the offer, more money is always good.',
                'answer_2' => 'Ask the player why they want to buy so many clothes at once.',
                'answer_3' => 'Ignore the offer and hope for a more reasonable customer.',
                'answer_4' => 'Sell them the clothes anyway, but report them to the admins later.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'You are creating a backstory for your character.  What should you avoid including?',
                'answer_1' => 'A history of military service.',
                'answer_2' => 'Knowing information about',
                'answer_3' => 'A tragic event that motivates your character\'s actions.',
                'answer_4' => 'A detailed family history with many relatives.',
                'correct_answer' => 2,
            ],
        ]
        );
    }

    /**
     * @param array<string, mixed> $question
     * @return array<string, mixed>
     */
    protected static function markCorrectAnswer(array $question): array
    {
        $answerKey = 'answer_' . $question['correct_answer'];

        if (isset($question[$answerKey])) {
            $question[$answerKey] .= ' (Clique sur moi pour la bonne réponse)';
        }

        return $question;
    }
}
