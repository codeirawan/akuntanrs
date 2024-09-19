<?php

namespace App\Http\Controllers;

use App\Models\Schedule\ScheduleShift;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
