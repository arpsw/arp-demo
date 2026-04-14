<?php

namespace Modules\SFD\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum QualityCheckType: string implements HasColor, HasIcon, HasLabel
{
    case PassFail = 'pass_fail';
    case Measurement = 'measurement';
    case Visual = 'visual';

    public function getLabel(): string
    {
        return __('sfd::enums.quality_check_type.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PassFail => Color::Blue,
            self::Measurement => Color::Purple,
            self::Visual => Color::Cyan,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::PassFail => Heroicon::CheckCircle,
            self::Measurement => Heroicon::ChartBar,
            self::Visual => Heroicon::Eye,
        };
    }
}
