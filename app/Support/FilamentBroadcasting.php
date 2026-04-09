<?php

declare(strict_types=1);

namespace App\Support;

final class FilamentBroadcasting
{
    public static function configureEcho(): void
    {
        if (config('broadcasting.default') !== 'reverb') {
            return;
        }

        /** @var array<string, mixed>|null $reverb */
        $reverb = config('broadcasting.connections.reverb');

        if (! is_array($reverb) || empty($reverb['key'])) {
            return;
        }

        $options = is_array($reverb['options'] ?? null) ? $reverb['options'] : [];

        $host = $options['host'] ?? 'localhost';
        $port = (int) ($options['port'] ?? 8080);
        $useTls = ($options['useTLS'] ?? false) === true;

        config([
            'filament.broadcasting.echo' => [
                'broadcaster' => 'reverb',
                'key' => $reverb['key'],
                'wsHost' => $host,
                'wsPort' => $port,
                'wssPort' => $port,
                'forceTLS' => $useTls,
                'enabledTransports' => ['ws', 'wss'],
                'authEndpoint' => '/broadcasting/auth',
                'disableStats' => true,
            ],
        ]);
    }
}
