<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReleaseNote>
 */
class ReleaseNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'la création de personnage',
            'le tableau de bord UCP',
            'le système de connexions',
            'les notes de mise à jour',
            'la boutique premium',
            'la validation du compte',
            'les performances générales',
            'l\'interface mobile',
            'la sécurité du compte',
            'la carte interactive',
            'le vote des fonctionnalités',
            'le dossier administratif',
        ];

        $subject = $this->faker->randomElement($subjects);
        $title = $this->faker->randomElement([
            "Améliorations de {$subject}",
            "Refonte de {$subject}",
            "Mise à jour de {$subject}",
            "Optimisations pour {$subject}",
        ]);

        $description = $this->faker->randomElement([
            "{$subject} a été revu afin d'offrir une expérience plus claire et plus fluide.",
            "Cette mise à jour apporte plusieurs ajustements ciblés sur {$subject} afin d'en améliorer la lisibilité et la stabilité.",
            "Nous avons apporté une nouvelle passe de finitions sur {$subject} pour rendre l'ensemble plus cohérent au quotidien.",
        ]);

        $content = implode("\n\n", [
            "Cette mise à jour se concentre sur {$subject}. Nous avons repris plusieurs libellés, clarifié des blocs d'information et revu certaines formulations afin de rendre l'ensemble plus compréhensible.",
            "L'objectif est d'offrir une expérience plus cohérente pour les nouveaux joueurs comme pour les habitués, sans modifier le fonctionnement général des pages concernées.",
        ]);

        $added = implode("\n", [
            '- Nouveaux libellés plus explicites sur les écrans concernés.',
            '- Messages d\'information harmonisés dans les blocs importants.',
            '- Ajustements visuels pour mieux distinguer les actions principales.',
        ]);

        $changed = implode("\n", [
            '- Réorganisation de certaines sections pour améliorer la lecture.',
            '- Terminologie unifiée dans l\'ensemble de l\'interface.',
            '- Parcours utilisateur simplifié sur les écrans les plus consultés.',
        ]);

        $fixed = implode("\n", [
            '- Correction de plusieurs incohérences de texte.',
            '- Résolution de problèmes d\'affichage sur les petits écrans.',
            '- Amélioration de la lisibilité dans les encarts d\'information.',
        ]);

        $removed = $this->faker->boolean(45)
            ? implode("\n", [
                '- Suppression de formulations redondantes.',
                '- Retrait de certains textes devenus obsolètes.',
            ])
            : null;

        $slug = Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000, 9999);

        return [
            'author' => $this->faker->randomElement(['Équipe UCP', 'Administration', 'Équipe développement', 'Staff']),
            'slug' => $slug,
            'type' => $this->faker->randomElement(['game', 'ucp', 'release']),
            'inline' => $this->faker->boolean,
            'image' => $this->faker->boolean(60) ? "https://picsum.photos/seed/{$slug}/1200/600" : null,
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'added' => $added,
            'changed' => $changed,
            'removed' => $removed,
            'fixed' => $fixed,
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
