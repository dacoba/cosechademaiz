<?php

namespace App\Http\Controllers;

use App\Siembra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Jenssegers\Date\Date;

use App\Http\Requests;

use App\User;
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
            return Preparacionterreno::with(['siembra', 'siembra.cosecha', 'terreno', 'terreno.productor'])->orderBy('created_at', 'asc')->get();
        }else{
            return [];
        }
    }

    protected function getTerrenosDate(Request $request)
    {
        $preparaciones = Preparacionterreno::with(['siembra', 'siembra.cosecha', 'terreno', 'terreno.productor'])
            ->where('created_at','>=', $request->date_from)
            ->where('created_at','<=',$request->date_to.' 23:59:59')
            ->orderBy('created_at', 'asc');
        if($request->tecnico != 0)
        {
            $preparaciones->where('tecnico_id', $request->tecnico);
        }
        if($request->productor_id != 0)
        {
            $preparaciones->whereHas('terreno.productor', function ($query) use($request)
            {
                $query->where('id', $request->productor_id);
            });
        }
        if($request->terreno_id != 0)
        {
            $preparaciones->where('terreno_id', $request->terreno_id);
        }
        if($request->estado != '0')
        {
            $preparaciones->where('estado', $request->estado);
        }
        return $preparaciones->get();
    }

    public function index(Request $request)
    {
        $values = [];
        if(!$request->has('date_from'))
        {
            $date_from = new Carbon('first day of this month');
            $request->date_from = $date_from->format("Y-m-d");
        }
        if(!$request->has('date_to'))
        {
            $date_to = new Carbon('last day of this month');
            $request->date_to = $date_to->format("Y-m-d");
        }

        // Tecnico

        if($request->has('tecnico'))
        {
            $values['tecnico'] = $request->tecnico;
        }
        else
        {
            $request->tecnico = 0;
        }

        // Productor
        $terrenos = [];
        $terrenos_base = Terreno::with('productor');

        if($request->has('productor_id'))
        {
            $values['productor'] = $request->productor_id;
            $terrenos = $terrenos_base->where('productor_id', $request->productor_id)->get();
        }
        else
        {
            $request->productor_id = 0;
        }

        if(Auth::user()->tipo == 'Productor'){
            $terrenos = $terrenos_base->where('productor_id', Auth::user()->id)->get();
        }

        // Terreno

        if($request->has('terreno_id'))
        {
            $values['terreno'] = $request->terreno_id;
        }
        else
        {
            $request->terreno_id = 0;
        }

        // Estado

        if($request->has('estado'))
        {
            $values['estado'] = $request->estado;
            //dd($values);
        }
        else
        {
            $request->estado = 0;
        }

        if (Auth::user()->tipo == 'Tecnico')
        {
            $request->tecnico = Auth::user()->id;
        }
        elseif (Auth::user()->tipo == 'Productor')
        {
            $request->productor_id = Auth::user()->id;
        }

        $estados = [
            'Preparacion',
            'Planificaciones',
            'Siembra',
            'Cerrado',
        ];
        $preterrenos = $this->getTerrenosDate($request);
        $productores = User::where('tipo', "Productor")->get();
        $tecnicos = User::where('tipo', "Tecnico")->get();

        return view('reporte.lista',[
            'values' => $values,
            'estados' => $estados,
            'tecnicos' => $tecnicos,
            'terrenos' => $terrenos,
            'preterrenos' => $preterrenos,
            'productores' => $productores,
            'date_to' => $request->date_to,
            'date_from' => $request->date_from,
        ]);
    }

    public function create()
    {
        //
    }

    public function show($id)
    {
        $preterreno = Preparacionterreno::find($id);
        return view('reporte.show',['preterreno' => $preterreno]);
    }

    public function store(Request $request)
    {
        //
    }

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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
