<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\GalleryItem;
use App\Models\Priest;
use App\Models\Schedule;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $announcements = Announcement::latest()->take(5)->get();
        return view('home', compact('announcements'));
    }

    public function gallery()
    {
        $items = GalleryItem::latest()->get();
        return view('gallery', compact('items'));
    }

    public function priests()
    {
        $priests = Priest::latest()->get();
        return view('priests', compact('priests'));
    }

    public function announcements()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements', compact('announcements'));
    }

    public function schedule()
    {
        $schedules = Schedule::all();
        return view('schedule', compact('schedules'));
    }

    public function donate()
    {
        return view('donate');
    }

    public function team()
    {
        return view('team');
    }
}
