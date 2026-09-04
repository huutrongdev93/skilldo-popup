<?php
namespace Popup\Models;

use SkillDo\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Popup extends Model
{
    protected string $table = 'popups';

    protected string $primaryKey = 'popup_id';

    protected array $columns = [
        'settings' => ['array', []]
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::retrieved(function (Popup $popup)
        {
            if(Str::isSerialized($popup->settings))
            {
                $popup->settings = unserialize($popup->settings);
            }
        });
    }
}