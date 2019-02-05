<?php

namespace Oxygencms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;

class Notification extends BaseNotification
{
    use Queueable;

	protected $class;

	public $template;

    public function __construct($class)
    {
    	$this->class = $class;
        $this->template = \Oxygencms\Notifications\Models\Notification::where('class', preg_replace('/.*?\\\\/', '', $this->class))
                                                                        ->get()
                                                                        ->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return empty($this->template) ? false : (new MailMessage)->view(
            'mails.default', [
                'url' => '/',
                'names' => 'Dear Friend',
                'subject' => $this->template->subject,
                'fields' => $this->template->fields,
                'button_title' => $this->template->button_title,
            ]
        )->from(env('MAIL_FROM'), env('MAIL_FROM_NAME'))->subject($this->template->subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
