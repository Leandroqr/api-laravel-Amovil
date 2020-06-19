<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Municipio;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Traemos todos los municipios
        $municipios = Municipio::get();
        return response()->json($municipios, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codigo = $request->input('codigo_m');
        $nombre = $request->input('nombre_m');
        $query = Municipio::where('codigo_dane_m', '=', $codigo)->where('nombre_m', '=', $nombre)->exists();

        try {
            // preguntamos si no existe el municipio para insertarlo
            if(!$query) {
                // Creamos un municipio
                $municipio = new Municipio();
                $municipio->codigo_dane_m = $codigo;
                $municipio->nombre_m = $nombre;
                $municipio->save();
                return response()->json([
                    "mensaje" => 'Municipio agregado',
                    "municipio" => $municipio
                ], 200);
                return;
            }
            return response()->json([
                "mensaje" => 'Este municipio ya existe'
            ], 200);
        }
        catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nombre)
    {
        // Consultamos municipio por nombre
        $municipio = Municipio::where('nombre_m','LIKE',"%$nombre%")->get();
        return response()->json($municipio, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Actulizamos el municipio
        $municipio = Municipio::find($id);
        $municipio->nombre_m = $request->nombre_m;
        $municipio->save();
        return $municipio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Eliminamos el municipio
        $municipio = Municipio::find($id);
        $municipio->delete();
        return response()->json([
            "mensaje" => 'Municipio eliminado',
            "municipio" => $municipio
        ], 200);
    }
}
