<?php

namespace Modules\SFD\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum QualityCheckResult: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';
    case Pass = 'pass';
    case Fail = 'fail';

    public function getLabel(): string
    {
        return __('sfd::enums.quality_check_result.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => Color::Gray,
            self::Pass => Color::Green,
            self::Fail => Color::Red,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Pending => Heroicon::Clock,
            self::Pass => Heroicon::CheckCircle,
            self::Fail => Heroicon::XCircle,
        };
    }
}
