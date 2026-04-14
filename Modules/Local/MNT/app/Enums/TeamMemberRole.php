<?php

namespace Modules\MNT\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum TeamMemberRole: string implements HasColor, HasIcon, HasLabel
{
    case Member = 'member';
    case Leader = 'leader';

    public function getLabel(): string
    {
        return match ($this) {
            self::Member => __('mnt::enums.team_member_role.member'),
            self::Leader => __('mnt::enums.team_member_role.leader'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Member => Color::Gray,
            self::Leader => Color::Purple,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Member => Heroicon::User,
            self::Leader => Heroicon::Star,
        };
    }
}
