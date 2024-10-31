<?php

namespace Tests\Feature;

use App\Models\Ventas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\Response as status;

class VentasTest extends TestCase
{
    
    protected static $urls;
    protected static $dataIngresar;
    protected static $createVentas;
    //setClass -- se solo una sol vez, carga todo los datos URLS
    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$urls = "/api/ventas";
        //self::$dataIngresar = Ventas::factory()->count(10)->make();
        self::$createVentas = Ventas::factory()->create([
            'ProductoID'=> 1,
            'cantidad'=>20,
            'precio_total'=>100
        ]);
        
    }

    //setUp
    public function setUp(): void {
        parent::setUp();
        $this->artisan("migrate");
        
    }

    public function test_list(){
        print_r(self::$dataIngresar);
        $response = $this->getJson(self::$urls);
        //print($response->json());

        $responseJson = $response->json();
        print_r($responseJson);
        $response->assertStatus(status::HTTP_OK);

        $this->assertEquals([], $responseJson);
    }

    /*public function test_register() {
        $this->assertIsBool(true);
    }*/
}
