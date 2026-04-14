<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Stats Cards --}}
        <div class="lg:col-span-2">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.pending_requests') }}</div>
                    <div class="mt-1 text-3xl font-bold text-warning-600 dark:text-warning-400">{{ $this->getStats()['pending'] }}</div>
                </div>
                <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.in_progress') }}</div>
                    <div class="mt-1 text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $this->getStats()['in_progress'] }}</div>
                </div>
                <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.completed_this_month') }}</div>
                    <div class="mt-1 text-3xl font-bold text-success-600 dark:text-success-400">{{ $this->getStats()['completed_this_month'] }}</div>
                </div>
                <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.equipment_needing_attention') }}</div>
                    <div class="mt-1 text-3xl font-bold text-danger-600 dark:text-danger-400">{{ $this->getStats()['equipment_needing_attention'] }}</div>
                </div>
            </div>
        </div>

        {{-- Upcoming Preventive Maintenance --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <h3 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('mnt::pages.widget.upcoming_preventive') }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.next_7_days') }}</p>
            <div class="mt-4 space-y-3">
                @forelse($this->getUpcomingPreventive() as $schedule)
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                        <div>
                            <div class="text-sm font-medium text-gray-950 dark:text-white">{{ $schedule->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $schedule->equipment?->name }}</div>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $schedule->next_date?->format('M d') }}</div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.no_upcoming_preventive') }}</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <h3 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('mnt::pages.widget.recent_activity') }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.latest_requests') }}</p>
            <div class="mt-4 space-y-3">
                @forelse($this->getRecentActivity() as $request)
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                        <div>
                            <div class="text-sm font-medium text-gray-950 dark:text-white">
                                {{ $request->reference }} — {{ str($request->name)->limit(30) }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $request->equipment?->name }} {{ $request->technician ? '· ' . $request->technician->name : '' }}
                            </div>
                        </div>
                        <x-filament::badge :color="$request->stage->getColor()">
                            {{ $request->stage->getLabel() }}
                        </x-filament::badge>
                    </div>
                @empty
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('mnt::pages.widget.no_recent_activity') }}</div>
                @endforelse
            </div>
        </div>

        {{-- Equipment Status Distribution --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 lg:col-span-2 dark:bg-gray-900 dark:ring-white/10">
            <h3 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('mnt::pages.widget.equipment_distribution') }}</h3>
            <div class="mt-4 flex flex-wrap gap-6">
                @foreach($this->getEquipmentDistribution() as $label => $count)
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-gray-950 dark:text-white">{{ $count }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
