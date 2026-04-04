<?php

namespace Database\Seeders;

use App\Models\ReleaseNote;
use Database\Factories\ReleaseNoteFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReleaseNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReleaseNote::query()->delete();

        ReleaseNote::factory()
            ->count(25)
            ->create();
    }
}
