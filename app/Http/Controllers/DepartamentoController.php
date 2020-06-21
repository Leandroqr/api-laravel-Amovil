<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Traemos todos los departamentos
        $departamentos = Departamento::orderBy('nombre_d', 'asc')->get();
        return response()->json($departamentos, 200);
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
        // Recibimos los datos del front end
        $codigo = $request->input('codigo_dane_d');
        $nombre = $request->input('nombre_d');
        try {
            // consultamos si el codigo y el nombre del departamento ya existen
            $query = Departamento::where('codigo_dane_d', '=', $codigo)->where('nombre_d', '=', $nombre)->exists();
            // la consulta retorna un boolean, luego preguntamos si no existe el departamento para insertarlo
            if(!$query) {
                $departamento = new Departamento();
                $departamento->codigo_dane_d = $codigo;
                $departamento->nombre_d = $nombre;
                $departamento->save();
                return response()->json([
                    "mensaje" => 'Departamento agregado',
                    "departamento" => $departamento
                ], 200);
                return;
            }
            return response()->json([
                "mensaje" => 'Este departamento ya existe'
            ], 200);
        } catch (Exception $e) {
            throw $e;
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
        // Filtramos los departamentos por nombre
        $departamento = Departamento::where('nombre_d','LIKE',"%$nombre%")->get();
        return response()->json($departamento, 200);
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
        // Actulizamos el departamento
        $departamento = Departamento::find($id);
        $departamento->nombre_d = $request->nombre_d;
        $departamento->save();
        return $departamento;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Eliminamos el departamento
        $departamento = Departamento::find($id);
        $departamento->delete();
        return response()->json([
            "mensaje" => 'Departamento eliminado',
            "departamento" => $departamento
        ], 200);
    }
}
