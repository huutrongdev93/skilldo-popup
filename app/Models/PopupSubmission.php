<?php
namespace Popup\Models;

use SkillDo\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PopupSubmission extends Model
{
    protected string $table = 'popups_submission';

    protected string $primaryKey = 'submission_id';

    protected array $columns = [
        'data' => ['array', []]
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::retrieved(function (PopupSubmission $popup)
        {
            if(Str::isSerialized($popup->data))
            {
                $popup->data = unserialize($popup->data);
            }
        });
    }
}