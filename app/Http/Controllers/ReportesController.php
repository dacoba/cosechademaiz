<?php

namespace App\Http\Controllers;

use App\Siembra;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Terreno;
use App\Preparacionterreno;
use App\Simulador;
use App\Riego;
use App\Planificacionriego;
use App\Fumigacion;
use App\Planificacionfumigacion;
use App\Cosecha;
use DB;

class ReportesController extends Controller
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
            return Preparacionterreno::with(['siembra', 'siembra.cosecha', 'terreno', 'terreno.productor'])->where('tecnico_id', Auth::user()->id)->orderBy('updated_at', 'asc')->get();
        }elseif (Auth::user()->tipo == 'Productor') {
            return Preparacionterreno::with(['siembra', 'siembra.cosecha', 'terreno', 'terreno.productor'])->whereHas('terreno.productor', function ($query) {
                $query->where('id', Auth::user()->id);
            })->orderBy('updated_at', 'asc')->get();
        }elseif (Auth::user()->tipo == 'Administrador') {
            return Preparacionterreno::with(['siembra', 'siembra.cosecha', 'terreno', 'terreno.productor'])->orderBy('updated_at', 'asc')->get();
        }else{
            return [];
        }
    }
    public function indexEstados()
    {
        $preterrenos = $this->getTerrenos();
        return view('reporte.estados.lista',['preterrenos' => $preterrenos]);
    }
    public function indexSimulacion()
    {
        $preterrenos = $this->getTerrenos();
        return view('reporte.simulacion.lista',['preterrenos' => $preterrenos]);
    }
    public function indexGeneral()
    {
        $preterrenos = $this->getTerrenos();
        return view('reporte.general.lista',['preterrenos' => $preterrenos]);
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
    public function showEstados($id)
    {
        $preterreno = Preparacionterreno::find($id);
        $simuladors = Simulador::with(['preparacionterreno', 'siembra', 'planificacionriego', 'planificacionfumigacion'])->where('preparacionterreno_id', $id)->get();
        return view('reporte.estados.show',['preterreno' => $preterreno, 'simuladors' => $simuladors]);
    }
    public function showSimulacion($id)
    {
        $preterreno = Preparacionterreno::find($id);
        $simuladors = Simulador::with(['preparacionterreno', 'siembra', 'planificacionriego', 'planificacionfumigacion'])->where('preparacionterreno_id', $id)->get();
        return view('reporte.simulacion.show',['preterreno' => $preterreno, 'simuladors' => $simuladors]);
    }
    public function showGeneral($id)
    {
        $preterreno = Preparacionterreno::find($id);
        $planificaciones['exist'] = False;
        $cosecha['exist'] = False;
        $estimacion['exist'] = False;
        $calidad['exist'] = False;
        if (!in_array($preterreno['estado'], array("Preparacion", "Siembra"))) {
            if(Riego::where('siembra_id', $preterreno['siembra']['id'])->count()){
                $planificaciones['exist'] = True;
                $planificaciones['planificacionriego'] = Planificacionriego::where('riego_id', Riego::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])->get();
                $planificaciones['planificacionriegoEnd'] = Planificacionriego::where('riego_id', Riego::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])
                    ->whereIn('estado', array('Ejecutado', 'Registrado'))->get();
                $planificaciones['planificacionriegoPla'] = Planificacionriego::where('riego_id', Riego::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])
                    ->where('estado', 'Planificado')->orderBy('fecha_planificacion', 'asc')->get();
            }
            if(Fumigacion::where('siembra_id', $preterreno['siembra']['id'])->count()){
                $planificaciones['exist'] = True;
                $planificaciones['planificacionfumigacion'] = Planificacionfumigacion::where('fumigacion_id', Fumigacion::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])->get();
                $planificaciones['planificacionfumigacionEnd'] = Planificacionfumigacion::where('fumigacion_id', Fumigacion::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])
                    ->whereIn('estado', array('Ejecutado', 'Registrado'))->get();
                $planificaciones['planificacionfumigacionPla'] = Planificacionfumigacion::where('fumigacion_id', Fumigacion::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])
                    ->where('estado', 'Planificado')->orderBy('fecha_planificacion', 'asc')->get();
            }

            $first = Planificacionriego::where('riego_id', Riego::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])
                ->select('fecha_planificacion',
                    'estado',
                    'metodos_riego',
                    'comportamiento_lluvia',
                    'problemas_drenaje',
                    'comentario_riego',
                    DB::raw("'NULL' as preventivo_plagas"),
                    DB::raw("'NULL' as control_malezas"),
                    DB::raw("'NULL' as control_enfermedades"),
                    DB::raw("'NULL' as comentario_fumigacion"),
                    'riego_id',
                    DB::raw("'NULL' as fumigacion_id"),
                    DB::raw("'Riego' as table_name"));

            $second = Planificacionfumigacion::where('fumigacion_id', Fumigacion::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])
                ->select('fecha_planificacion',
                    'estado',
                    DB::raw("'NULL' as metodos_riego"),
                    DB::raw("'NULL' as comportamiento_lluvia"),
                    DB::raw("'NULL' as problemas_drenaje"),
                    DB::raw("'NULL' as comentario_riego"),
                    'preventivo_plagas',
                    'control_malezas',
                    'control_enfermedades',
                    'comentario_fumigacion',
                    DB::raw("'NULL' as riego_id"),
                    'fumigacion_id',
                    DB::raw("'Fumigacion' as table_name"))
                ->union($first)
                ->orderBy('fecha_planificacion', 'asc')
                ->get();
            $planificaciones['lista'] = $second;
        }
        if(Cosecha::where('siembra_id', $preterreno['siembra']['id'])->count()){
            $cosecha['exist'] = True;
            $cosecha['cosecha'] = Cosecha::where('siembra_id', $preterreno['siembra']['id'])->first();

            $estimacion['exist'] = True;
            $estimacion['siembra'] = Siembra::where('id', $preterreno['siembra']['id'])->first();

            $calidad['exist'] = True;
            $aux_ph = ((7 - $estimacion['siembra']['preparacionterreno']['ph']) * $estimacion['siembra']['fertilizacion']) + $estimacion['siembra']['preparacionterreno']['ph'];
            $aux_plagas = ($estimacion['siembra']['preparacionterreno']['plaga_suelo'] + $planificaciones['planificacionfumigacion']->sum('preventivo_plagas')) / ($planificaciones['planificacionfumigacion']->count() + 1);
            $aux_drenaje = ($planificaciones['planificacionriego']->sum('problemas_drenaje') + $planificaciones['planificacionriego']->sum('comportamiento_lluvia') + $estimacion['siembra']['preparacionterreno']['drenage']) / ((2 * $planificaciones['planificacionriego']->count()) + 1);
            $aux_malezas = ($estimacion['siembra']['preparacionterreno']['maleza_preparacion'] + $planificaciones['planificacionfumigacion']->sum('control_malezas')) / ($planificaciones['planificacionfumigacion']->count() + 1);
            $aux_enfermeades = $planificaciones['planificacionfumigacion']->sum('control_enfermedades') / $planificaciones['planificacionfumigacion']->count();
            $calidad['calidad']['ph'] = 10 - (abs($aux_ph - 7) / 0.7);
            $calidad['calidad']['plagas'] =  10 - ($aux_plagas / 10);
            $calidad['calidad']['drenaje'] =  $aux_drenaje / 10;
            $calidad['calidad']['erocion'] = $estimacion['siembra']['preparacionterreno']['erocion'] / 10;
            $calidad['calidad']['malezas'] = 10 - ($aux_malezas / 10);
            $calidad['calidad']['enfermedades'] = $aux_enfermeades / 10;
            $calidad['estadistico']['media'] = array_sum($calidad['calidad']) / count($calidad['calidad']);
            $aux_varianza = [];
            foreach ($calidad['calidad']as $valor){
                $aux_varianza[] = pow(($valor - $calidad['estadistico']['media']), 2);
            }
            $calidad['estadistico']['varianza'] = array_sum($aux_varianza) / count($aux_varianza);
            $calidad['estadistico']['desviacion_estandar'] = sqrt($calidad['estadistico']['varianza']);
        }
        return view('reporte.general.show',['preterreno' => $preterreno, 'planificaciones' => $planificaciones, 'cosecha' => $cosecha, 'estimacion' => $estimacion, 'calidad' => $calidad]);
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
