<?php

namespace App\Http\Controllers;

use App\Siembra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Jenssegers\Date\Date;
use Barryvdh\DomPDF\Facade as PDF;
use JonnyW\PhantomJs\Client;

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
            'Siembra',
            'Planificaciones',
            'Cosecha',
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

    public function pdfEstados($id)
    {
        $preterreno = Preparacionterreno::find($id);
        $simuladors = Simulador::with(['preparacionterreno', 'siembra', 'planificacionriego', 'planificacionfumigacion'])->where('preparacionterreno_id', $id)->get();
        $pdf = PDF::loadView('reporte.pdf.estados', [
            'preterreno' => $preterreno,
            'simuladors' => $simuladors
        ]);
        return $pdf->stream('download');
    }
    public function pdfGeneral(Request $request, $id)
    {
        $preterreno = Preparacionterreno::find($id);

        /* Riegos y Fumigaciones */

        $tablas['planificaciones'] = $this->getPlanificaciones($id);

        /* Cosecha */

        $tablas['cosecha'] = Cosecha::where('siembra_id', $preterreno['siembra']['id'])->first();

        $veccor_cosecha = [
            "Problemas de produccion" => $tablas['cosecha']['problemas_produccion'],
            "Altura de tallo" => $tablas['cosecha']['altura_tallo'],
            "Humedad del terreno" => $tablas['cosecha']['humedad_terreno'],
            "Remdimiento de produccion" => $tablas['cosecha']['rendimiento_produccion']
        ];

        $files['cosecha'] = $this->generateDiagram($veccor_cosecha, 'cosecha');

        /* Estimacion de Produccion */

        $tablas['estimacion'] = $this->getProduccion($id);

        /* Calidad */

        $tablas['calidad'] = $this->getCalidad($id);

        $veccor_calidad = [
            "Ph" => $tablas['calidad']['calidad']['ph'],
            "Plagas" => $tablas['calidad']['calidad']['plagas'],
            "Drenaje" => $tablas['calidad']['calidad']['drenaje'],
            "Erocion" => $tablas['calidad']['calidad']['erocion'],
            "Malezas" => $tablas['calidad']['calidad']['malezas'],
            "Enfermedades" => $tablas['calidad']['calidad']['enfermedades']
        ];

        $files['calidad'] = $this->generateDiagram($veccor_calidad, 'calidad');

        $pdf = PDF::loadView('reporte.pdf.general', [
            'preterreno' => $preterreno,
            'tablas' => $tablas,
            'files' => $files,
        ]);

        return $pdf->stream('download');
    }


    public function pdfGeneral2($id)
    {

        $data_base = [];
        for($i = 0; $i < 10; $i++){
            $datosfor['label'] = "Label: ".$i;
            $datosfor['value'] = $i*10;
            $data_base['values'][] = $datosfor;
        }

        $client = Client::getInstance();
        $client->isLazy();
        //$client->getEngine()->setPath('bin\phantomjs.exe');
        $client->getEngine()->setPath('/app/bin/phantomjs');
        $client->getEngine()->addOption('--load-images=true');
        $client->getEngine()->addOption('--ignore-ssl-errors=true');

        $request  = $client->getMessageFactory()->createCaptureRequest();
        $response = $client->getMessageFactory()->createResponse();

        $data = array(
            'data' => serialize($data_base)
        );

        $request->setMethod('GET');
        $request->setUrl('https://www.google.com');
//        $request->setRequestData($data);

        $request->setBodyStyles(['backgroundColor' => '#ffffff']);
//        $file = storage_path('sample.jpg');
        $file = 'img/testo.jpg';
        $request->setOutputFile($file);

        $client->send($request, $response);

        if($response->getStatus() === 200) {
//            echo $response->getContent();
            echo '<img src="../../img/testo.jpg">';
        }
//       $request = $client->getMessageFactory()->createCaptureRequest(url('/discreteBarChart.html'), 'GET');
    }

    public function showTesto()
    {
        echo base_path();
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

            $planificaciones['lista'] = $this->getPlanificaciones($id);
        }
        if(Cosecha::where('siembra_id', $preterreno['siembra']['id'])->count()){
            $cosecha['exist'] = True;
            $cosecha['cosecha'] = Cosecha::where('siembra_id', $preterreno['siembra']['id'])->first();

            $estimacion = $this->getProduccion($id);
            $estimacion['exist'] = True;
            $estimacion['siembra'] = Siembra::where('id', $preterreno['siembra']['id'])->first();

            $calidad = $this->getCalidad($id);
            $calidad['exist'] = True;
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

    protected function getPlanificaciones($id)
    {
        $preterreno = Preparacionterreno::find($id);
        $first = Planificacionriego::where('riego_id', Riego::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])
            ->select('fecha_planificacion',
                'estado',
                'id',
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
                'id',
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
        return $second;
    }

    protected function getProduccion($id)
    {
        $preterreno = Preparacionterreno::find($id);
        $cosecha['cosecha'] = Cosecha::where('siembra_id', $preterreno['siembra']['id'])->first();
        $estimacion['siembra'] = Siembra::where('id', $preterreno['siembra']['id'])->first();

        $estimacion['rendimiento_produccion'] = ceil($cosecha['cosecha']['rendimiento_produccion']/25)-1;
        $estimacion['plantas_por_hectarea'] = (10000/($estimacion['siembra']['distancia_surco'] * $estimacion['siembra']['distancia_surco']))*10000;
        $produccion_maiz = $estimacion['rendimiento_produccion'] * $estimacion['plantas_por_hectarea'] * 0.375 * 0.001;

        $estimacion['rendimiento'] = $cosecha['cosecha']['rendimiento_produccion'];
        $estimacion['produccion_por_hectaria'] = round($produccion_maiz,1);
        $estimacion['produccion_total'] = number_format(round($produccion_maiz,1) * $estimacion['siembra']['preparacionterreno']['terreno']['area_parcela'], 0, '.', ',');

        return $estimacion;
    }

    protected function getCalidad($id)
    {
        $preterreno = Preparacionterreno::find($id);
        $cosecha['cosecha'] = Cosecha::where('siembra_id', $preterreno['siembra']['id'])->first();
        $estimacion['siembra'] = Siembra::where('id', $preterreno['siembra']['id'])->first();
        $planificaciones['planificacionriego'] = Planificacionriego::where('riego_id', Riego::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])->get();
        $planificaciones['planificacionfumigacion'] = Planificacionfumigacion::where('fumigacion_id', Fumigacion::where('siembra_id', $preterreno['siembra']['id'])->first()['id'])->get();

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
        $media = array_sum($calidad['calidad']) / count($calidad['calidad']);
        $aux_varianza = [];
        foreach ($calidad['calidad']as $valor){
            $aux_varianza[] = pow(($valor - $media), 2);
        }
        $varianza = array_sum($aux_varianza) / count($aux_varianza);
        $desviacion_estandar = sqrt($varianza);

        $calidad['estadistico']['media'] = round($media, 5);
        $calidad['estadistico']['varianza'] = round($varianza, 5);
        $calidad['estadistico']['desviacion_estandar'] = round($desviacion_estandar, 5);

        return $calidad;
    }

    protected function generateDiagram($veccor_cosecha, $tipo)
    {
        if($tipo == 'cosecha')
        {
            $url = 'https://diagram.herokuapp.com/simpleBarChart.php';
        }
        elseif ($tipo == 'calidad')
        {
            $url = 'https://diagram.herokuapp.com/calidadBarChart.php';
        }
        else
        {
            $url='';
        }

        $data_base = [];
        foreach ($veccor_cosecha as $item_key => $item_value)
        {
            $datosfor['label'] = $item_key;
            $datosfor['value'] = $item_value;
            $data_base['values'][] = $datosfor;
        }

        $client = Client::getInstance();
        $client->isLazy();
//        $client->getEngine()->setPath(base_path().'/bin/phantomjs.exe');
        $client->getEngine()->setPath('/app/bin/phantomjs');
        $client->getEngine()->addOption('--load-images=true');
        $client->getEngine()->addOption('--ignore-ssl-errors=true');

        $request  = $client->getMessageFactory()->createCaptureRequest();
        $response = $client->getMessageFactory()->createResponse();

        $request->setViewportSize(1800, 900);

        $data = array(
            'data' => serialize($data_base)
        );

        $request->setMethod('POST');
        $request->setUrl($url);
        $request->setRequestData($data);

        $request->setBodyStyles(['backgroundColor' => '#ffffff']);
        $file = 'img/'.$tipo.'.jpg';
        $request->setOutputFile($file);

        $request->setDelay(2);

        $client->send($request, $response);

        return $file;
    }
}
