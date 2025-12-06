@extends('layouts.app')

@section('content')
<div class="container" id="admin-gallery" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>Gallery</h2></div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Add Image</div>
        <div class="panel-body">
          <form method="POST" action="/admin/gallery">
            @csrf
            <div class="form-group"><label>Title</label><input type="text" name="title" class="form-control" required /></div>
            <div class="form-group"><label>Image URL</label><input type="url" name="url" class="form-control" required /></div>
            <button type="submit" class="btn btn-custom btn-lg">Save</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Existing</div>
        <div class="panel-body">
          @forelse($items as $item)
            <div class="panel panel-info">
              <div class="panel-heading"><strong>{{ $item->title }}</strong></div>
              <div class="panel-body">
                <img src="{{ $item->url }}" alt="{{ $item->title }}" class="img-responsive" style="max-height:150px;" />
                <form method="POST" action="/admin/gallery/{{ $item->id }}" style="margin-top:10px;">
                  @csrf
                  <input type="hidden" name="title" value="{{ $item->title }}" />
                  <input type="hidden" name="url" value="{{ $item->url }}" />
                  <button type="submit" class="btn btn-primary">Quick Update</button>
                </form>
                <form method="POST" action="/admin/gallery/{{ $item->id }}/delete" style="display:inline-block; margin-left:10px;">
                  @csrf
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </div>
            </div>
          @empty
            <p>No images yet.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

