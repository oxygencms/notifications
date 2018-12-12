<?php

namespace Oxygencms\Notifications\Models;

use Oxygencms\Core\Models\Model;
use Spatie\Translatable\HasTranslations;
use Oxygencms\Notifications\Models\Notification;

class NotificationField extends Model
{
    use HasTranslations;

    /**
     * Attributes that should be mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'notification_id', 'name', 'valie', 'placeholders'
    ];

    public $translatable = ['value'];

    /**
     * Notification
     *
     * @return BelongsTo
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
