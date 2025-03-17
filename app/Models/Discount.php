<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';

    protected $fillable = [
        'code',
        'percentage',
        'status',
    ];

    // Verify if the discount is available
    public function isDiscountAvailable(): bool
    {
        return $this->status === true;
    }
}
