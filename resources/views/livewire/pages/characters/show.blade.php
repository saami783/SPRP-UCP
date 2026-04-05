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

    public array $overviewStats = [];
    public array $profileDetails = [];
    public array $appearanceDetails = [];
    public array $factionDetails = [];
    public array $financeDetails = [];
    public array $communicationDetails = [];
    public array $equipmentDetails = [];
    public array $fitnessDetails = [];
    public array $weaponSkills = [];

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

        $propertyCount = $this->ownedProperties->count() + ($this->rentedProperty ? 1 : 0);

        $this->overviewStats = [
            ['label' => 'Cash', 'value' => $this->formatMoney($this->character->player_cash)],
            ['label' => 'Banque', 'value' => $this->formatMoney($this->character->player_bankcash)],
            ['label' => 'Véhicules', 'value' => $this->vehicles->count()],
            ['label' => 'Propriétés', 'value' => $propertyCount],
            ['label' => 'Armes', 'value' => $this->weapons->count()],
            ['label' => 'Drogues', 'value' => $this->drugs->count()],
        ];

        $this->profileDetails = [
            ['label' => 'Compte', 'value' => $this->character->user?->account_name ?? 'Inconnu'],
            ['label' => 'ID personnage', 'value' => '#'.$this->character->player_id],
            ['label' => 'ID compte', 'value' => '#'.$this->character->account_id],
            ['label' => 'Unique ID', 'value' => $this->cleanText($this->character->player_uniqueid, 'Non défini')],
            ['label' => 'Inscrit le', 'value' => $this->formatTimestamp($this->character->player_registerdate)],
            ['label' => 'Dernière connexion', 'value' => $this->formatTimestamp($this->character->player_logindate)],
            ['label' => 'Skin', 'value' => $this->skinLabel()],
            ['label' => 'Skins sauvegardés', 'value' => $this->skinCount],
            ['label' => 'Tenues vestiaire', 'value' => $this->wardrobeCount],
        ];

        $this->appearanceDetails = [
            ['label' => 'Sexe', 'value' => $this->genderLabel($this->character->player_attribute_sex)],
            ['label' => 'Âge', 'value' => $this->character->player_attribute_age > 0 ? $this->character->player_attribute_age.' ans' : 'Inconnu'],
            ['label' => 'Origine', 'value' => $this->raceLabel($this->character->player_attribute_race)],
            ['label' => 'Taille', 'value' => $this->heightLabel($this->character->player_attribute_height)],
            ['label' => 'Corpulence', 'value' => $this->bodyLabel($this->character->player_attribute_body)],
            ['label' => 'Cheveux', 'value' => $this->hairLabel($this->character->player_attribute_hair)],
            ['label' => 'Yeux', 'value' => $this->eyesLabel($this->character->player_attribute_eyes)],
            ['label' => 'Props attachés', 'value' => $this->propCount],
        ];

        $this->factionDetails = [
            ['label' => 'Faction', 'value' => $this->faction?->faction_name ?? 'Aucune'],
            ['label' => 'Abréviation', 'value' => $this->faction?->faction_abbrev ?? 'Aucune'],
            ['label' => 'Rang', 'value' => $this->cleanText($this->character->player_factionrank, 'Aucun')],
            ['label' => 'Tier', 'value' => $this->character->player_factionid > 0 ? $this->character->player_factiontier : 'Aucun'],
            ['label' => 'Badge', 'value' => $this->character->player_factionbadge > 0 ? '#'.$this->character->player_factionbadge : 'Aucun'],
            ['label' => 'Escouades', 'value' => $this->squadLabel()],
            ['label' => 'Suspension', 'value' => $this->character->player_factionsuspension > 0 ? $this->character->player_factionsuspension : 'Aucune'],
            ['label' => 'Spawn propriété', 'value' => $this->character->player_spawnproperty > 0 ? '#'.$this->character->player_spawnproperty : 'Aucun'],
        ];

        $this->financeDetails = [
            ['label' => 'Cash', 'value' => $this->formatMoney($this->character->player_cash)],
            ['label' => 'Banque', 'value' => $this->formatMoney($this->character->player_bankcash)],
            ['label' => 'Épargne', 'value' => $this->formatMoney($this->character->player_savings)],
            ['label' => 'Paie', 'value' => $this->formatMoney($this->character->player_paycheck)],
            ['label' => 'Amendes', 'value' => $this->formatMoney($this->character->player_outstanding_fines)],
            ['label' => 'Respect', 'value' => number_format((int) $this->character->player_respect, 0, ',', ' ')],
            ['label' => 'Fear', 'value' => number_format((int) $this->character->player_fear, 0, ',', ' ')],
            ['label' => 'Remboursement MAJ', 'value' => $this->formatMoney($this->character->player_update_reward)],
        ];

        $this->communicationDetails = [
            ['label' => 'Numéro', 'value' => $this->character->player_phnumber > 0 ? $this->character->player_phnumber : 'Aucun'],
            ['label' => 'Crédit', 'value' => $this->formatMoney($this->character->player_phcredit)],
            ['label' => 'Batterie', 'value' => $this->clampPercentage($this->character->player_phbattery).'%'],
            ['label' => 'Radio', 'value' => $this->yesNo($this->character->player_radio > 0)],
            ['label' => 'Canal 1', 'value' => $this->channelLabel($this->character->player_radiochan1)],
            ['label' => 'Canal 2', 'value' => $this->channelLabel($this->character->player_radiochan2)],
            ['label' => 'Canal 3', 'value' => $this->channelLabel($this->character->player_radiochan3)],
            ['label' => 'Pager', 'value' => $this->channelLabel($this->character->player_pager_freq)],
        ];

        $this->equipmentDetails = [
            ['label' => 'Masque', 'value' => $this->yesNo($this->character->player_maskid > 0)],
            ['label' => 'Jerry can', 'value' => $this->yesNo($this->character->player_gascan > 0)],
            ['label' => 'Lockpicks', 'value' => number_format((int) $this->character->player_lockpicks, 0, ',', ' ')],
            ['label' => 'Permis de conduire', 'value' => $this->yesNo($this->character->player_driverslicense > 0)],
            ['label' => 'Avertissements route', 'value' => number_format((int) $this->character->player_driver_warnings, 0, ',', ' ')],
            ['label' => "Permis d'armes", 'value' => $this->yesNo($this->character->player_gunlicense > 0)],
            ['label' => 'Clé de véhicule', 'value' => $this->character->player_carkey >= 0 ? '#'.$this->character->player_carkey : 'Aucune'],
            ['label' => 'Location active', 'value' => $this->rentedProperty ? '#'.$this->rentedProperty->property_id : 'Aucune'],
        ];

        $this->fitnessDetails = [
            ['label' => 'Santé', 'value' => number_format((float) $this->character->player_health, 0, ',', ' ').'%'],
            ['label' => 'Armure', 'value' => number_format((float) $this->character->player_armour, 0, ',', ' ').'%'],
            ['label' => 'Graisse', 'value' => number_format((float) $this->character->player_fat, 0, ',', ' ')],
            ['label' => 'Muscle', 'value' => number_format((float) $this->character->player_muscle, 0, ',', ' ')],
            ['label' => 'Endurance', 'value' => number_format((float) $this->character->player_stamina, 0, ',', ' ')],
            ['label' => 'Faim', 'value' => number_format((int) $this->character->player_gym_hunger, 0, ',', ' ')],
            ['label' => 'Soif', 'value' => number_format((int) $this->character->player_gym_thirst, 0, ',', ' ')],
            ['label' => 'Style de combat', 'value' => $this->fightStyleLabel($this->character->player_fightstyle)],
        ];

        $this->weaponSkills = [
            ['label' => 'Pistol', 'value' => $this->character->player_skill_pistol],
            ['label' => 'Silenced', 'value' => $this->character->player_skill_sdpistol],
            ['label' => 'Desert Eagle', 'value' => $this->character->player_skill_deagle],
            ['label' => 'Shotgun', 'value' => $this->character->player_skill_shotgun],
            ['label' => 'Sawnoff', 'value' => $this->character->player_skill_sawnoff],
            ['label' => 'SPAS-12', 'value' => $this->character->player_skill_spaz],
            ['label' => 'Uzi', 'value' => $this->character->player_skill_uzi],
            ['label' => 'MP5', 'value' => $this->character->player_skill_mp5],
            ['label' => 'AK-47', 'value' => $this->character->player_skill_ak47],
            ['label' => 'M4', 'value' => $this->character->player_skill_m4],
            ['label' => 'Sniper', 'value' => $this->character->player_skill_sniper],
        ];
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

<div>
    <div class="w-full inline-flex items-start justify-center p-6 space-x-4">
        <a href="{{ route('characters') }}" class="hidden h-10 w-10 rounded-full bg-[#2D2F34] p-2 text-gray-500 transition hover:text-gray-400 md:block" wire:navigate>
            <x-heroicon-c-arrow-left-circle class="h-6 w-6" />
        </a>

        <div class="w-full xl:w-5/6 space-y-6">
            <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                <div class="grid grid-cols-1 xl:grid-cols-12">
                    <div class="uses_character_bg border-b border-white/10 p-6 xl:col-span-4 xl:border-b-0 xl:border-r">
                        <p class="text-[11px] font-medium uppercase tracking-[0.28em] text-gray-500">Profil personnage</p>

                        <div class="mt-3 flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-100">{{ $character->getCleanName() }}</h1>
                                <p class="mt-2 text-sm text-gray-400">{{ $this->skinLabel() }}</p>
                            </div>

                            <div class="rounded-full border border-white/10 bg-black/20 px-3 py-1 text-xs font-medium text-gray-300">
                                Niveau {{ $character->player_level }} · {{ number_format((int) $character->player_hours, 0, ',', ' ') }}h
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <span class="rounded-full border border-white/10 bg-black/20 px-3 py-1 text-xs text-gray-300">
                                {{ $faction?->faction_name ?? 'Sans faction' }}
                            </span>
                            <span class="rounded-full border border-white/10 bg-black/20 px-3 py-1 text-xs text-gray-300">
                                Compte {{ $character->user?->account_name ?? 'Inconnu' }}
                            </span>
                        </div>

                        <img src="{{ asset('assets/skins/'.$character->player_skinid.'.png') }}" alt="Aperçu du personnage" class="mx-auto mt-6 w-full max-w-sm">

                        <div class="mt-6 space-y-4">
                            <div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-400">Santé</span>
                                    <span class="font-medium text-gray-200">{{ number_format((float) $character->player_health, 0, ',', ' ') }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-black/30">
                                    <div class="h-2 rounded-full bg-emerald-400" style="width: {{ $healthPercent }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-400">Armure</span>
                                    <span class="font-medium text-gray-200">{{ number_format((float) $character->player_armour, 0, ',', ' ') }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-black/30">
                                    <div class="h-2 rounded-full bg-sky-400" style="width: {{ $armourPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 xl:col-span-8 xl:p-8">
                        <div class="grid grid-cols-2 gap-3 lg:grid-cols-3">
                            @foreach($overviewStats as $stat)
                                <div class="rounded-2xl border border-white/5 bg-[#1B1C20] px-4 py-4">
                                    <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">{{ $stat['label'] }}</p>
                                    <p class="mt-2 text-xl font-semibold text-gray-100">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <section class="overflow-hidden rounded-2xl border border-white/5 bg-[#1B1C20]">
                                <div class="border-b border-white/5 px-5 py-4">
                                    <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Profil</p>
                                    <h2 class="mt-1 text-base font-semibold text-gray-100">Informations générales</h2>
                                </div>
                                <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                                    @foreach($profileDetails as $detail)
                                        <div class="bg-[#1B1C20] px-5 py-4">
                                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $detail['label'] }}</p>
                                            <p class="mt-2 text-sm text-gray-200">{{ $detail['value'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </section>

                            <section class="overflow-hidden rounded-2xl border border-white/5 bg-[#1B1C20]">
                                <div class="border-b border-white/5 px-5 py-4">
                                    <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Apparence</p>
                                    <h2 class="mt-1 text-base font-semibold text-gray-100">Attributs physiques</h2>
                                </div>
                                <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                                    @foreach($appearanceDetails as $detail)
                                        <div class="bg-[#1B1C20] px-5 py-4">
                                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $detail['label'] }}</p>
                                            <p class="mt-2 text-sm text-gray-200">{{ $detail['value'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </section>

                            <section class="overflow-hidden rounded-2xl border border-white/5 bg-[#1B1C20]">
                                <div class="border-b border-white/5 px-5 py-4">
                                    <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Faction</p>
                                    <h2 class="mt-1 text-base font-semibold text-gray-100">Affiliation</h2>
                                </div>
                                <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                                    @foreach($factionDetails as $detail)
                                        <div class="bg-[#1B1C20] px-5 py-4">
                                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $detail['label'] }}</p>
                                            <p class="mt-2 text-sm text-gray-200">{{ $detail['value'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </section>

                            <section class="overflow-hidden rounded-2xl border border-white/5 bg-[#1B1C20]">
                                <div class="border-b border-white/5 px-5 py-4">
                                    <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Argent</p>
                                    <h2 class="mt-1 text-base font-semibold text-gray-100">Finances</h2>
                                </div>
                                <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                                    @foreach($financeDetails as $detail)
                                        <div class="bg-[#1B1C20] px-5 py-4">
                                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $detail['label'] }}</p>
                                            <p class="mt-2 text-sm text-gray-200">{{ $detail['value'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </section>

            @if($this->cleanText($character->player_attribute_desc, '') !== '')
                <section class="rounded-2xl border border-stroke-primary bg-[#232429] px-5 py-5">
                    <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Description</p>
                    <div class="mt-3 text-sm leading-6 text-gray-300">
                        {!! nl2br(e($this->cleanText($character->player_attribute_desc))) !!}
                    </div>
                </section>
            @endif

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="border-b border-white/5 px-5 py-4">
                        <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Téléphone</p>
                        <h2 class="mt-1 text-base font-semibold text-gray-100">Communication</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                        @foreach($communicationDetails as $detail)
                            <div class="bg-[#1B1C20] px-5 py-4">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $detail['label'] }}</p>
                                <p class="mt-2 text-sm text-gray-200">{{ $detail['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="border-b border-white/5 px-5 py-4">
                        <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Équipement</p>
                        <h2 class="mt-1 text-base font-semibold text-gray-100">Objets et permis</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                        @foreach($equipmentDetails as $detail)
                            <div class="bg-[#1B1C20] px-5 py-4">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $detail['label'] }}</p>
                                <p class="mt-2 text-sm text-gray-200">{{ $detail['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="border-b border-white/5 px-5 py-4">
                        <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Fitness</p>
                        <h2 class="mt-1 text-base font-semibold text-gray-100">Physique et combat</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                        @foreach($fitnessDetails as $detail)
                            <div class="bg-[#1B1C20] px-5 py-4">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $detail['label'] }}</p>
                                <p class="mt-2 text-sm text-gray-200">{{ $detail['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="border-b border-white/5 px-5 py-4">
                        <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Maîtrise</p>
                        <h2 class="mt-1 text-base font-semibold text-gray-100">Compétences d'armes</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-px bg-white/5 sm:grid-cols-2">
                        @foreach($weaponSkills as $skill)
                            <div class="bg-[#1B1C20] px-5 py-4">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">{{ $skill['label'] }}</p>
                                <p class="mt-2 text-sm text-gray-200">{{ number_format((int) $skill['value'], 0, ',', ' ') }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="flex items-center justify-between border-b border-white/5 px-5 py-4">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Véhicules</p>
                            <h2 class="mt-1 text-base font-semibold text-gray-100">Possessions routières</h2>
                        </div>
                        <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-gray-300">{{ $vehicles->count() }}</span>
                    </div>
                    <div class="divide-y divide-white/5">
                        @forelse($vehicles as $vehicle)
                            <div class="flex items-start justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-100">{{ $vehicle->vehicle_license }}</p>
                                    <p class="mt-1 text-sm text-gray-400">Modèle #{{ $vehicle->vehicle_modelid }} · ID #{{ $vehicle->vehicle_sqlid }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-200">{{ number_format((int) $vehicle->vehicle_mileage, 0, ',', ' ') }} km</p>
                                    <p class="mt-1 text-xs text-gray-500">Santé {{ number_format((float) $vehicle->vehicle_health, 0, ',', ' ') }}/1000 · Carburant {{ $this->clampPercentage($vehicle->vehicle_fuel) }}%</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-8 text-sm text-gray-400">
                                Ce personnage ne possède aucun véhicule.
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="flex items-center justify-between border-b border-white/5 px-5 py-4">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Propriétés</p>
                            <h2 class="mt-1 text-base font-semibold text-gray-100">Biens et locations</h2>
                        </div>
                        <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-gray-300">{{ $ownedProperties->count() + ($rentedProperty ? 1 : 0) }}</span>
                    </div>

                    @if($rentedProperty)
                        <div class="border-b border-white/5 px-5 py-4">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">Location actuelle</p>
                            <div class="mt-2 flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-100">{{ $rentedProperty->property_name }}</p>
                                    <p class="mt-1 text-sm text-gray-400">ID #{{ $rentedProperty->property_id }} · {{ $this->propertyTypeLabel($rentedProperty->property_type) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-200">{{ $this->formatMoney($rentedProperty->property_rent) }}/cycle</p>
                                    <p class="mt-1 text-xs text-gray-500">{{ $rentedProperty->property_locked ? 'Verrouillée' : 'Déverrouillée' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="divide-y divide-white/5">
                        @forelse($ownedProperties as $property)
                            <div class="flex items-start justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-100">{{ $property->property_name }}</p>
                                    <p class="mt-1 text-sm text-gray-400">ID #{{ $property->property_id }} · {{ $this->propertyTypeLabel($property->property_type) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-200">{{ $this->formatMoney($property->property_price) }}</p>
                                    <p class="mt-1 text-xs text-gray-500">{{ $property->property_locked ? 'Verrouillée' : 'Déverrouillée' }}</p>
                                </div>
                            </div>
                        @empty
                            @if(!$rentedProperty)
                                <div class="px-5 py-8 text-sm text-gray-400">
                                    Ce personnage ne possède ni ne loue aucune propriété.
                                </div>
                            @endif
                        @endforelse
                    </div>
                </section>

                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="flex items-center justify-between border-b border-white/5 px-5 py-4">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Armes</p>
                            <h2 class="mt-1 text-base font-semibold text-gray-100">Inventaire enregistré</h2>
                        </div>
                        <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-gray-300">{{ $weapons->count() }}</span>
                    </div>
                    <div class="divide-y divide-white/5">
                        @forelse($weapons as $weapon)
                            <div class="flex items-start justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-100">{{ $weapon['label'] }}</p>
                                    <p class="mt-1 text-sm text-gray-400">ID #{{ $weapon['id'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-200">{{ $weapon['ammo'] }}</p>
                                    <p class="mt-1 text-xs text-gray-500">Munitions</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-8 text-sm text-gray-400">
                                Aucune arme enregistrée pour ce personnage.
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="overflow-hidden rounded-2xl border border-stroke-primary bg-[#232429]">
                    <div class="flex items-center justify-between border-b border-white/5 px-5 py-4">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.24em] text-gray-500">Drogues</p>
                            <h2 class="mt-1 text-base font-semibold text-gray-100">Sur le personnage</h2>
                        </div>
                        <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-gray-300">{{ $drugs->count() }}</span>
                    </div>
                    <div class="divide-y divide-white/5">
                        @forelse($drugs as $drug)
                            <div class="flex items-start justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-100">{{ $drug['label'] }}</p>
                                    <p class="mt-1 text-sm text-gray-400">Paquet #{{ $drug['package'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-200">{{ $drug['grams'] }} g</p>
                                    <p class="mt-1 text-xs text-gray-500">Quantité</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-8 text-sm text-gray-400">
                                Aucune drogue enregistrée sur ce personnage.
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
