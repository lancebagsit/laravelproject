@extends('layouts.app')

@section('content')
<div class="container" id="admin-priests" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>Priest</h2></div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Create / Edit</div>
        <div class="panel-body">
          <form method="POST" action="/admin/priest">
            @csrf
            <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" required /></div>
            <div class="form-group"><label>Image URL</label><input type="text" name="image" class="form-control" /></div>
            <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="4"></textarea></div>
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
              <div class="panel-heading"><strong>{{ $item->name }}</strong></div>
              <div class="panel-body">
                @if($item->image)
                  <img src="{{ $item->image }}" alt="{{ $item->name }}" class="img-responsive" style="max-height:150px;" />
                @endif
                <p>{{ $item->description }}</p>
                <form method="POST" action="/admin/priest/{{ $item->id }}" style="margin-top:10px;">
                  @csrf
                  <input type="hidden" name="name" value="{{ $item->name }}" />
                  <input type="hidden" name="image" value="{{ $item->image }}" />
                  <input type="hidden" name="description" value="{{ $item->description }}" />
                  <button type="submit" class="btn btn-primary">Quick Update</button>
                </form>
                <form method="POST" action="/admin/priest/{{ $item->id }}/delete" style="display:inline-block; margin-left:10px;">
                  @csrf
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </div>
            </div>
          @empty
            <p>No entries yet.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

