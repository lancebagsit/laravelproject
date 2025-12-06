@extends('layouts.app')

@section('content')
<h2>Priests</h2>
<div class="priest-list">
    @forelse($priests as $p)
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-3">
                        @if($p->image)
                            <img src="{{ $p->image }}" class="img-responsive" alt="{{ $p->name }}">
                        @endif
                    </div>
                    <div class="col-sm-9">
                        <h4>{{ $p->name }}</h4>
                        <p>{{ $p->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No entries yet.</p>
    @endforelse
</div>
@endsection
