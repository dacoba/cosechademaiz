<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siembra;
use App\Riego;
use App\Simulador;
use App\Planificacionriego;
use DB;
use App\Preparacionterreno;
use App\Terreno;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class PlanificacionriegosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function getSiembrasEstate()
    {
        return Siembra::whereHas('preparacionterreno', function($query){
            $query->where('estado', "Planificaciones");
        })->get();
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

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
    }

    public function getSiembras()
    {
        $siembras = $this->getSiembrasEstate();
        return view('planificaionriego.siembra',['siembras' => $siembras]);
    }

    public function postSiembras(Request $request)
    {
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $riego_count = Riego::where('siembra_id', $request['siembra_id'])->count();
        $siembras = $this->getSiembrasEstate();
        if($riego_count)
        {
            foreach ($riego as $rig){
                $riego_id = $rig['id'];
            }
            $planificacionriegos = Planificacionriego::where('riego_id', $riego_id)->get();
            return view('planificaionriego.siembra',['siembras' => $siembras, 'riego_id' => $riego_id, 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id']]);
        };
        return view('planificaionriego.siembra',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
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
        //
    }

    public function addRiego(Request $request)
    {
        if(isset($request['newriego'])){
            $riego = Riego::create([
                'siembra_id' => $request['siembra_id'],
                'estado' => 'Abierto',
            ]);
            $request['riego_id'] = $riego['id'];
        }
        $planificacionriego = Planificacionriego::create([
            'fecha_planificacion' => $request['fecha_planificacion'],
            'estado' => "Planificado",
            'riego_id' => $request['riego_id'],
        ]);
        $riego_aux = Riego::with(['siembra', 'siembra.preparacionterreno'])->where('id', $request['riego_id'])->first();
        $last_simulation = Simulador::where('preparacionterreno_id',$riego_aux['siembra']['preparacionterreno']['id'])->orderBy('id', 'desc')->first();
//                $simulador = Simulador::where('preparacionterreno_id', $request['preparacionterreno_id'])->orderBy('numero_simulacion', 'desc')->limit(1)->get()[0];
        $sig_num = $last_simulation['numero_simulacion'] + 1;
        Simulador::create([
            'numero_simulacion' => $sig_num,
            'problemas' => 0,
            'altura' => 0,
            'humedad' => 0,
            'rendimiento' => 0,
            'tipo' => "Riego",
            'planificacionriego_id' => $planificacionriego['id'],
            'preparacionterreno_id' => $planificacionriego['riego']['siembra']['preparacionterreno']['id'],
        ]);
        $simulador = Simulador::orderBy('numero_simulacion', 'asc')->where('preparacionterreno_id', $planificacionriego['riego']['siembra']['preparacionterreno']['id'])->get();
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $siembras = $this->getSiembrasEstate();
        if($riego != [])
        {
            foreach ($riego as $rig){
                $riego_id = $rig['id'];
            }
            $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->where('id', $request['siembra_id'])->get()[0];
            $planificacionriegos = Planificacionriego::where('riego_id', $riego_id)->get();
            return view('riego.index',['siembras' => $siembras, 'riego_id' => $riego_id, 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id'], 'riego' => $riego, 'siembra' => $siembra, 'simulador' => $simulador]);
        };
        return view('planificaionriego.siembra',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
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
