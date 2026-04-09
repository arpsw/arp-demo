<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->components([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('Email address'),
                        TextEntry::make('email_verified_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columns(2),
                Section::make('Roles')
                    ->components([
                        TextEntry::make('roles.name')
                            ->badge()
                            ->separator(', ')
                            ->placeholder('No roles assigned'),
                    ]),
            ]);
    }
}
