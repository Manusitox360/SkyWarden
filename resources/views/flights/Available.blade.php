@extends('layouts.app')
@section('title', 'Vuelos Disponibles')


@section('content')
<div class="container">
    <h2>Vuelos Disponibles ✈️</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Destino</th>
                <th>Fecha de Salida</th>
                <th>Plazas Totales</th>
                <th>Plazas Libres</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flights as $flight)
                <tr>
                    <td>{{ $flight->destination }}</td>
                    <td>{{ \Carbon\Carbon::parse($flight->departure_date)->format('d/m/Y H:i') }}</td>
                    <td>{{ $flight->plane->max_seat }}</td>
                    <td>{{ $flight->plane->max_seat - $flight->reservations->count() }}</td>
                    <td>
                        @if(Auth::check() && Auth::user()->role !== 'admin')
                            @if(!$flight->isReservedBy(Auth::user()))
                                <!-- Botón de Reservar -->
                                <form action="{{ route('reservations.store', $flight->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Reservar</button>
                                </form>
                            @else
                                <!-- Obtener la reserva del usuario para cancelar -->
                                @php
                                    $reservation = $flight->reservations->where('user_id', Auth::user()->id)->first();
                                @endphp
                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
                                </form>
                            @endif
                        @else
                            <span class="badge bg-secondary">Admin</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
