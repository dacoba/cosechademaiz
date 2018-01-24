<?php

namespace App\Http\Controllers;

use App\Fumigacion;
use Illuminate\Http\Request;
use App\Siembra;
use App\Simulador;
use App\Riego;
use App\Planificacionfumigacion;
use App\Preparacionterreno;
use App\Terreno;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class FumigacionsController extends Controller
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
            return Preparacionterreno::with(['siembra', 'terreno', 'terreno.productor'])->where('estado', "Planificaciones")->where('tecnico_id', Auth::user()->id)->get();
        }elseif (Auth::user()->tipo == 'Administrador') {
            return Preparacionterreno::with(['siembra', 'terreno', 'terreno.productor'])->where('estado', "Planificaciones")->get();
        }else{
            return Terreno::where('estado', "Cerrado")->get();
        }
    }
    public function index()
    {
        $preterrenos = $this->getTerrenos();
        return view('fumigacion.lista',['preterrenos' => $preterrenos]);
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

    public function postCreate(Request $request)
    {
        $fumigacion = Fumigacion::where('siembra_id', $request['siembra_id'])->get();
        $fumigacion_count = Fumigacion::where('siembra_id', $request['siembra_id'])->count();
        $siembras = Siembra::all();
        if($fumigacion_count)
        {
            foreach ($fumigacion as $fum){
                $fumigacion_id = $fum['id'];
            }
            $fumigacion = Fumigacion::find($fumigacion_id);
            $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->where('id', $request['siembra_id'])->get()[0];
            $simulador = Simulador::orderBy('numero_simulacion', 'asc')->where('preparacionterreno_id', $siembra['preparacionterreno_id'])->get();

            $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->get();
            if(isset($request['planificacionfumigacion_id'])){
                $planificacionfumigacion_done = Planificacionfumigacion::find($request['planificacionfumigacion_id']);
                return view('fumigacion.index',['siembras' => $siembras, 'fumigacion_id' => $fumigacion_id, 'planificacionfumigacions' => $planificacionfumigacions, 'siembra_id' => $request['siembra_id'], 'fumigacion' => $fumigacion, 'planificacionfumigacion_done' => $planificacionfumigacion_done, 'siembra' => $siembra, 'simulador' => $simulador]);
            }
            return view('fumigacion.index',['siembras' => $siembras, 'fumigacion_id' => $fumigacion_id, 'planificacionfumigacions' => $planificacionfumigacions, 'siembra_id' => $request['siembra_id'], 'fumigacion' => $fumigacion, 'siembra' => $siembra, 'simulador' => $simulador]);
        };
        return view('fumigacion.index',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Planificacionfumigacion::where('id', $request['planificacionfumigacion_id'])
            ->update([
                'preventivo_plagas' => $request['preventivo_plagas'],
                'control_malezas' => $request['control_malezas'],
                'control_enfermedades' => $request['control_enfermedades'],
                'comentario_fumigacion' => $request['comentario_fumigacion'],
                'estado' => "Registrado",
            ]);

        $planificacionfumigacion2 = Planificacionfumigacion::with(['simulador','fumigacion','fumigacion.siembra','fumigacion.siembra.preparacionterreno'])->where('id', $request['planificacionfumigacion_id'])->first();
        if (Auth::user()->tipo == 'Tecnico'){
            Simulador::where('id', $planificacionfumigacion2['simulador']['id'])
                ->update([
                    'problemas' => $request['simulador_problemas'],
                    'altura' => $request['simulador_altura'],
                    'humedad' => $request['simulador_humedad'],
                    'rendimiento' => $request['simulador_rendimiento'],
                ]);
        }
        $simulador = Simulador::orderBy('numero_simulacion', 'asc')->where('preparacionterreno_id', $planificacionfumigacion2['fumigacion']['siembra']['preparacionterreno']['id'])->get();

        $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->where('id', $request['siembra_id'])->get()[0];
        $planificacionfumigacion_done = Planificacionfumigacion::find($request['planificacionfumigacion_id']);
        $siembras = Siembra::all();

        $mensaje = "Planificacion de fumigacion registrado exitosamente";
        $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $planificacionfumigacion_done['fumigacion_id'])->get();
        return view('fumigacion.index',['siembras' => $siembras, 'fumigacion_id' => $planificacionfumigacion_done['fumigacion_id'], 'planificacionfumigacions' => $planificacionfumigacions, 'siembra_id' => $request['siembra_id'], 'mensaje' => $mensaje, 'siembra' => $siembra, 'simulador' => $simulador]);

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
