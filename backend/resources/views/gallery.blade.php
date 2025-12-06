@extends('layouts.app')

@section('content')
<h2>Gallery</h2>
<div class="row">
    @forelse($items as $item)
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="{{ $item->url }}" alt="{{ $item->title }}">
                <div class="caption">
                    <h4>{{ $item->title }}</h4>
                </div>
            </div>
        </div>
    @empty
        <p>No images yet.</p>
    @endforelse
}</div>
@endsection
