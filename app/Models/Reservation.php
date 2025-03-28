<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'flight_id',
        'status',
        'seat_number',
    ];

    // Relation with flight
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // Verify if the reservation is available
    public function isReservationAvailable(): bool
    {
        return $this->status === true;
    }
    // Relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Accessor for seat number
    public function getSeatNumberAttribute($value)
    {
        return $value ? (int) $value : null;
    }
}
