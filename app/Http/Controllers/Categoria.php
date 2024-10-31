<?php

namespace App\Http\Controllers;


use App\Models\Categoria as ModelsCategoria;
use Illuminate\Http\Response;

use Illuminate\Http\Request;

class Categoria extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cursos = ModelsCategoria::all();
        return response()->json($cursos, Response::HTTP_OK);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return ModelsCategoria::create($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $categoria = ModelsCategoria::findOrFail($id); // Esto lanzará ModelNotFoundException si no existe

        return response()->json($categoria);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $curso = ModelsCategoria::find($id);
        $curso->update($request->all());
        return $curso;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return ModelsCategoria::destroy($id);

    }
}
