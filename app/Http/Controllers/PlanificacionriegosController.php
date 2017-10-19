<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siembra;
use App\Riego;
use App\Planificacionriego;
use DB;

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
            ]);
            $request['riego_id'] = $riego['id'];
        }
        $planificacionriego = Planificacionriego::create([
            'fecha_planificacion' => $request['fecha_planificacion'],
            'estado' => "planificado",
            'riego_id' => $request['riego_id'],
        ]);
        $event_on= "SET GLOBAL event_scheduler =  \"ON\"";
        DB::unprepared($event_on);
        $query = 'CREATE EVENT planificacionriego_'.$planificacionriego['id'].' ON SCHEDULE AT \''.$request['fecha_planificacion'].'\' DO UPDATE planificacionriegos SET estado=\'ejecutado\' WHERE id='.$planificacionriego['id'];
        DB::unprepared($query);
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $siembras = $this->getSiembrasEstate();
        if($riego != [])
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
