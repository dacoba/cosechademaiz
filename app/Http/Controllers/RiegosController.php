<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siembra;
use App\Riego;
use App\Planificacionriego;
use App\Preparacionterreno;
use App\Terreno;
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
            $planificacionriegos = Planificacionriego::with(['riego', 'riego.siembra', 'riego.siembra.preparacionterreno', 'riego.siembra.preparacionterreno.terreno', 'riego.siembra.preparacionterreno.tecnico'])->where('riego_id', $riego_id)->get();
            if(isset($request['planificacionriego_id'])){
                $planificacionriego_done = Planificacionriego::find($request['planificacionriego_id']);
                return view('riego.index',['siembras' => $siembras, 'riego_id' => $riego_id, 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id'], 'riego' => $riego, 'planificacionriego_done' => $planificacionriego_done, 'siembra' => $siembra]);
            }
            return view('riego.index',['siembras' => $siembras, 'riego_id' => $riego_id, 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id'], 'riego' => $riego, 'siembra' => $siembra]);
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
            ]);
        $planificacionriego_done = Planificacionriego::find($request['planificacionriego_id']);
        $siembras = Siembra::all();

        $mensaje = "Planificacion de riego registrado exitosamente";
        $planificacionriegos = Planificacionriego::where('riego_id', $planificacionriego_done['riego_id'])->get();
        return view('riego.index',['siembras' => $siembras, 'riego_id' => $planificacionriego_done['riego_id'], 'planificacionriegos' => $planificacionriegos, 'siembra_id' => $request['siembra_id'], 'mensaje' => $mensaje]);

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
