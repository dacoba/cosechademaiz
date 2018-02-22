<?php

namespace App\Http\Controllers;

use App\Siembra;
use Illuminate\Http\Request;
use App\Preparacionterreno;
use App\Simulador;
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
        if(isset($request['siembra_id'])) {
            $siembra = Siembra::where('id', $request['siembra_id'])
                ->update([
                    'semilla' => $request['semilla'],
                    'fertilizacion' => $request['fertilizacion'],
                    'distancia_surco' => $request['distancia_surco'],
                    'distancia_planta' => $request['distancia_planta'],
                    'comentario_siembra' => $request['comentario_siembra'],
                ]);
            $siembra_ID = $request['siembra_id'];
        }else{
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            $siembra = Siembra::create([
                'semilla' => $request['semilla'],
                'fertilizacion' => $request['fertilizacion'],
                'distancia_surco' => $request['distancia_surco'],
                'distancia_planta' => $request['distancia_planta'],
                'comentario_siembra' => $request['comentario_siembra'],
                'preparacionterreno_id' => $request['preparacionterreno_id'],
            ]);
            $siembra_ID = $siembra['id'];

        }
        if (isset($request['confirm']) && $request['confirm'] == "true") {
            Preparacionterreno::where('id', $request['preparacionterreno_id'])
                ->update([
                    'estado' => "Planificaciones",
                ]);
            if (Auth::user()->tipo == 'Tecnico'){
                Simulador::create([
                    'numero_simulacion' => 2,
                    'problemas' => $request['simulador_problemas'],
                    'altura' => $request['simulador_altura'],
                    'humedad' => $request['simulador_humedad'],
                    'rendimiento' => $request['simulador_rendimiento'],
                    'tipo' => "Siembra",
                    'siembra_id' => $siembra_ID,
                    'preparacionterreno_id' => $request['preparacionterreno_id'],
                ]);
            }
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
        $preterreno = Preparacionterreno::with(['tecnico', 'terreno', 'terreno.productor'])->where('id', $id)->first();
        $simulador = Simulador::where('preparacionterreno_id', $id)->where('tipo', "Preparacion")->first();
        $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.tecnico', 'preparacionterreno.terreno', 'preparacionterreno.terreno.productor'])->where('preparacionterreno_id', $id)->get();
        if(count($siembra) <= 0){
            return view('siembra.index',['terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos, 'simulador' => $simulador]);
        }
        return view('siembra.index',['terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos, 'simulador' => $simulador, 'siembra' => $siembra[0]]);
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
