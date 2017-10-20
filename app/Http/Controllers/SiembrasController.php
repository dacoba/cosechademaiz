<?php

namespace App\Http\Controllers;

use App\Siembra;
use Illuminate\Http\Request;
use App\Preparacionterreno;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;

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
    protected function getTerrenos()
    {
        if (Auth::user()->tipo == 'Tecnico') {
            return Preparacionterreno::with(['terreno', 'terreno.productor'])->where('estado', "Siembra")->where('tecnico_id', Auth::user()->id)->get();
        }elseif (Auth::user()->tipo == 'Administrador') {
            return Preparacionterreno::with(['terreno', 'terreno.productor'])->where('estado', "Siembra")->get();
        }else{
            return Terreno::where('estado', "Cerrado")->get();
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'preparacionterreno_id' => 'required',
        ]);
    }

    public function index()
    {
        $preterrenos = $this->getTerrenos();
        return view('siembra.lista',['preterrenos' => $preterrenos]);
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
        if(isset($request['preparacionterreno_id'])) {
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
        }else{
            Siembra::where('id', $request['siembra_id'])
                ->update([
                    'semilla' => $request['semilla'],
                    'fertilizacion' => $request['fertilizacion'],
                    'densidad_siembra' => $request['densidad_siembra'],
                    'comentario_siembra' => $request['comentario_siembra'],
                ]);
        }
        $mensaje = "Siembra registrada exitosamente";
        $preterrenos = $this->getTerrenos();
        return view('siembra.lista',['preterrenos' => $preterrenos]);
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
        $terrenos = $this->getTerrenos();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.tecnico', 'preparacionterreno.terreno', 'preparacionterreno.terreno.productor'])->where('preparacionterreno_id', $id)->get();
        if(count($siembra) <= 0){
            $preterreno = Preparacionterreno::with(['tecnico', 'terreno', 'terreno.productor'])->where('id', $id)->get()[0];
            return view('siembra.index',['terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos]);

        }
        return view('siembra.index',['terrenos' => $terrenos, 'siembra' => $siembra[0], 'tecnicos' => $tecnicos]);
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
