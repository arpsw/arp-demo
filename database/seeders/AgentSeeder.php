<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ai\Models\Agent;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        $provider = config('services.anthropic.key') ? 'anthropic' : 'openai';

        $providerConfig = match ($provider) {
            'anthropic' => [
                'model' => 'claude-sonnet-4-5',
                'parameters' => [
                    'temperature' => 0.7,
                    'max_tokens' => 2048,
                ],
            ],
            default => [
                'model' => 'gpt-4o-mini',
                'parameters' => [
                    'temperature' => 0.7,
                    'max_tokens' => 2048,
                ],
            ],
        };

        Agent::firstOrCreate(
            ['name' => 'General Assistant'],
            [
                'description' => 'A helpful general-purpose assistant.',
                'system_message' => 'You are a helpful assistant. Answer questions clearly and concisely.',
                'provider' => $provider,
                'provider_config' => $providerConfig,
                'tools' => [],
                'expose_as_tool' => false,
            ]
        );
    }
}
