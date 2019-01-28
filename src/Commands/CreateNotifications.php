<?php

namespace Oxygencms\Notifications\Commands;

use Illuminate\Console\Command;
use Oxygencms\Core\Models\Model;
use Spatie\Translatable\HasTranslations;
use Oxygencms\Notifications\Models\NotificationField;
use Oxygencms\Notifications\Models\Notification;
use Oxygencms\Notifications\Commands\CreateNotifications;

class CreateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oxy:notifications:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create missing notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arrItems = scandir(base_path('app/Notifications'));
        foreach ($arrItems as $item) {
            if (strlen($item) > 2) {
                $item = preg_replace('/\.php/', '', $item);
                if (empty(Notification::where('class', $item)->get()->first())) {
                    $n = Notification::create([
                                            'class' => $item,
                                            'channels' => json_encode(['mail']),
                                            'description' => 'Default email template for the '.$item.' event',
                                            'active' => 1,
                                            'subject' => 'Default subject for the '.$item.' event',
                                            'button_title' => 'More Details',
                                            'url' => 'http://www.kuukz.com',
                                        ]);

                    $arr = [];
                    foreach (config('oxygen.locales') as $l => $lang) {
                        $arr[$l] = 'Default content for the first notification field';
                    }

                    $nf = NotificationField::create([
                                            'notification_id' => $n->id,
                                            'value' => $arr,
                                        ]);

                    $this->info('Notification template created for '.$item);
                }
            }
        }
    }
}
