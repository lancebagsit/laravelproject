@extends('layouts.app')

@section('content')
<div class="container" id="user-donations" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>My Donations</h2></div>
  @if(isset($items) && count($items))
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>Date</th><th>Amount</th><th>Reference</th></tr></thead>
          <tbody>
            @foreach($items as $d)
              <tr>
                <td>{{ $d->created_at }}</td>
                <td>{{ $d->donation_amount ?? '-' }}</td>
                <td>{{ $d->reference_number ?? '-' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @else
    <p class="text-center">No donations found.</p>
  @endif
  <div class="text-center" style="margin-top:12px;">
    <a href="/donate" class="btn btn-login-secondary">Make a Donation</a>
  </div>
</div>
@endsection
