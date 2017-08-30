<?php

namespace App\Http\Controllers;

use App\Fumigacion;
use Illuminate\Http\Request;
use App\Siembra;
use App\Riego;
use App\Planificacionfumigacion;

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
    public function index()
    {
        $siembras = Siembra::all();
        return view('fumigacion.index',['siembras' => $siembras]);
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
            $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->get();
            return view('fumigacion.index',['siembras' => $siembras, 'fumigacion_id' => $fumigacion_id, 'planificacionfumigacions' => $planificacionfumigacions, 'siembra_id' => $request['siembra_id'], 'fumigacion' => $fumigacion]);
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
        Fumigacion::where('id', $request['fumigacion_id'])
            ->update([
                'preventivo_plagas' => $request['preventivo_plagas'],
                'control_rutinario' => $request['control_rutinario'],
                'control_malezas' => $request['control_malezas'],
                'control_insectos' => $request['control_insectos'],
                'control_enfermedades' => $request['control_enfermedades'],
                'comentario_fumigacion' => $request['comentario_fumigacion'],
            ]);
        $siembras = Siembra::all();

        $fumigacion = Fumigacion::find($request['fumigacion_id']);

        $mensaje = "Riego registrado exitosamente";
        $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $request['fumigacion_id'])->get();
        return view('fumigacion.index',['siembras' => $siembras, 'fumigacion_id' => $request['fumigacion_id'], 'planificacionfumigacions' => $planificacionfumigacions, 'siembra_id' => $request['siembra_id'], 'fumigacion' => $fumigacion]);

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
