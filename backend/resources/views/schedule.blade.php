@extends('layouts.app')

@section('content')
<h2>Mass Schedule</h2>
<table class="table table-striped schedule-table">
    <thead>
        <tr>
            <th>Time</th>
            <th>Language</th>
        </tr>
    </thead>
    <tbody>
    @forelse($schedules as $s)
        <tr>
            <td>{{ $s->time }}</td>
            <td>{{ $s->language }}</td>
        </tr>
    @empty
        <tr><td colspan="2">No schedule posted.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
