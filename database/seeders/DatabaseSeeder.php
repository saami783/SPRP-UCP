<?php

namespace Database\Seeders;

use App\Models\Misc\OnlinePlayers;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (Schema::hasTable('users') && User::query()->count() === 0) {
            User::factory(10)->create();
        }

        $seeders = $this->discoverSeederClasses();

        if ($seeders !== []) {
            $this->call($seeders);
        }

        // create 120 online player records each with a time differing by one day from the previous record
        if (Schema::hasTable('online_players')) {
            OnlinePlayers::query()->delete();

            for ($i = 0; $i < 120; $i++) {
                OnlinePlayers::factory()->create([
                    'created_at' => now()->subDays(120)->addDays($i)->format('Y-m-d')
                ]);
            }
        }
    }

    private function discoverSeederClasses(): array
    {
        $seeders = array_map(
            static fn (string $file): string => __NAMESPACE__.'\\'.pathinfo($file, PATHINFO_FILENAME),
            glob(database_path('seeders/*.php')) ?: []
        );

        $seeders = array_filter(
            $seeders,
            static fn (string $class): bool => $class !== self::class && class_exists($class)
        );

        sort($seeders);

        return array_values($seeders);
    }
}
