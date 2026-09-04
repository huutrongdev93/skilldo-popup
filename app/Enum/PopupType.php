<?php
namespace Popup\Enum;

use Illuminate\Support\Collection;

enum PopupType: string
{
    case DEFAULT = 'default';

    case STYLE = 'style';

    public function label(): string
    {
        return match ($this)
        {
            self::DEFAULT   => 'Tự tạo',
            self::STYLE     => 'Thiết kế sẵn',
            default => 'Unknown',
        };
    }

    public function color(): string
    {
        return match ($this)
        {
            self::STYLE   => '#22c993',
            default => '#36a3f7',
        };
    }

    public function badge(): string
    {
        return match ($this)
        {
            self::DEFAULT        => 'gray',
            self::STYLE   => 'green',
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