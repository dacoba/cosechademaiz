<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cosecha;
use App\Siembra;
use App\Riego;
use App\Planificacionriego;
use App\Fumigacion;
use App\Planificacionfumigacion;

use App\Http\Requests;

class CosechasController extends Controller
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
        return view('cosecha.index',['siembras' => $siembras]);
    }
    public function getreporteSiembra()
    {
        $siembras = Siembra::all();
        return view('reporte.siembras',['siembras' => $siembras]);
    }
    public function postreporteSiembra(Request $request)
    {
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $riego_count = Riego::where('siembra_id', $request['siembra_id'])->count();
        $fumigacion = Fumigacion::where('siembra_id', $request['siembra_id'])->get();
        $fumigacion_count = Fumigacion::where('siembra_id', $request['siembra_id'])->count();
        $siembras = Siembra::all();
        $siembra = Siembra::find($request['siembra_id']);
        $cosecha = [];
        $cosecha = Cosecha::where('siembra_id', $request['siembra_id'])->get();
        if($riego_count and $fumigacion_count)
        {
            $band = True;
            foreach ($riego as $rig){
                $riego_id = $rig['id'];
            }
            $planificacionriegos = Planificacionriego::where('riego_id', $riego_id)->count();
            $riego_lista = Planificacionriego::where('riego_id', $riego_id)->get();
            $planificacionriegosend = Planificacionriego::where([
                ['riego_id', '=', $riego_id],
                ['estado', '=', 'ejecutado'],
            ])->count();
            $riego = 100 / $planificacionriegos * $planificacionriegosend;
            if(is_float($riego))
            {
                $riego = round($riego, 2);
            }
            $planificacionriegonext = False;
            if($riego != 100)
            {
                $planificacionriegonext = Planificacionriego::where([
                    ['riego_id', '=', $riego_id],
                    ['estado', '=', 'planificado'],
                ])->select('fecha_planificacion')->orderBy('fecha_planificacion', 'desc')->limit(1)->get();
            }
            foreach ($fumigacion as $fum){
                $fumigacion_id = $fum['id'];
            }
            $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->count();
            $fumigacion_lista = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->get();
            $planificacionfumigacionsend = Planificacionfumigacion::where([
                ['fumigacion_id', '=', $fumigacion_id],
                ['estado', '=', 'ejecutado'],
            ])->count();
            $fumigacion = 100 / $planificacionfumigacions * $planificacionfumigacionsend;
            if(is_float($fumigacion))
            {
                $fumigacion = round($fumigacion, 2);
            }
            $planificacionfumigacionnext = False;
            if($fumigacion != 100)
            {
                $planificacionfumigacionnext = Planificacionfumigacion::where([
                    ['fumigacion_id', '=', $fumigacion_id],
                    ['estado', '=', 'planificado'],
                ])->select('fecha_planificacion')->orderBy('fecha_planificacion', 'desc')->limit(1)->get();
            }
            return view('reporte.siembras',['cosecha' => $cosecha, 'siembra' => $siembra, 'siembras' => $siembras, 'siembra_id' => $request['siembra_id'], 'band' => $band, 'riego' => $riego, 'riego_lista' => $riego_lista, 'fumigacion' => $fumigacion, 'fumigacion_lista' => $fumigacion_lista, 'planificacionriegonext' => $planificacionriegonext, 'planificacionfumigacionnext' => $planificacionfumigacionnext]);
        }
        return view('reporte.siembras',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siembras = Siembra::all();
        return view("cosecha.registrar", ['siembras' => $siembras]);
    }

    public function postCreate(Request $request)
    {
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $riego_count = Riego::where('siembra_id', $request['siembra_id'])->count();
        $fumigacion = Fumigacion::where('siembra_id', $request['siembra_id'])->get();
        $fumigacion_count = Fumigacion::where('siembra_id', $request['siembra_id'])->count();
        $siembras = Siembra::all();
        if($riego_count and $fumigacion_count)
        {
            $band = True;
            foreach ($riego as $rig){
                $riego_id = $rig['id'];
            }
            $planificacionriegos = Planificacionriego::where('riego_id', $riego_id)->count();
            $planificacionriegosend = Planificacionriego::where([
                ['riego_id', '=', $riego_id],
                ['estado', '=', 'ejecutado'],
            ])->count();
            if ($planificacionriegos != $planificacionriegosend)
            {
                $band = False;
            }
            foreach ($fumigacion as $fum){
                $fumigacion_id = $fum['id'];
            }
            $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->count();
            $planificacionfumigacionsend = Planificacionfumigacion::where([
                ['fumigacion_id', '=', $fumigacion_id],
                ['estado', '=', 'ejecutado'],
            ])->count();
            if ($planificacionfumigacions != $planificacionfumigacionsend)
            {
                $band = False;
            }
            if($band){
                $cosecha_count = Cosecha::where('siembra_id', $request['siembra_id'])->count();
                if($cosecha_count){
                    $cosecha = Cosecha::where('siembra_id', $request['siembra_id'])->get();
                    return view('cosecha.index',['siembras' => $siembras, 'siembra_id' => $request['siembra_id'], 'band' => $band, 'cosecha' => $cosecha]);
                }
            }
            return view('cosecha.index',['siembras' => $siembras, 'siembra_id' => $request['siembra_id'], 'band' => $band]);
        }
        return view('cosecha.index',['siembras' => $siembras, 'siembra_id' => $request['siembra_id']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cosecha_count = Cosecha::where('siembra_id', $request['siembra_id'])->count();
        if($cosecha_count){

            Cosecha::where('siembra_id', $request['siembra_id'])
                ->update([
                    'problemas_produccion' => $request['problemas_produccion'],
                    'altura_tallo' => $request['altura_tallo'],
                    'humedad_terreno' => $request['humedad_terreno'],
                    'rendimiento_produccion' => $request['rendimiento_produccion'],
                    'comentario_cosecha' => $request['comentario_cosecha'],
                ]);
            $cosecha = Cosecha::where('siembra_id', $request['siembra_id'])->get();
        }else{
            $cosecha = Cosecha::create([
                'problemas_produccion' => $request['problemas_produccion'],
                'altura_tallo' => $request['altura_tallo'],
                'humedad_terreno' => $request['humedad_terreno'],
                'rendimiento_produccion' => $request['rendimiento_produccion'],
                'comentario_cosecha' => $request['comentario_cosecha'],
                'siembra_id' => $request['siembra_id'],
            ]);
        }
        $mensaje = "Cosecha registrado exitosamente";
        $siembras = Siembra::all();
        $band = True;
        return view('cosecha.index',['siembras' => $siembras, 'siembra_id' => $request['siembra_id'], 'band' => $band, 'cosecha' => $cosecha]);
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
