<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\SendReminderEmail;
use App\Models\Schedule;
use App\Models\UserMassReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReminderController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(302, '', ['Location' => '/login']);
        }
        $validated = $request->validate([
            'schedule_id' => 'required|integer|exists:schedules,id',
        ]);
        $schedule = Schedule::findOrFail($validated['schedule_id']);
        $start = $schedule->start_at ?? null;
        if (!$start || $start->isPast()) {
            return back()->withErrors(['Cannot set reminders for past or unspecified dates']);
        }
        UserMassReminder::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id,
            'start_at' => $start,
        ]);

        $to = Auth::user()->email;
        $subject = 'Mass Reminder';
        $baseMsg = 'Reminder: Mass starts at '.$start->format('M d, Y h:i A');

        $oneDay = $start->copy()->subDay();
        $oneHour = $start->copy()->subHour();

        if ($oneDay->isFuture()) {
            SendReminderEmail::dispatch($to, $subject, $baseMsg.' (in 1 day)')->delay($oneDay);
        }
        if ($oneHour->isFuture()) {
            SendReminderEmail::dispatch($to, $subject, $baseMsg.' (in 1 hour)')->delay($oneHour);
        }

        return back()->with('status', 'Reminders scheduled');
    }
}
