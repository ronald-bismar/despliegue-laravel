<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    //primary key
    protected $primaryKey = 'VentaID'; 
    protected $fillable = ["VentaID", "ProductoID", "cantidad", "precio_total"];
}
