<?php

namespace Oxygencms\Core\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class LogsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = DB::table('activity_log');

        if ($request->has('action')) {
            $query->where('description', $request->action);
        }

        [$since, $until] = [$request->since, $request->until];

        if ($since) {
            $query->where('created_at', '>=', Carbon::parse($since));
        }

        if ($since) {
            $query->where('created_at', '<=', Carbon::parse($until));
        }

        $logs = $query->latest()->paginate(100);

        return view('oxygencms::admin.logs.index', compact('logs'));
    }

    /**
     * @param Activity $log
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Activity $log)
    {
        return view('oxygencms::admin.logs.show', compact('log'));
    }
}
