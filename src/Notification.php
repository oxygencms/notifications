<?php

namespace Oxygencms\Notifications;

use \Oxygencms\Notifications\Models\Notification as Template;
use Illuminate\Notifications\Notification as BaseNotification;

class Notification extends BaseNotification
{
    protected $class;

    public $template;

    public function __construct($class)
    {
        $this->class = $class;
        $this->template = Template::where('class', preg_replace('/.*?\\\\/', '', $this->class))->get()->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        /**
         * It's optional() be cause in some cases the model may not be present
         * (php artisan migrate:fresh --seed for example), in this
         * case we do not want to send notifications.
         */
        if (! optional($this->template)->active) {
            return [];
        }

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return bool|\Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (empty($this->template)) {
            return false;
        }

        $data = [
            'url' => '/',
            'names' => 'Dear Friend',
            'subject' => $this->template->subject,
            'fields' => $this->template->fields,
            'button_title' => $this->template->button_title,
        ];

        return (new MailMessage)
            ->view('mails.default', $data)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->template->subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Fill placeholders in notification subject or content.
     *
     * @param string $content
     * @param array $placeholders
     *
     * @return string
     */
    public function parsePlaceholders($content, $placeholders)
    {
        $keys = config('oxy_notifications.keys');

        foreach ($placeholders as $k => $v) {
            if ($k == 'pa_serial') {
                $content = preg_replace('/' . $keys[$k] . '/', (int)$v, $content);
                continue;
            }

            $content = preg_replace('/' . $keys[$k] . '/', $v, $content);
        }

        return $content;
    }
}
