<?php

namespace Oxygencms\Notifications\Models;

use Oxygencms\Core\Models\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationField extends Model
{
    use HasTranslations;

    /**
     * Attributes that should be mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'notification_id', 'value', 'is_button'
    ];

    public $translatable = ['value'];

    /**
     * Notification
     *
     * @return BelongsTo
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}
