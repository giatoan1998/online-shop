<?php

namespace App\Models;

use App\Mail\OrderEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items() {

        return $this->hasMany((OrderItem::class));
    }
}
