<!-- resources/views/past-flights.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Past Flights</h1>

    <!-- Display Past Flights -->
    @foreach ($flights as $flight)
        <div class="flight-card">
            <h3>{{ $flight->departure_location }} - {{ $flight->arrival_location }}</h3>
            <p>Departure Date: {{ $flight->departure_date }}</p>
            <p>Total Seats: {{ $flight->plane->max_seat }}</p>
            <p>Reserved Seats: {{ $flight->reservations->count() }}</p>
        </div>
    @endforeach
</div>
@endsection
