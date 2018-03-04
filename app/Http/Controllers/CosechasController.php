<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cosecha;
use App\Siembra;
use App\Riego;
use App\Planificacionriego;
use App\Fumigacion;
use App\Planificacionfumigacion;
use Illuminate\Support\Facades\Auth;
use App\Preparacionterreno;
use App\Terreno;
use App\Simulador;

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
    protected function getTerrenos()
    {
        if (Auth::user()->tipo == 'Tecnico') {
            return Preparacionterreno::with(['siembra', 'siembra.cosecha', 'terreno', 'terreno.productor'])->where('estado', "Cosecha")->where('tecnico_id', Auth::user()->id)->get();
        }elseif (Auth::user()->tipo == 'Administrador') {
            return Preparacionterreno::with(['siembra', 'siembra.cosecha', 'terreno', 'terreno.productor'])->where('estado', "Cosecha")->get();
        }else{
            return Terreno::where('estado', "Cerrado")->get();
        }
    }
    public function indexSimulador()
    {
        $siembras = Siembra::all();
        $datos = [];
        $datos = json_encode($datos);
        return view('simulador.index2',['siembras' => $siembras, 'datos' => $datos]);
    }
    public function postSimulador(Request $request)
    {
        $siembras = Siembra::all();
        $siembra = Siembra::with(['preparacionterreno'])->where('id', $request['siembra_id'])->get();
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $fumigacion = Fumigacion::where('siembra_id', $request['siembra_id'])->get();
        foreach ($riego as $rig){
            $riego_id = $rig['id'];
        }
        foreach ($fumigacion as $fum){
            $fumigacion_id = $fum['id'];
        }
        $planificacionriegos = Planificacionriego::where('riego_id', $riego_id)->count();
        $planificacionfumigacions = Planificacionfumigacion::where('fumigacion_id', $fumigacion_id)->count();

        $cosecha = Cosecha::where('siembra_id', $request['siembra_id'])->get();

        $datos = [];

//        var ph = document.getElementById("ph").value;
//        var drenage = document.getElementById("drenage").value;
//        var fertilizacion = document.getElementById("fertilizacion").value;
//        var plaga_suelo = document.getElementById("plaga_suelo").value;
//        var maleza_preparacion = document.getElementById("maleza_preparacion").value;
//        var semilla = document.getElementById("semilla").value;
//        var densidad_siembra = document.getElementById("densidad_siembra").value;

        $datos[0][0] = $siembra[0]['preparacionterreno']['ph'];
        $datos[0][1] = $siembra[0]['preparacionterreno']['drenage'];
        $datos[0][2] = $siembra[0]['fertilizacion'];
        $datos[0][3] = $siembra[0]['preparacionterreno']['plaga_suelo'];
        $datos[0][4] = $siembra[0]['preparacionterreno']['maleza_preparacion'];
        $datos[0][5] = $siembra[0]['semilla'];
        $datos[0][6] = $siembra[0]['densidad_siembra'];

        $datos[1][0] = rand(1,10);
        $datos[1][1] = rand(1,10);
        $datos[1][2] = rand(1,10);
        $datos[1][3] = rand(1,10);
        $datos[1][4] = rand(1,10);
        $datos[1][5] = rand(1,10);
        $datos[1][6] = rand(1,10);

        $datos[2][0] = rand(1,10);
        $datos[2][1] = rand(1,10);
        $datos[2][2] = rand(1,10);
        $datos[2][3] = rand(1,10);
        $datos[2][4] = rand(1,10);
        $datos[2][5] = rand(1,10);
        $datos[2][6] = rand(1,10);

        $datos = json_encode($datos);

        return view('simulador.index2',['siembras' => $siembras, 'datos' => $datos]);
    }
    protected function getSiembrasEstate()
    {
        if (Auth::user()->tipo == 'Administrador') {
            return Siembra::with(['preparacionterreno'])->get();
        }elseif (Auth::user()->tipo == 'Productor'){
            return Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->whereHas('preparacionterreno.terreno', function ($query) {
                $query->where('productor_id', Auth::user()->id);
            })->get();
        }else{
            return Siembra::with(['preparacionterreno'])->whereHas('preparacionterreno', function ($query) {
                $query->where('estado', "Cerrado")->where('tecnico_id', Auth::user()->id);
            })->get();
        }
    }
    public function index()
    {
//        $siembras =  $this->getSiembrasEstate();
//        return view('cosecha.index',['siembras' => $siembras]);
        $preterrenos = $this->getTerrenos();
        return view('cosecha.lista',['preterrenos' => $preterrenos]);

    }
    public function getreporteSiembra()
    {
        $siembras = $this->getSiembrasEstate();
        return view('reporte.siembras',['siembras' => $siembras]);
    }
    public function postreporteSiembra(Request $request)
    {
        $riego = Riego::where('siembra_id', $request['siembra_id'])->get();
        $riego_count = Riego::where('siembra_id', $request['siembra_id'])->count();
        $fumigacion = Fumigacion::where('siembra_id', $request['siembra_id'])->get();
        $fumigacion_count = Fumigacion::where('siembra_id', $request['siembra_id'])->count();
        $siembras =  $this->getSiembrasEstate();
        $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->where('id', $request['siembra_id'])->get()[0];
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
                ['estado', '=', 'Registrado'],
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
                ['estado', '=', 'Registrado'],
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
        $siembras = $this->getSiembrasEstate();
        if($riego_count and $fumigacion_count)
        {
            $band = True;
            foreach ($riego as $rig){
                $riego_id = $rig['id'];
            }
            $planificacionriegos = Planificacionriego::where('riego_id', $riego_id)->count();
            $planificacionriegosend = Planificacionriego::where([
                ['riego_id', '=', $riego_id],
                ['estado', '=', 'Registrado'],
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
                ['estado', '=', 'Registrado'],
            ])->count();
            if ($planificacionfumigacions != $planificacionfumigacionsend)
            {
                $band = False;
            }
            if($band){
                $siembra = Siembra::with(['preparacionterreno', 'preparacionterreno.terreno'])->where('id', $request['siembra_id'])->get()[0];
                $cosecha_count = Cosecha::where('siembra_id', $request['siembra_id'])->count();
                if($cosecha_count){
                    $cosecha = Cosecha::where('siembra_id', $request['siembra_id'])->get();
                    return view('cosecha.index',['siembras' => $siembras, 'siembra_id' => $request['siembra_id'], 'band' => $band, 'cosecha' => $cosecha, 'siembra' => $siembra]);
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
        $cosecha = Cosecha::find($id);
        return view("cosecha.index",['cosecha' => $cosecha]);
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
        $success = "Datos de la cosecha registrados exitosamente";
        Cosecha::where('id', $id)
            ->update([
                'problemas_produccion' => $request['problemas_produccion'],
                'altura_tallo' => $request['altura_tallo'],
                'humedad_terreno' => $request['humedad_terreno'],
                'rendimiento_produccion' => $request['rendimiento_produccion'],
                'comentario_cosecha' => $request['comentario_cosecha'],
            ]);
        if (isset($request['confirm']) && $request['confirm'] == "true") {
            $siembra = Siembra::with('preparacionterreno', 'preparacionterreno.terreno')->where('id', $request['siembra_id'])->first();
            $reparacionterreno_id = $siembra['preparacionterreno']['id'];
            $terreno_id = $siembra['preparacionterreno']['terreno']['id'];
            Preparacionterreno::where('id', $reparacionterreno_id)
                ->update([
                    'estado' => "Cerrado",
                ]);
            if (Auth::user()->tipo == 'Tecnico'){
                $sig_num = Simulador::where('preparacionterreno_id',$reparacionterreno_id)->orderBy('id', 'desc')->first()['numero_simulacion'] + 1;
                Simulador::create([
                    'numero_simulacion' => $sig_num,
                    'problemas' => $request['problemas_produccion'],
                    'altura' => $request['altura_tallo'],
                    'humedad' => $request['humedad_terreno'],
                    'rendimiento' => $request['rendimiento_produccion'],
                    'tipo' => "Cosecha",
                    'siembra_id' => $request['siembra_id'],
                    'preparacionterreno_id' => $reparacionterreno_id,
                ]);
            }
            Terreno::where('id', $terreno_id)
                ->update([
                    'estado' => "Cerrado"
                ]);
            $success = "Datos de la cosecha registrados exitosamente, el proceso ha terminado";
        }
        $preterrenos = $this->getTerrenos();
        return view('cosecha.lista',['preterrenos' => $preterrenos, 'success' => $success]);
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
