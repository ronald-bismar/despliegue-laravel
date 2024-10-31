<?php

namespace App\Http\Controllers;

use App\Models\Producto;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

use function PHPSTORM_META\map;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$cursos = Producto::all();
        //return response()->json($cursos, Response::HTTP_OK);

        //manejo de ORM
        $productos = Producto::with('categoria')->get();
        $retornar = $productos->map(fn ($producto) =>[
                "idP" => $producto->ProductoID,
                "nombreProducto" => $producto->Nombre,
                "idC" => $producto->CategoriaID,
                "nombreCategoria" => $producto->categoria->Nombre
            ]
        );

        return response()->json($retornar, HttpFoundationResponse::HTTP_OK);

    }

    public function consultaFecha(Request $request) {

        //carbon, clase para validar datos por fechas
        $fechaI = $request->input("fechaI");
        $fechaF = $request->input("fechaF");
        $productos =Validator::make($request->all(),[
            "fechaI" => 'required|data',
            "fechaF" => 'required|data',
        ],[
            'fechaI.required'=>"El campo nombre es obligatorio",
            'fechaF.reqiered'=>"El campo nombre es obligatorio",
        ]);

        if ($productos->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Hay errores en los datos proporcionados.',
                'errors' => $productos->errors(),
            ], 422);
        }

        $productos = Producto::with('categoria')->whereBetween('created_at', [$fechaI, $fechaF])->get();
        $retornar = $productos->map(fn ($producto) =>[
                "idP" => $producto->ProductoID,
                "nombreProducto" => $producto->Nombre,
                "idC" => $producto->CategoriaID,
                "nombreCategoria" => $producto->categoria->Nombre
            ]
        );

        return response()->json($retornar, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return Producto::create($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Producto::find($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $curso = Producto::find($id);
        $curso->update($request->all());
        return $curso;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return Producto::destroy($id);

    }
}
