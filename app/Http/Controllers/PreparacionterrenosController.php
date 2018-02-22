<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terreno;
use App\User;
use App\Preparacionterreno;
use App\Simulador;
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
            return Preparacionterreno::with(['terreno', 'terreno.productor'])->where('estado', "!=", "Cerrado")->get();
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
            if (Auth::user()->tipo == 'Administrador'){
                Preparacionterreno::where('id', $request['preterreno_id'])
                    ->update([
                        'tecnico_id' => $request['tecnico_id'],
                    ]);
            }
            if (Auth::user()->tipo == 'Tecnico'){
                Preparacionterreno::where('id', $request['preterreno_id'])
                    ->update([
                        'ph' => $request['ph'],
                        'plaga_suelo' => $request['plaga_suelo'],
                        'drenage' => $request['drenage'],
                        'erocion' => $request['erocion'],
                        'maleza_preparacion' => $request['maleza_preparacion'],
                        'comentario_preparacion' => $request['comentario_preparacion'],
                    ]);
            }
            if (isset($request['confirm']) && $request['confirm'] == "true") {
                Preparacionterreno::where('id', $request['preterreno_id'])
                    ->update([
                        'estado' => 'Siembra',
                    ]);
                if (Auth::user()->tipo == 'Tecnico') {
                    Simulador::create([
                        'numero_simulacion' => 1,
                        'problemas' => $request['simulador_problemas'],
                        'altura' => $request['simulador_altura'],
                        'humedad' => $request['simulador_humedad'],
                        'rendimiento' => $request['simulador_rendimiento'],
                        'tipo' => "Preparacion",
                        'preparacionterreno_id' => $request['preterreno_id'],
                    ]);
                }
            }

            $preterreno = Preparacionterreno::with(['terreno', 'terreno.productor'])->where('id', $request['preterreno_id'])->first();
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
        $preterrenos = $this->getTerrenos();
        if (Auth::user()->tipo == 'Administrador') {
            $terrenos = Terreno::with('productor')->where('estado', "Cerrado")->get();
            return view('preparacionterreno.lista',['preterrenos' => $preterrenos, 'terrenos' => $terrenos]);
        } else {
            return view('preparacionterreno.lista',['preterrenos' => $preterrenos]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $preterreno = Preparacionterreno::with(['terreno', 'terreno.productor'])->where('id', $id)->first();
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
