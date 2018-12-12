<?php

namespace Oxygencms\Core\Controllers;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('oxygencms::admin.dashboard');
    }
}
