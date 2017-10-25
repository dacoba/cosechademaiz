<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siembra;
use App\Riego;
use App\Planificacionriego;
use App\Preparacionterreno;
use App\Terreno;
use App\Simulador;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class RiegosController extends Controller
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
        return view('riego.lista',['preterrenos' => $preterrenos]);
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
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $riego_count = Riego::where('siembra_id', $request['siembra_id'])->count();
        $siembras = Siembra::all();
        if($riego_count)
        {
            foreach ($riego as $rig){
                $riego_id = $rig['id'];
            }
            $riego = Riego::find($riego_id);
            $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->where('id', $request['siembra_id'])->get()[0];
            $simulador = Simulador::orderBy('numero_simulacion', 'asc')->where('preparacionterreno_id', $siembra['preparacionterreno_id'])->get();

            $planificacionriegos = Planificacionriego::with(['riego', 'riego.siembra', 'riego.siembra.preparacionterreno', 'riego.siembra.preparacionterreno.terreno', 'riego.siembra.preparacionterreno.tecnico'])->where('riego_id', $riego_id)->get();
            if(isset($request['planificacionriego_id'])){
                $planificacionriego_done = Planificacionriego::find($request['planificacionriego_id']);
                return view('riego.index',['siembras' => $siembras, 'riego_id' => $riego_id, 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id'], 'riego' => $riego, 'planificacionriego_done' => $planificacionriego_done, 'siembra' => $siembra, 'simulador' => $simulador]);
            }
            return view('riego.index',['siembras' => $siembras, 'riego_id' => $riego_id, 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id'], 'riego' => $riego, 'siembra' => $siembra, 'simulador' => $simulador]);
        };
        return view('riego.index',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Planificacionriego::where('id', $request['planificacionriego_id'])
            ->update([
                'metodos_riego' => $request['metodos_riego'],
                'comportamiento_lluvia' => $request['comportamiento_lluvia'],
                'problemas_drenaje' => $request['problemas_drenaje'],
                'comentario_riego' => $request['comentario_riego'],
                'estado' => "Registrado",
            ]);
        if (Auth::user()->tipo == 'Tecnico'){
            $simulador = Simulador::where('preparacionterreno_id', $request['preparacionterreno_id'])->orderBy('numero_simulacion', 'desc')->limit(1)->get()[0];
            $sig_num = $simulador['numero_simulacion'] + 1;
            Simulador::create([
                'numero_simulacion' => $sig_num,
                'problemas' => $request['simulador_problemas'],
                'altura' => $request['simulador_altura'],
                'humedad' => $request['simulador_humedad'],
                'rendimiento' => $request['simulador_rendimiento'],
                'tipo' => "Riego",
                'planificacionriego_id' => $request['planificacionriego_id'],
                'preparacionterreno_id' => $request['preparacionterreno_id'],
            ]);
        }
        $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->where('id', $request['siembra_id'])->get()[0];
        $planificacionriego_done = Planificacionriego::find($request['planificacionriego_id']);
        $siembras = Siembra::all();

        $mensaje = "Planificacion de riego registrado exitosamente";
        $planificacionriegos = Planificacionriego::where('riego_id', $planificacionriego_done['riego_id'])->get();
        return view('riego.index',['siembras' => $siembras, 'riego_id' => $planificacionriego_done['riego_id'], 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id'], 'mensaje' => $mensaje, 'siembra' => $siembra]);

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
