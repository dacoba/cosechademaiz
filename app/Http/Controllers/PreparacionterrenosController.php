<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terreno;
use App\User;
use App\Preparacionterreno;
use Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class PreparacionterrenosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'terreno_id' => 'required',
            'tecnico_id' => 'required',
        ]);
    }
    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'ph' => 'required',
            'plaga_suelo' => 'required',
            'drenage' => 'required',
            'erocion' => 'required',
            'maleza_preparacion' => 'required',
            'terreno_id' => 'required',
            'tecnico_id' => 'required',
        ]);
    }
    protected function getTerrenos()
    {
        if (Auth::user()->tipo == 'Tecnico') {
            return Preparacionterreno::with(['terreno', 'terreno.productor'])->where('estado', "Preparacion")->where('tecnico_id', Auth::user()->id)->get();
        }elseif (Auth::user()->tipo == 'Administrador') {
            return Preparacionterreno::with(['terreno', 'terreno.productor'])->where('estado', '!=', "Cerrado")->get();
        }else{
            return Terreno::where('estado', "Cerrado")->get();
        }
    }
    public function index()
    {
        $preterrenos = $this->getTerrenos();
        if (Auth::user()->tipo == 'Administrador') {
            $terrenos = Terreno::with('productor')->where('estado', "Cerrado")->get();
            return view('preparacionterreno.lista',['preterrenos' => $preterrenos, 'terrenos' => $terrenos]);
        } else {
            return view('preparacionterreno.lista',['preterrenos' => $preterrenos]);
        }
    }
//    public function postCreate(Request $request)
//    {
//        $preterreno_count = Preparacionterreno::where('terreno_id', $request['terreno_id'])->count();
//        $terrenos = $this->getTerrenos();
//        $tecnicos = User::where('tipo', "Tecnico")->get();
//        if($preterreno_count)
//        {
//            $preterreno = Preparacionterreno::where('terreno_id', $request['terreno_id'])->get();
//            return view('preparacionterreno.index',['terreno_id' => $request['terreno_id'], 'terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos]);
//        }
//        return view('preparacionterreno.index',['terreno_id' => $request['terreno_id'], 'terrenos' => $terrenos, 'tecnicos' => $tecnicos]);
//    }
//
//    public function create()
//    {
//        $terrenos = Terreno::where('estado', "Cerrado")->get();
//        $tecnicos = User::where('tipo', "Tecnico")->get();
//        return view("preparacionterreno.registrar", ['terrenos' => $terrenos, 'tecnicos' => $tecnicos]);
//    }

    public function create($id)
    {
        $terreno = Terreno::with(['productor'])->where('id', $id)->get()[0];
        $terrenos = $this->getTerrenos();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        return view('preparacionterreno.index',['terreno_id' => $id, 'terrenos' => $terrenos, 'terreno' => $terreno, 'tecnicos' => $tecnicos]);
    }

    public function store(Request $request)
    {
        if (isset($request['preterreno_id'])) {
            $preterreno_aux = Preparacionterreno::find($request['preterreno_id']);
            $estado_aux = $preterreno_aux['estado'];
            if (Auth::user()->tipo == 'Tecnico' and $estado_aux == 'Preparacion') {
                $estado_aux = 'Siembra';
            }
            if (Auth::user()->tipo == 'Tecnico'){
                $validator = $this->validatorUpdate($request->all());
            }else{
                $validator = $this->validator($request->all());
            }
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            Preparacionterreno::where('id', $request['preterreno_id'])
                ->update([
                    'ph' => $request['ph'],
                    'plaga_suelo' => $request['plaga_suelo'],
                    'drenage' => $request['drenage'],
                    'erocion' => $request['erocion'],
                    'maleza_preparacion' => $request['maleza_preparacion'],
                    'comentario_preparacion' => $request['comentario_preparacion'],
                    'estado' => $estado_aux,
                    'tecnico_id' => $request['tecnico_id'],
                ]);
            $preterreno = Preparacionterreno::with(['terreno', 'terreno.productor'])->where('id', $request['preterreno_id'])->get()[0];
            $mensaje = "Preparacion de terreno actualizada exitosamente";
        } else {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            $preterreno = Preparacionterreno::create([
                'ph' => 0,
                'plaga_suelo' => 0,
                'drenage' => 0,
                'erocion' => 0,
                'maleza_preparacion' => 0,
                'comentario_preparacion' => "",
                'estado' => "Preparacion",
                'terreno_id' => $request['terreno_id'],
                'tecnico_id' => $request['tecnico_id'],
            ]);
            Terreno::where('id', $request['terreno_id'])
                ->update([
                    'estado' => "Abierto",
                ]);
            $mensaje = "Cosecha iniciada exitosamente";
        }
        $terrenos = $this->getTerrenos();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        if (Auth::user()->tipo != 'Administrador') {
            return view('preparacionterreno.index', ['terreno_id' => $request['terreno_id'], 'terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos]);
        }else{
            return view('preparacionterreno.index', ['terreno_id' => $request['terreno_id'], 'terrenos' => $terrenos, 'mensaje' => $mensaje, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $preterreno = Preparacionterreno::with(['terreno', 'terreno.productor'])->where('id', $id)->get()[0];
        $terrenos = $this->getTerrenos();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        return view('preparacionterreno.index',['terreno_id' => $preterreno['terreno_id'], 'terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos]);
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
