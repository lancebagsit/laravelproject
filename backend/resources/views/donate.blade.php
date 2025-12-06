@extends('layouts.app')

@section('content')
<h2>Donate</h2>
@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="/donate">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="contact_number">Contact Number</label>
        <input type="text" class="form-control" id="contact_number" name="contact_number">
    </div>
    <div class="form-group">
        <label for="mode_of_payment">Mode of Payment</label>
        <input type="text" class="form-control" id="mode_of_payment" name="mode_of_payment">
    </div>
    <div class="form-group">
        <label for="reference_number">Reference Number</label>
        <input type="text" class="form-control" id="reference_number" name="reference_number">
    </div>
    <div class="form-group">
        <label for="donation_amount">Donation Amount</label>
        <input type="number" step="0.01" class="form-control" id="donation_amount" name="donation_amount">
    </div>
    <button type="submit" class="btn btn-primary">Submit Donation</button>
</form>
@endsection
