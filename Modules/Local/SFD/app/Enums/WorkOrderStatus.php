<?php

namespace Modules\SFD\Enums;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum WorkOrderStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';
    case Ready = 'ready';
    case InProgress = 'in_progress';
    case Paused = 'paused';
    case Done = 'done';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return __('sfd::enums.work_order_status.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => Color::Gray,
            self::Ready => Color::Blue,
            self::InProgress => Color::Orange,
            self::Paused => Color::Amber,
            self::Done => Color::Green,
            self::Cancelled => Color::Red,
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Pending => Heroicon::Clock,
            self::Ready => Heroicon::PlayCircle,
            self::InProgress => Heroicon::ArrowPath,
            self::Paused => Heroicon::ExclamationTriangle,
            self::Done => Heroicon::CheckCircle,
            self::Cancelled => Heroicon::XCircle,
        };
    }
}
