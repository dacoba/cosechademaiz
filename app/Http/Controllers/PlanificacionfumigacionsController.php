<?php

namespace App\Http\Controllers;

use App\Fumigacion;
use App\Planificacionfumigacion;
use Illuminate\Http\Request;
use App\Siembra;
use DB;

use App\Http\Requests;

class PlanificacionfumigacionsController extends Controller
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
    public function getSiembras()
    {
        $siembras = Siembra::all();
        return view('planificaionfumigacion.siembra',['siembras' => $siembras]);
    }

    public function postSiembras(Request $request)
    {
        $fumigacion = Fumigacion::where('siembra_id', $request['siembra_id'])->get();
        $fumigacion_count = Fumigacion::where('siembra_id', $request['siembra_id'])->count();
        $siembras = Siembra::all();
        if($fumigacion_count)
        {
            foreach ($fumigacion as $fum){
                $fumigacion_id = $fum['id'];
            }
            $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->get();
            return view('planificaionfumigacion.siembra',['siembras' => $siembras, 'fumigacion_id' => $fumigacion_id, 'planificacionfumigacions' => $planificacionfumigacions, 'siembra_id' => $request['siembra_id']]);
        };
        return view('planificaionfumigacion.siembra',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
    }
    public function addRiego(Request $request)
    {
        if(isset($request['newriego'])){
            $fumigacion = Fumigacion::create([
                'siembra_id' => $request['siembra_id'],
            ]);
            $request['fumigacion_id'] = $fumigacion['id'];
        }
        $planificacionfumigacion = Planificacionfumigacion::create([
            'fecha_planificacion' => $request['fecha_planificacion'],
            'estado' => "planificado",
            'fumigacion_id' => $request['fumigacion_id'],
        ]);
        $event_on= "SET GLOBAL event_scheduler =  \"ON\"";
        DB::unprepared($event_on);
        $query = 'CREATE EVENT planificacionfumigacion_'.$planificacionfumigacion['id'].' ON SCHEDULE AT \''.$request['fecha_planificacion'].'\' DO UPDATE planificacionfumigacions SET estado=\'ejecutado\' WHERE id='.$planificacionfumigacion['id'];
        DB::unprepared($query);
        $fumigacion = Fumigacion::where('siembra_id', $request['siembra_id'])->get();
        $siembras = Siembra::all();
        if($fumigacion != [])
        {
            foreach ($fumigacion as $fum){
                $fumigacion_id = $fum['id'];
            }
            $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->get();
            return view('planificaionfumigacion.siembra',['siembras' => $siembras, 'fumigacion_id' => $fumigacion_id, 'planificacionfumigacions' => $planificacionfumigacions, 'siembra_id' => $request['siembra_id']]);
        };
        return view('planificaionfumigacion.siembra',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
    }
}
