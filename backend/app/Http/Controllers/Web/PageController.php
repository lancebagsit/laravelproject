<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\GalleryItem;
use App\Models\Priest;
use App\Models\Schedule;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
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

    public function dashboard()
    {
        if (!auth()->check()) {
            abort(302, '', ['Location' => '/login']);
        }
        if ((int)(auth()->user()->role_id ?? 1) === 2) {
            abort(302, '', ['Location' => '/admin']);
        }
        return view('user.dashboard');
    }
    public function userDonations()
    {
        if (!Auth::check()) { abort(302, '', ['Location' => '/login']); }
        $items = Donation::where('user_id', Auth::id())->latest()->get();
        return view('user.donations', compact('items'));
    }

    public function userCalendar()
    {
        $month = request()->query('month');
        $base = $month ? \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth() : now()->startOfMonth();
        $start = $base->copy()->startOfMonth();
        $end = $base->copy()->endOfMonth();
        $schedules = Schedule::with('priest')
            ->whereNotNull('start_at')
            ->whereBetween('start_at', [$start, $end])
            ->orderBy('start_at')
            ->get();
        return view('user.calendar', [
            'schedules' => $schedules,
            'month' => $base->format('Y-m'),
        ]);
    }
}
