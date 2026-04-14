<?php

namespace Modules\SFD\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum ProductType: string implements HasColor, HasIcon, HasLabel
{
    case Finished = 'finished';
    case SubAssembly = 'sub_assembly';
    case RawMaterial = 'raw_material';

    public function getLabel(): string
    {
        return __('sfd::enums.product_type.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Finished => Color::Green,
            self::SubAssembly => Color::Blue,
            self::RawMaterial => Color::Gray,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Finished => Heroicon::CubeTransparent,
            self::SubAssembly => Heroicon::Cog6Tooth,
            self::RawMaterial => Heroicon::Cube,
        };
    }
}
