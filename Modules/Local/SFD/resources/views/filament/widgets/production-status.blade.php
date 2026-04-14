@php
    $stats = $this->getSummaryStats();
    $orders = $this->getActiveOrders();
    $workCenters = $this->getWorkCenterLoad();
    $recentlyCompleted = $this->getRecentlyCompleted();
@endphp

<x-filament-widgets::widget>
    {{-- Summary Stats Bar --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('sfd::widgets.production_status.active_work_orders') }}</div>
            <div class="mt-1 text-2xl font-bold text-gray-950 dark:text-white">{{ $stats['active_work_orders'] }}</div>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('sfd::widgets.production_status.completed_today') }}</div>
            <div class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['today_completed'] }}</div>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('sfd::widgets.production_status.avg_efficiency') }}</div>
            <div class="mt-1 text-2xl font-bold {{ $stats['avg_efficiency'] >= 90 ? 'text-emerald-600 dark:text-emerald-400' : ($stats['avg_efficiency'] >= 70 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                {{ $stats['avg_efficiency'] }}%
            </div>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('sfd::widgets.production_status.overdue_orders') }}</div>
            <div class="mt-1 text-2xl font-bold {{ $stats['overdue_orders'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-950 dark:text-white' }}">
                {{ $stats['overdue_orders'] }}
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        {{-- Active Manufacturing Orders --}}
        <div class="lg:col-span-2">
            <x-filament::section :heading="__('sfd::widgets.production_status.active_manufacturing_orders')" icon="heroicon-o-clipboard-document-check">
                @if (empty($orders))
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <x-filament::icon icon="heroicon-o-clipboard-document-check" class="mb-2 h-8 w-8 text-gray-400 dark:text-gray-500" />
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('sfd::widgets.production_status.no_active_manufacturing_orders') }}</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($orders as $order)
                            <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-white/10 dark:bg-white/5">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="text-sm font-bold text-gray-950 dark:text-white">{{ $order['reference'] }}</span>
                                            <x-filament::badge :color="$order['priority']->getColor()" :icon="$order['priority']->getIcon()" size="sm">
                                                {{ $order['priority']->getLabel() }}
                                            </x-filament::badge>
                                            <x-filament::badge :color="$order['status']->getColor()" size="sm">
                                                {{ $order['status']->getLabel() }}
                                            </x-filament::badge>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $order['product'] }}
                                            <span class="text-gray-400 dark:text-gray-500">&middot; {{ __('sfd::widgets.production_status.qty', ['quantity' => $order['quantity']]) }}</span>
                                        </p>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        @if ($order['deadline'])
                                            <span @class([
                                                'text-xs font-medium',
                                                'text-red-600 dark:text-red-400' => $order['deadline_urgent'],
                                                'text-gray-500 dark:text-gray-400' => ! $order['deadline_urgent'],
                                            ])>
                                                @if ($order['deadline_urgent'])
                                                    <x-filament::icon icon="heroicon-s-exclamation-triangle" class="inline h-3.5 w-3.5" />
                                                @endif
                                                {{ __('sfd::widgets.production_status.due', ['date' => $order['deadline']]) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                {{-- Progress bar --}}
                                <div class="mt-3">
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ __('sfd::widgets.production_status.operations_complete', ['done' => $order['done_wo'], 'total' => $order['total_wo']]) }}</span>
                                        <span>{{ $order['progress'] }}%</span>
                                    </div>
                                    <div class="mt-1 h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700">
                                        <div class="flex h-full">
                                            @if ($order['done_wo'] > 0)
                                                <div class="bg-emerald-500 transition-all" style="width: {{ ($order['done_wo'] / $order['total_wo']) * 100 }}%"></div>
                                            @endif
                                            @if ($order['in_progress_wo'] > 0)
                                                <div class="animate-pulse bg-amber-400 transition-all" style="width: {{ ($order['in_progress_wo'] / $order['total_wo']) * 100 }}%"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-filament::section>
        </div>

        {{-- Right Column: Work Center Load + Recently Completed --}}
        <div class="space-y-6">
            {{-- Work Center Utilization --}}
            <x-filament::section :heading="__('sfd::widgets.production_status.work_center_load')" icon="heroicon-o-building-office">
                <div class="space-y-4">
                    @foreach ($workCenters as $wc)
                        <div>
                            <div class="flex items-center justify-between">
                                <div class="min-w-0">
                                    <span class="text-sm font-medium text-gray-950 dark:text-white">{{ $wc['name'] }}</span>
                                    <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">{{ $wc['code'] }}</span>
                                </div>
                                <div class="shrink-0 text-right">
                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ $wc['active'] }}/{{ $wc['capacity'] }}</span>
                                    @if ($wc['pending'] > 0)
                                        <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">{{ __('sfd::widgets.production_status.queued', ['count' => $wc['pending']]) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700">
                                <div @class([
                                    'h-full rounded-full transition-all',
                                    'bg-emerald-500' => $wc['utilization'] < 70,
                                    'bg-amber-500' => $wc['utilization'] >= 70 && $wc['utilization'] < 100,
                                    'bg-red-500' => $wc['utilization'] >= 100,
                                ]) style="width: {{ $wc['utilization'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-filament::section>

            {{-- Recently Completed --}}
            <x-filament::section :heading="__('sfd::widgets.production_status.recently_completed')" icon="heroicon-o-check-circle">
                @if (empty($recentlyCompleted))
                    <p class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('sfd::widgets.production_status.no_completed_work_orders') }}</p>
                @else
                    <div class="space-y-3">
                        @foreach ($recentlyCompleted as $wo)
                            <div class="flex items-start gap-3">
                                <div @class([
                                    'mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full',
                                    'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' => $wo['on_time'],
                                    'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400' => ! $wo['on_time'],
                                ])>
                                    <x-filament::icon
                                        :icon="$wo['on_time'] ? 'heroicon-s-check' : 'heroicon-s-clock'"
                                        class="h-3.5 w-3.5"
                                    />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-950 dark:text-white">{{ $wo['name'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $wo['mo_reference'] }} &middot; {{ $wo['work_center'] }}
                                        @if ($wo['duration'])
                                            &middot; {{ __('sfd::widgets.production_status.duration_min', ['duration' => $wo['duration']]) }}
                                        @endif
                                    </p>
                                </div>
                                <span class="shrink-0 text-xs text-gray-400 dark:text-gray-500">{{ $wo['completed_at'] }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-filament::section>
        </div>
    </div>
</x-filament-widgets::widget>
