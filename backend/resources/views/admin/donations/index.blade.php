@extends('layouts.app')

@section('content')
<div class="container" id="admin-donations" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>Donations</h2></div>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>Name</th><th>Amount</th><th>Reference</th><th>Status</th></tr></thead>
          <tbody>
          @forelse($items as $d)
            <tr>
              <td>{{ $d->name }}</td>
              <td>{{ $d->donation_amount ?? '-' }}</td>
              <td>{{ $d->reference_number ?? '-' }}</td>
              <td>{{ $d->status ?? 'pending' }}</td>
            </tr>
          @empty
            <tr><td colspan="4">No donations yet.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

