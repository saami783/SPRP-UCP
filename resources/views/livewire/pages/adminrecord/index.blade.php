<?php

use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;

new
#[Layout('layouts.app')]
#[Title('Sanctions OOC')]
class extends Component {
    use WithPagination;

    public function with(): array
    {
        return [
            'records' => $this->records(),
        ];
    }

    public function records()
    {
        $records = auth()->user()
            ->adminRecords()
            ->orderByDesc('record_id')
            ->paginate(10);

        $adminNames = User::query()
            ->whereIn('account_id', $records->getCollection()->pluck('record_admin')->filter()->unique()->all())
            ->pluck('account_name', 'account_id');

        $records->getCollection()->transform(function ($record) use ($adminNames) {
            $record->type_label = $this->recordTypeLabel($record->record_type);
            $record->admin_name = $adminNames[$record->record_admin] ?? 'Inconnu';
            $record->formatted_time = $this->formatRecordTime($record->record_time);
            $record->formatted_date = $this->formatRecordDate($record->record_date);

            return $record;
        });

        return $records;
    }

    public function recordTypeLabel($type): string
    {
        return match ((int) $type) {
            0 => 'Expulsion',
            1 => 'Prison admin',
            2 => 'Bannissement',
            default => 'Inconnu',
        };
    }

    public function formatRecordTime($time): string
    {
        $minutes = (int) $time;

        return $minutes > 0 ? $minutes.' min' : '-';
    }

    public function formatRecordDate($date): string
    {
        if ($date instanceof Carbon) {
            return $date->format('d/m/Y H:i');
        }

        try {
            return Carbon::createFromFormat('d/m/Y, H:i', (string) $date)->format('d/m/Y H:i');
        } catch (\Throwable $e) {
            try {
                return Carbon::parse((string) $date)->format('d/m/Y H:i');
            } catch (\Throwable $e) {
                return (string) $date;
            }
        }
    }

}; ?>

<div class="px-4 py-5 md:px-6 md:py-8 xl:px-8">
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex flex-wrap items-center gap-4">
            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:border-white/20"
                wire:navigate
            >
                <x-heroicon-c-arrow-left-circle class="h-5 w-5" />
                <span>Retour</span>
            </a>
        </div>

        <section class="p-6">
            <div class="flex flex-wrap items-end gap-4">
                <div>
                    <h1 class="font-manrope text-3xl font-extrabold tracking-tight text-white">Historique des sanctions</h1>
                </div>
            </div>

            <div class="mt-6 overflow-hidden border border-white/10">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10 text-sm">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-[0.18em] text-white">Type</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-[0.18em] text-white">Admin</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-[0.18em] text-white">Raison</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-[0.18em] text-white">Temps</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-[0.18em] text-white">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($records as $record)
                                <tr class="align-top">
                                    <td class="whitespace-nowrap px-4 py-4 font-medium text-white">{{ $record->type_label }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-white">{{ $record->admin_name }}</td>
                                    <td class="min-w-[320px] px-4 py-4 text-white">{{ $record->record_reason ?: '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-white">{{ $record->formatted_time }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-white">{{ $record->formatted_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-white">
                                        Aucun dossier administratif enregistré.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($records->hasPages())
                <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                    <p class="text-sm text-white">
                        Page {{ $records->currentPage() }} sur {{ $records->lastPage() }}
                    </p>

                    <div class="inline-flex items-center gap-2">
                        <button
                            type="button"
                            wire:click="previousPage"
                            @disabled($records->onFirstPage())
                            class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:border-white/20 disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            Précédent
                        </button>
                        <button
                            type="button"
                            wire:click="nextPage"
                            @disabled(!$records->hasMorePages())
                            class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:border-white/20 disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            Suivant
                        </button>
                    </div>
                </div>
            @endif
        </section>
    </div>
</div>
