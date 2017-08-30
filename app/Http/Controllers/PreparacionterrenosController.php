<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terreno;
use App\User;
use App\Preparacionterreno;
use Validator;

use App\Http\Requests;

class PreparacionterrenosController extends Controller
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
            'terreno_id' => 'required',
            'tecnico_id' => 'required',
        ]);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $terrenos = Terreno::all();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        return view("preparacionterreno.registrar", ['terrenos' => $terrenos, 'tecnicos' => $tecnicos]);
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
        Preparacionterreno::create([
            'ph' => $request['ph'],
            'plaga_suelo' => $request['plaga_suelo'],
            'drenage' => $request['drenage'],
            'erocion' => $request['erocion'],
            'maleza_preparacion' => $request['maleza_preparacion'],
            'comentario_preparacion' => $request['comentario_preparacion'],
            'estado' => 'En progreso',
            'terreno_id' => $request['terreno_id'],
            'tecnico_id' => $request['tecnico_id'],
        ]);
        $mensaje = "Terreno registrado exitosamente";
        $terrenos = Terreno::all();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        return view("preparacionterreno.registrar", ['terrenos' => $terrenos, 'tecnicos' => $tecnicos, 'mensaje' => $mensaje]);
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
