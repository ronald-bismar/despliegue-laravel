<?php

namespace Tests\Unit;

use App\Models\Categoria;
use PHPUnit\Framework\TestCase;

class CategoriaTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_descripccion(){
        //Detalle: nombre, descripcion: descripcion
        //Detalle: Computadora de escritorio, Descripcion: Computadoras con mause, monitor, teclado, CPU
        //caso 1: NOrmal
        //caso 2: Minusculas, computadota ---Computadora
        //caso 3: ----computadora, Conputadora
        $categoria=new Categoria();
        $categoria->Nombre = "     computadora de escritorio";
        $categoria->Descripcion = "Computadoras con mause, monitor, teclado, CPU";
        $this->assertEquals("Detalle: Computadora de escritorio, Descripcion: Computadoras con mause, monitor, teclado, CPU", $categoria->getDescripcion());
    }

    public function test_(){

    }
}
