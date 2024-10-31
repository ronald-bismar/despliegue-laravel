<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Http\Response as status;

class TestProductos extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    protected static $urls;
    protected $data;
    protected $dataIngresarCategoria;
    protected $dataProducto;

    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$urls = "/api/categoria";
        
    }
    //seTup-->
    public function setUp() : void {
        parent::setUp();
        $this->artisan('migrate');
        $this->dataIngresarCategoria = Categoria::factory()->create();
        $this->dataProducto = Producto::factory()->count(5)->for($this->dataIngresarCategoria)->create();
        
    }

    //listado de datos.
    public function test_list(){
        //Artisan::all('migrate');
        print_r($this->dataProducto);
        
        $data = $this->getJson(self::$urls);

        $data->assertStatus(status::HTTP_OK);

    }
}
