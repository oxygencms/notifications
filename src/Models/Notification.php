<?php

namespace Oxygencms\Notifications\Models;

use Oxygencms\Core\Models\Model;
use Spatie\Translatable\HasTranslations;
use Oxygencms\Notifications\Models\NotificationField;
use Composer\Script\Event;
use Illuminate\Contracts\Console\Kernel;

class Notification extends Model
{
    use HasTranslations;

    /**
     * Attributes that should be mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'class', 'subject', 'description', 'layout', 'template', 'use_html', 'active', 'channels', 'button_title'
    ];

    public $translatable = ['subject', 'button_title'];

    public $appends = ['model_name'];

    /**
     * @return HasMany
     */
    public function fields()
    {
        return $this->hasMany(NotificationField::class);
    }
}
