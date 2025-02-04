<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    use HasFactory;
    protected $table = 'planes';

    protected $fillable = [
        'name',
        'max_seat',
    ];

    // Relation with flights
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
