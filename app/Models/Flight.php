<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights';

    protected $fillable = [
        'plane_id',
        'price',
        'departure_date',
        'departure_location_id',
        'arrival_date',
        'arrival_location_id',
        'status',
    ];

    // Relation with plane
    public function plane()
    {
        return $this->belongsTo(Plane::class);
    }

    // Departure location Relation
    public function departureLocation()
    {
        return $this->belongsTo(Location::class, 'departure_location_id');
    }

    // Arrival location Relation
    public function arrivalLocation()
    {
        return $this->belongsTo(Location::class, 'arrival_location_id');
    }

    // Relation with reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    // Verify if the flight is available
    public function isFlightAvailable(): bool
    {
        return $this->status === true 
            && $this->available_seats > 0 // Use snake_case for the accessor
            && $this->departure_date > now();
    }
    
    // Accessor for available seats
    public function getAvailableSeatsAttribute()
    {
        return $this->plane->max_seat - $this->reservations->count();
    }
}
