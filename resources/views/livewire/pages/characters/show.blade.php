<?php

use App\Models\Character\Character;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
#[Title('Personnage')]
class extends Component {

    public string $characterName = '';

    public Character $character;

    public function mount(): void
    {
        $user = auth()->user();

        $query = Character::query()->where('player_name', $this->characterName);

        if (! $user->is_admin()) {
            $query->where('account_id', $user->account_id);
        }

        $this->character = $query->firstOrFail();
    }

}; ?>

<div>
    <div class="w-full inline-flex items-start justify-center p-6 space-x-4">
        <a href="{{ route('characters') }}" class="h-10 w-10 hidden md:block rounded-full bg-[#2D2F34] p-2 text-gray-500 hover:text-gray-400 transition" wire:navigate>
            <x-heroicon-c-arrow-left-circle class="w-6 h-6" />
        </a>
        <div class="w-full md:w-2/3 lg:w-1/2 space-y-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-200">{{ $character->getCleanName() }}</h1>
                <p class="mt-1 text-sm text-gray-400">Page de personnage.</p>
            </div>

            <div class="w-full uses_character_bg rounded-lg py-8 space-y-4 ring-1 ring-white/10">
                <img src="{{ asset('assets/skins/'.$character->player_skinid.'.png') }}" alt="Aperçu du personnage" class="w-full h-auto">
                <div class="flex flex-col items-center">
                    <span class="font-semibold text-gray-300 text-lg">{{ $character->getCleanName() }}</span>
                    <span class="text-gray-400 text-sm">Détail minimal</span>
                </div>
            </div>
        </div>
    </div>
</div>
