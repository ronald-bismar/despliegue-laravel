<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    
    
    use HasFactory;
    protected $primaryKey = 'ProductoID'; 
    protected $fillable = ["ProductoID", "CategoriaID","Nombre", "PrecioUnitario", "stock", "Descripcion"];


    public function categoria(){
        return $this->belongsTo(Categoria::class, 'CategoriaID');
    }

    public function getPrecioUnitario() {
        return $this->PrecioUnitario;
    }
}
