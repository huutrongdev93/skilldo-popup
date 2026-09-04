<?php
namespace Popup\Enum;

use Illuminate\Support\Collection;

enum PopupStatus: string
{
    case RUN = 'run';

    case STOP = 'stop';

    public function label(): string
    {
        return match ($this)
        {
            self::RUN   => 'Đang sử dụng',
            self::STOP  => 'Đã tắt',
            default => 'Unknown',
        };
    }

    public function color(): string
    {
        return match ($this)
        {
            self::RUN   => '#22c993',
            default => '#36a3f7',
        };
    }

    public function badge(): string
    {
        return match ($this)
        {
            self::RUN   => 'green',
            default => 'red',
        };
    }

    static function options(): Collection
    {
        return new Collection(array_map(fn ($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases()));
    }

    static function has(string $value): bool
    {
        return in_array($value, array_column(self::cases(), 'value'), true);
    }
}