<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Producto;
use PHPUnit\Framework\TestCase;

class TestProductos extends TestCase
{

    //use RefreshDatabase;
    
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    //test de crear un objetivo.
    public function testPrecioUnitario(): void{
        //$produc = new Producto(['ProductoID'=>100, "CategoriaID"=>1, "Nombre"=>"Monitor", "PrecioUnitario"=>200, "stock"=>10, "Descripcion"=>"Monitores de computadoras de escritorio"]);
        $datas = Producto::find('1');
        print_r($datas);
        //$this->assertEquals(1, $datas[0]);
    }
}

//assertDatabaseHas --para la compracion
//::factory()->create -- crea factorys o agrgar datos
