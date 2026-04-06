<?php

use App\Models\Character\Character;
use App\Models\Faction;
use App\Models\SkinData;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
#[Title('Personnage')]
class extends Component {

    public string $characterName = '';

    public Character $character;
    public $faction = null;
    public $skin = null;
    public $vehicles;
    public $ownedProperties;
    public $rentedProperty = null;
    public $weapons;
    public $drugs;

    public string $activeTab = 'proprietes';

    public int $healthPercent = 0;
    public int $armourPercent = 0;
    public int $skinCount = 0;
    public int $wardrobeCount = 0;
    public int $propCount = 0;

    public function mount(): void
    {
        $user = auth()->user();

        $query = Character::query()
            ->with('user')
            ->where('player_name', $this->characterName);

        if (! $user->is_admin()) {
            $query->where('account_id', $user->account_id);
        }

        $this->character = $query->firstOrFail();
        $this->skin = SkinData::find($this->character->player_skinid);
        $this->faction = $this->character->player_factionid > 0
            ? Faction::find($this->character->player_factionid)
            : null;

        $this->vehicles = DB::table('vehicles')
            ->where('vehicle_owner', $this->character->player_id)
            ->select([
                'vehicle_sqlid',
                'vehicle_modelid',
                'vehicle_license',
                'vehicle_mileage',
                'vehicle_health',
                'vehicle_fuel',
                'vehicle_impounded',
            ])
            ->orderBy('vehicle_sqlid')
            ->get();

        $this->ownedProperties = DB::table('properties')
            ->where('property_owner', $this->character->player_id)
            ->select([
                'property_id',
                'property_name',
                'property_type',
                'property_price',
                'property_rent',
                'property_locked',
            ])
            ->orderBy('property_id')
            ->get();

        if ($this->character->player_rentroom > 0) {
            $this->rentedProperty = DB::table('properties')
                ->where('property_id', $this->character->player_rentroom)
                ->select([
                    'property_id',
                    'property_name',
                    'property_type',
                    'property_rent',
                    'property_locked',
                ])
                ->first();
        }

        $this->weapons = $this->loadWeapons();
        $this->drugs = DB::table('player_drugs')
            ->where('drug_characterid', $this->character->player_id)
            ->select([
                'drug_package',
                'drug_type',
                'drug_grams',
            ])
            ->orderBy('drug_type')
            ->get()
            ->map(fn ($drug) => [
                'label' => $this->drugLabel($drug->drug_type),
                'package' => $drug->drug_package,
                'grams' => number_format((float) $drug->drug_grams, 1, ',', ' '),
            ]);

        $this->skinCount = DB::table('player_skins')
            ->where('player_skin_charid', $this->character->player_id)
            ->count();

        $this->wardrobeCount = DB::table('player_wardrobes')
            ->where('player_wardrobe_char_id', $this->character->player_id)
            ->count();

        $this->propCount = DB::table('player_props')
            ->where('prop_characterid', $this->character->player_id)
            ->count();

        $this->healthPercent = $this->clampPercentage($this->character->player_health);
        $this->armourPercent = $this->clampPercentage($this->character->player_armour);

    }

    public function loadWeapons()
    {
        $weapons = DB::table('player_weapons')
            ->where('character_id', $this->character->player_id)
            ->select(['weapon_id', 'weapon_ammo'])
            ->orderBy('weapon_id')
            ->get();

        if ($weapons->isEmpty()) {
            $weapons = DB::table('weapons')
                ->where('character_id', $this->character->player_id)
                ->select(['weapon_id', 'weapon_ammo'])
                ->orderBy('weapon_id')
                ->get();
        }

        return $weapons->map(fn ($weapon) => [
            'id' => $weapon->weapon_id,
            'label' => $this->weaponLabel($weapon->weapon_id),
            'ammo' => number_format((int) $weapon->weapon_ammo, 0, ',', ' '),
        ]);
    }

    public function clampPercentage($value): int
    {
        return max(0, min(100, (int) round($value)));
    }

    public function formatMoney($value): string
    {
        return '$'.number_format((int) $value, 0, ',', ' ');
    }

    public function formatTimestamp(int $timestamp): string
    {
        if ($timestamp <= 0) {
            return 'Jamais';
        }

        return date('d/m/Y H:i', $timestamp);
    }

    public function cleanText($value, string $fallback = 'Aucun'): string
    {
        $value = trim((string) $value);

        if ($value === '' || $value === '0' || strtolower($value) === 'none' || strtolower($value) === 'undefined') {
            return $fallback;
        }

        return $value;
    }

    public function yesNo(bool $value): string
    {
        return $value ? 'Oui' : 'Non';
    }

    public function skinLabel(): string
    {
        $skinName = $this->skin ? $this->cleanText($this->skin->name, '') : '';

        if ($skinName !== '') {
            return $skinName.' (#'.$this->character->player_skinid.')';
        }

        return 'Skin #'.$this->character->player_skinid;
    }

    public function genderLabel(int $value): string
    {
        return match ($value) {
            1 => 'Homme',
            2 => 'Femme',
            default => 'Inconnu',
        };
    }

    public function raceLabel(int $value): string
    {
        return match ($value) {
            0 => 'Blanc',
            1 => 'Noir',
            2 => 'Latino',
            3 => 'Asiatique',
            default => 'Autre',
        };
    }

    public function eyesLabel(int $value): string
    {
        return match ($value) {
            0 => 'Ambre',
            1 => 'Bleu',
            2 => 'Brun',
            3 => 'Gris',
            4 => 'Vert',
            5 => 'Noisette',
            default => 'Inconnus',
        };
    }

    public function hairLabel(int $value): string
    {
        return match ($value) {
            0 => 'Aucun',
            1 => 'Noir',
            2 => 'Brun',
            3 => 'Blond',
            4 => 'Blanc',
            5 => 'Gris',
            6 => 'Roux',
            default => 'Inconnus',
        };
    }

    public function bodyLabel(int $value): string
    {
        return match ($value) {
            0 => 'Très mince',
            1 => 'Mince',
            2 => 'Normale',
            3 => 'Corpulent',
            4 => 'Obèse',
            5 => 'Musclé',
            default => 'Inconnue',
        };
    }

    public function heightLabel(int $height): string
    {
        if ($height <= 0) {
            return 'Inconnue';
        }

        $inches = (int) round($height / 2.54);
        $feet = intdiv($inches, 12);
        $remainingInches = $inches % 12;

        return $height.' cm ('.$feet."'".$remainingInches.'")';
    }

    public function fightStyleLabel(int $value): string
    {
        return match ($value) {
            5 => 'Boxe',
            6 => 'Kung Fu',
            7 => 'Knee Head',
            15 => 'Grab Kick',
            16 => 'Elbow',
            default => 'Standard',
        };
    }

    public function squadLabel(): string
    {
        $squads = array_filter([
            $this->character->player_factionsquad,
            $this->character->player_factionsquad2,
            $this->character->player_factionsquad3,
        ]);

        if (empty($squads)) {
            return 'Aucune';
        }

        return implode(', ', array_map(fn ($squad) => '#'.$squad, $squads));
    }

    public function channelLabel(int $value): string
    {
        return $value > 0 ? (string) $value : 'Aucun';
    }

    public function propertyTypeLabel(int $value): string
    {
        return 'Type #'.$value;
    }

    public function drugLabel(int $value): string
    {
        return 'Type #'.$value;
    }

    public function weaponLabel(int $value): string
    {
        return match ($value) {
            0 => 'Fist',
            1 => 'Brass Knuckles',
            2 => 'Golf Club',
            3 => 'Nightstick',
            4 => 'Knife',
            5 => 'Baseball Bat',
            6 => 'Shovel',
            7 => 'Pool Cue',
            8 => 'Katana',
            9 => 'Chainsaw',
            22 => 'Colt 45',
            23 => 'Silenced 9mm',
            24 => 'Desert Eagle',
            25 => 'Shotgun',
            26 => 'Sawnoff Shotgun',
            27 => 'SPAS-12',
            28 => 'Micro Uzi',
            29 => 'MP5',
            30 => 'AK-47',
            31 => 'M4',
            32 => 'Tec-9',
            33 => 'Country Rifle',
            34 => 'Sniper Rifle',
            35 => 'RPG',
            36 => 'HS Rocket Launcher',
            37 => 'Flamethrower',
            38 => 'Minigun',
            39 => 'Satchel Charge',
            40 => 'Detonator',
            41 => 'Spray Can',
            42 => 'Fire Extinguisher',
            43 => 'Camera',
            44 => 'Night Vision',
            45 => 'Infrared Vision',
            46 => 'Parachute',
            default => 'Weapon #'.$value,
        };
    }

}; ?>

<div class="px-4 py-5 md:px-6 md:py-8 xl:px-8">
    @php
        $totalLiquidAssets = $character->player_cash + $character->player_bankcash + $character->player_savings;
        $propertyCount = $ownedProperties->count() + ($rentedProperty ? 1 : 0);
        $assetCount = $vehicles->count() + $propertyCount;
        $inventoryCount = $weapons->count() + $drugs->count();
        $factionSummary = $faction
            ? $faction->faction_name.' · '.$this->cleanText($character->player_factionrank, 'Aucun rang')
            : 'Sans faction';
        $heroStats = [
            [
                'label' => 'Liquidités',
                'value' => $this->formatMoney($totalLiquidAssets),
                'hint' => 'Cash, banque et épargne',
            ],
            [
                'label' => 'Possessions',
                'value' => $assetCount,
                'hint' => $vehicles->count().' véhicules · '.$propertyCount.' biens',
            ],
            [
                'label' => 'Inventaire',
                'value' => $inventoryCount,
                'hint' => $weapons->count().' armes · '.$drugs->count().' substances',
            ],
            [
                'label' => 'Téléphone',
                'value' => $character->player_phnumber > 0 ? $character->player_phnumber : 'Aucun',
                'hint' => $character->player_radio > 0 ? 'Radio active' : 'Pas de radio',
            ],
        ];

        $tabs = [
            ['id' => 'proprietes', 'label' => 'Propriétés'],
            ['id' => 'vehicules', 'label' => 'Véhicules'],
        ];
    @endphp

    <div class="mx-auto flex w-full max-w-[1440px] flex-col gap-8">
        <div class="flex flex-wrap items-center gap-4">
            <a
                href="{{ route('characters') }}"
                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-gray-300 transition hover:border-white/20 hover:text-white"
                wire:navigate
            >
                <x-heroicon-c-arrow-left-circle class="h-5 w-5" />
                <span>Retour aux personnages</span>
            </a>
        </div>

        <section class="relative overflow-hidden rounded-[2rem] shadow-[0_45px_120px_rgba(0,0,0,0.28)]">
            <div class="grid gap-6 p-5 sm:p-6 xl:grid-cols-[minmax(0,1.25fr)_360px] xl:p-8">
                <div class="space-y-6">
                    <div class="flex flex-wrap items-start justify-between gap-6">
                        <div class="max-w-3xl space-y-4">
                            <div class="space-y-2">
                                <h1 class="font-manrope text-4xl font-extrabold leading-none tracking-[-0.04em] text-white sm:text-5xl xl:text-6xl">
                                    {{ $character->getCleanName() }}
                                </h1>
                                <p class="text-sm text-slate-400">{{ $factionSummary }}</p>
                            </div>

                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-full border border-white/10 px-4 py-2 text-xs font-medium uppercase tracking-[0.18em] text-white">
                                Niveau {{ $character->player_level }}
                            </span>
                            <span class="inline-flex items-center rounded-full border border-white/10 px-4 py-2 text-xs font-medium uppercase tracking-[0.18em] text-slate-200">
                                {{ number_format((int) $character->player_hours, 0, ',', ' ') }}h jouées
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach($heroStats as $stat)
                            <article class="rounded-[1.75rem] border border-white/10 p-5 transition duration-300 hover:-translate-y-1">
                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.26em] text-slate-500">{{ $stat['label'] }}</p>
                                    <p class="mt-4 font-manrope text-2xl font-extrabold tracking-tight text-white">{{ $stat['value'] }}</p>
                                    <p class="mt-2 text-xs leading-5 text-slate-400">{{ $stat['hint'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto">
                        <nav class="inline-flex w-fit gap-2 rounded-[1.25rem] border border-white/10 p-1.5">
                            @foreach($tabs as $tab)
                                <button
                                    type="button"
                                    wire:click="$set('activeTab', '{{ $tab['id'] }}')"
                                    class="{{ $activeTab === $tab['id'] ? 'border-button-primary bg-button-primary text-white' : 'border-transparent text-slate-300 hover:border-white/10 hover:text-white' }} whitespace-nowrap rounded-full border px-3.5 py-2 text-sm font-medium transition"
                                >
                                    {{ $tab['label'] }}
                                </button>
                            @endforeach
                        </nav>
                    </div>

                    <div class="space-y-3">
                        @if($activeTab === 'proprietes')
                            <ul class="list-disc space-y-2 pl-5 text-sm text-slate-300 marker:text-slate-500">
                            @if($rentedProperty)
                                <li>
                                    <span class="font-medium text-white">{{ $rentedProperty->property_name }}</span>
                                    <span class="text-slate-400"> · location actuelle · {{ $this->propertyTypeLabel($rentedProperty->property_type) }}</span>
                                </li>
                            @endif

                            @forelse($ownedProperties as $property)
                                <li>
                                    <span class="font-medium text-white">{{ $property->property_name }}</span>
                                    <span class="text-slate-400"> · {{ $this->propertyTypeLabel($property->property_type) }}</span>
                                </li>
                            @empty
                                @if(!$rentedProperty)
                                    <p class="text-sm text-slate-400">Ce personnage ne possède ni ne loue aucune propriété.</p>
                                @endif
                            @endforelse
                            </ul>
                        @endif

                        @if($activeTab === 'vehicules')
                            <ul class="list-disc space-y-2 pl-5 text-sm text-slate-300 marker:text-slate-500">
                            @forelse($vehicles as $vehicle)
                                <li>
                                    <span class="font-medium text-white">{{ $vehicle->vehicle_license }}</span>
                                    <span class="text-slate-400"> · modèle #{{ $vehicle->vehicle_modelid }}</span>
                                    <span class="{{ $vehicle->vehicle_impounded ? 'text-rose-200' : 'text-slate-400' }}"> · {{ $vehicle->vehicle_impounded ? 'En fourrière' : 'Disponible' }}</span>
                                </li>
                            @empty
                                <p class="text-sm text-slate-400">Ce personnage ne possède actuellement aucun véhicule.</p>
                            @endforelse
                            </ul>
                        @endif
                    </div>
                </div>

                <aside class="rounded-[2rem] p-4">
                    <div class="rounded-[1.6rem] border border-white/10 px-4 pb-4 pt-5">
                        <div class="flex items-center">
                            <span class="inline-flex items-center rounded-full border border-white/10 px-3 py-1 text-[11px] uppercase tracking-[0.22em] text-slate-200">
                                {{ $this->skinLabel() }}
                            </span>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-400">
                                    <span>Santé</span>
                                    <span>{{ number_format((float) $character->player_health, 0, ',', ' ') }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full border border-white/10">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-emerald-300 via-emerald-400 to-emerald-500" style="width: {{ $healthPercent }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-400">
                                    <span>Armure</span>
                                    <span>{{ number_format((float) $character->player_armour, 0, ',', ' ') }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full border border-white/10">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-sky-300 via-sky-400 to-sky-500" style="width: {{ $armourPercent }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <img
                                src="{{ asset('assets/skins/'.$character->player_skinid.'.png') }}"
                                alt="Aperçu du personnage"
                                class="mx-auto aspect-[4/5] w-full max-w-[280px] object-contain drop-shadow-[0_36px_60px_rgba(0,0,0,0.55)]"
                            >
                        </div>

                        <div class="mt-5 rounded-[1.5rem] border border-white/10 px-4 py-4">
                            <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Vestiaire</p>
                            <p class="mt-3 text-lg font-semibold text-white">{{ $wardrobeCount }} tenues</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $skinCount }} skins sauvegardés · {{ $propCount }} props</p>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

    </div>
</div>
