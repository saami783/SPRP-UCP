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
                'question' => 'Vous voyez un autre joueur braquer un magasin pendant que vous êtes infiltré en tant que policier. En réalité, vous ne connaîtriez pas ce braquage à l\'avance. Que devez-vous faire en jeu ?',
                'answer_1' => 'L\'ignorer, vous n\'étiez pas sur place pour être témoin du crime.',
                'answer_2' => 'Demander des renforts et confronter le braqueur.',
                'answer_3' => 'Attendre que le braqueur parte, puis enquêter sur la scène.',
                'answer_4' => 'Envoyer un message au braqueur pour lui demander pourquoi il a braqué le magasin.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'Vous êtes poursuivi en voiture par la police. Votre véhicule fume et est sur le point d\'exploser. Vous pouvez percuter la voiture d\'un autre joueur pour arrêter la vôtre. Est-ce autorisé ?',
                'answer_1' => 'Oui, c\'est le seul moyen de vous sauver.',
                'answer_2' => 'Non, vous ne pouvez pas imposer des situations roleplay à d\'autres joueurs.',
                'answer_3' => 'Seulement si l\'autre joueur est aussi impliqué dans la poursuite.',
                'answer_4' => 'Oui, mais vous êtes responsable de tous les dégâts causés.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'Vous découvrez une cache d\'armes illégales en explorant les bois. Que pouvez-vous faire ?',
                'answer_1' => 'Annoncer votre découverte dans le chat global et demander qui veut les acheter.',
                'answer_2' => 'Les garder pour vous et les utiliser plus tard.',
                'answer_3' => 'Signaler votre découverte à la police et jouer la manière dont vous les avez trouvées.',
                'answer_4' => 'Les vendre sur un site tiers contre de l\'argent réel.',
                'correct_answer' => 3,
            ],
            [
                'question' => 'Vous êtes ambulancier et arrivez sur une scène où un joueur est grièvement blessé. Un autre joueur, qui n\'est pas un professionnel de santé, essaie sans cesse de soigner le blessé avec des bandages. Que devez-vous faire ?',
                'answer_1' => 'L\'ignorer et soigner vous-même le joueur blessé.',
                'answer_2' => 'L\'insulter verbalement pour avoir perturbé la prise en charge médicale.',
                'answer_3' => 'Expliquer calmement que seuls les ambulanciers peuvent traiter les blessures graves et lui demander de s\'écarter.',
                'answer_4' => 'Le laisser essayer, peut-être qu\'il pourra sauver le joueur.',
                'correct_answer' => 3,
            ],
            [
                'question' => 'Vous êtes arrêté par la police pour un crime que vous avez commis en jeu. Que devez-vous faire ?',
                'answer_1' => 'Contester avec les agents et tenter de vous échapper.',
                'answer_2' => 'Jouer l\'arrestation et coopérer raisonnablement avec la police.',
                'answer_3' => 'Vous déconnecter du serveur puis revenir pour éviter la sanction.',
                'answer_4' => 'Menacer de signaler les agents pour fausse arrestation.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'Vous êtes déçu par une interaction récente avec un autre joueur. Quelle est la meilleure chose à faire ?',
                'answer_1' => 'Humilier publiquement le joueur dans le chat et l\'insulter.',
                'answer_2' => 'Signaler l\'incident aux administrateurs du serveur avec des preuves.',
                'answer_3' => 'Chercher à vous venger de ce joueur en jeu.',
                'answer_4' => 'L\'ignorer et espérer que cela ne se reproduise pas.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'Vous incarnez un policier et voyez un autre joueur enfreindre la loi. Que devez-vous faire ?',
                'answer_1' => 'Ignorer le crime, ce n\'est pas votre responsabilité.',
                'answer_2' => 'Jouer l\'enquête sur le crime et procéder à une arrestation si nécessaire.',
                'answer_3' => 'Envoyer un message au joueur pour lui demander d\'arrêter d\'enfreindre la loi.',
                'answer_4' => 'Signaler le joueur aux administrateurs et les laisser gérer.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'Pendant que vous tenez un magasin de vêtements, un joueur propose d\'acheter une grande quantité de vêtements coûteux d\'un seul coup à un prix irréaliste. Que devez-vous faire ?',
                'answer_1' => 'Accepter l\'offre, avoir plus d\'argent est toujours une bonne chose.',
                'answer_2' => 'Demander au joueur pourquoi il veut acheter autant de vêtements d\'un coup.',
                'answer_3' => 'Ignorer l\'offre et espérer un client plus raisonnable.',
                'answer_4' => 'Lui vendre les vêtements quand même, puis le signaler plus tard aux administrateurs.',
                'correct_answer' => 2,
            ],
            [
                'question' => 'Vous créez l\'histoire de votre personnage. Que devez-vous éviter d\'inclure ?',
                'answer_1' => 'Un passé de service militaire.',
                'answer_2' => 'Connaître des informations sur',
                'answer_3' => 'Un événement tragique qui motive les actions de votre personnage.',
                'answer_4' => 'Un historique familial détaillé avec de nombreux proches.',
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
