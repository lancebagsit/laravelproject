@extends('layouts.app')

@section('content')
<h2>Announcements</h2>
@forelse($announcements as $a)
    <div class="panel panel-default">
        <div class="panel-heading">{{ $a->title }}</div>
        <div class="panel-body">{{ $a->content }}</div>
    </div>
@empty
    <p>No announcements yet.</p>
@endforelse
@endsection
