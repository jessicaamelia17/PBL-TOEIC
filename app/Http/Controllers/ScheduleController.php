<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedule = [
            ['day' => 'Monday', 'date' => '17/11/2025'],
            ['day' => 'Tuesday', 'date' => '18/11/2025'],
            ['day' => 'Wednesday', 'date' => '19/11/2025'],
            ['day' => 'Thursday', 'date' => '20/11/2025'],
            ['day' => 'Friday', 'date' => '21/11/2025'],
            ['day' => 'Saturday', 'date' => '22/11/2025'],
            ['day' => 'Monday', 'date' => '24/11/2025'],
            ['day' => 'Tuesday', 'date' => '25/11/2025'],
        ];

        return view('schedule.index', compact('schedule'));
    }
}