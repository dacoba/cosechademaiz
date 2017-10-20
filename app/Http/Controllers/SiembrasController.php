<?php

namespace App\Http\Controllers;

use App\Siembra;
use Illuminate\Http\Request;
use App\Preparacionterreno;
use Validator;

use App\Http\Requests;

class SiembrasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'preparacionterreno_id' => 'required',
        ]);
    }

    public function index()
    {
        $siembras = Siembra::all();
        return view('siembra.mostrar',['siembras' => $siembras]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $preparacionterrenos = Preparacionterreno::where('estado', "Preparacion")->get();
        return view("siembra.registrar", ['preparacionterrenos' => $preparacionterrenos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        Siembra::create([
            'semilla' => $request['semilla'],
            'fertilizacion' => $request['fertilizacion'],
            'densidad_siembra' => $request['densidad_siembra'],
            'comentario_siembra' => $request['comentario_siembra'],
            'preparacionterreno_id' => $request['preparacionterreno_id'],
        ]);
        Preparacionterreno::where('id', $request['preparacionterreno_id'])
        ->update([
            'estado' => "Planificaciones",
        ]);
        $mensaje = "Siembra registrada exitosamente";
        $preparacionterrenos = Preparacionterreno::all();
        return view("siembra.registrar", ['preparacionterrenos' => $preparacionterrenos, 'mensaje' => $mensaje]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
