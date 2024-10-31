<?php

namespace Tests\Unit;

use App\Models\Categoria;
use PHPUnit\Framework\TestCase;

class PrimerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $result = 1 + 1;

        $this->assertEquals(2, $result);
    }

    public function test_getNombre(){
        $cate = new Categoria();
         
        $cate->Nombre = 'Laptop';
        $cate->CategoriaID = '1';
        $this->assertEquals('Laptop - 1', $cate->getNombreProducto());
    }
}
