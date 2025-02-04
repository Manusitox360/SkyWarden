<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $fillable = [
        'city',
        'country',
        'airport_code',
    ];

     // Flights that depart from this location
     public function departingFlights()
     {
         return $this->hasMany(Flight::class, 'departure_location_id');
     }
 
     // Flights that arrive at this location
     public function arrivingFlights()
     {
         return $this->hasMany(Flight::class, 'arrival_location_id');
     }
}
