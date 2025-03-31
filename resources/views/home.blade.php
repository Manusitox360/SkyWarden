@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Vuelos Disponibles ✈️</h1>

    @if ($flights->isEmpty())
        <p class="text-gray-500">No hay vuelos disponibles en este momento.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($flights as $flight)
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-lg font-semibold">Destino: {{ $flight->destination }}</h2>
                    <p>Salida: <strong>{{ $flight->departure_date }}</strong></p>
                    <p>Asientos ocupados: {{ $flight->reservations->count() }} / {{ $flight->plane->max_seat }}</p>

                    @auth
                        @if (auth()->user()->is_admin)
                            <p class="text-red-500">Los administradores no pueden reservar vuelos.</p>
                        @else
                            @if ($flight->reservations->where('user_id', auth()->id())->isEmpty())
                                <form action="{{ route('reservations.store', $flight->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Reservar</button>
                                </form>
                            @else
                                <form action="{{ route('reservations.cancel', $flight->reservations->where('user_id', auth()->id())->first()->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mt-2 px-4 py-2 bg-red-500 text-white rounded">Cancelar Reserva</button>
                                </form>
                            @endif
                        @endif
                    @else
                        <p class="text-blue-500">Inicia sesión para reservar un vuelo.</p>
                    @endauth
                </div>
            @endforeach
        </div>
    @endif
@endsection
