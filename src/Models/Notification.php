<?php

namespace Oxygencms\Notifications\Models;

use Oxygencms\Core\Models\Model;
use Spatie\Translatable\HasTranslations;
use Oxygencms\Notifications\Models\NotificationField;

class Notification extends Model
{
    use HasTranslations;

    /**
     * Attributes that should be mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'subject', 'description', 'layout', 'template', 'use_html', 'active', 'channels'
    ];

    public $translatable = ['subject'];

    public $appends = ['model_name'];

    /**
     * @return HasMany
     */
    public function fields()
    {
        return $this->hasMany(NotificationField::class);
    }
}
