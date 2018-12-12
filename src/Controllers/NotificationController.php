<?php

namespace Oxygencms\Notifications\Controllers;

use JavaScript;
use Oxygencms\Notifications\Models\Notification;
use Oxygencms\Notifications\Models\NotificationField;
use Illuminate\Support\Facades\Cache;
use Oxygencms\Core\Controllers\Controller;
use Oxygencms\Notifications\Requests\AdminNotificationRequest as NotificationRequest;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Notification::class);

        $arrItems = scandir($_SERVER['DOCUMENT_ROOT'].'/../app/Notifications');
        foreach ($arrItems as $item) {
            if (strlen($item) > 2) {
                $item = preg_replace('/\.php/', '', $item);
                if (empty(Notification::where('class', $item)->get()->first())) {
                    Notification::create([
                                            'class' => $item,
                                            'channels' => json_encode(['mail']),
                                            'description' => '*Email template for the event '.$item.' / automatically generated*'
                                            'active' => 1
                                        ]);
                }
            }
        }

        JavaScript::put(['models' => Notification::allWithAccessors('edit_url')]);

        return view('oxygencms::admin.notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Notification::class);

        return view('oxygencms::admin.notifications.create', ['notification' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NotificationRequest $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(NotificationRequest $request)
    {
        $this->authorize('create', Notification::class);

        $notification = Notification::create($request->validated());

        Cache::tags('notifications')->flush();

        notification("$notification->model_name successfully created.");

        return redirect()->route('admin.notification.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Notification $notification
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Notification $notification)
    {
        $this->authorize('update', Notification::class);

        return view('oxygencms::admin.notifications.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NotificationRequest $request
     * @param Notification $notification
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(NotificationRequest $request, Notification $notification)
    {
        $this->authorize('update', Notification::class);

        $notification->update($request->except('channels'));
        $notification->channels = json_encode($request->has('channels') ? $request->input('channels') : []);
        $notification->save();

        $notification->fields()->delete();
        if ($request->has('field_name')) {
            $i = 0;
            $arrFields = $request->input('field_name');
            while (++$i < sizeof($arrFields)) {
                $field = new NotificationField();
                $field->notification_id = $notification->id;
                // $field->name = $request->input('field_name')[$i];
                // $field->placeholders = json_encode(explode(',', $request->input('placeholders')[$i]));
                $arr = [];
                foreach (config('oxygen.locales') as $l => $lang) {
                    $arr[$l] = $request->input('field_value-'.$l)[$i];
                }
                $field->value = $arr;
                $field->save();
            }
        }

        Cache::tags('notifications')->flush();

        notification("$notification->model_name successfully updated.");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notification $notification
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', Notification::class);

        $notification->delete();

        Cache::tags('notifications')->flush();

        return jsonNotification($notification->model_name . ' successfully deleted.');
    }
}
