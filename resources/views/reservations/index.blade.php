@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mis Reservas 🎟️</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Vuelo</th>
                <th>Destino</th>
                <th>Fecha de Salida</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->flight->id }}</td>
                    <td>{{ $reservation->flight->destination }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->flight->departure_date)->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
