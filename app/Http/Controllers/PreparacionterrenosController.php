<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terreno;
use App\User;
use App\Preparacionterreno;
use Validator;

use App\Http\Requests;

class PreparacionterrenosController extends Controller
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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'terreno_id' => 'required',
            'tecnico_id' => 'required',
        ]);
    }

    public function index()
    {
        $terrenos = Terreno::all();
        return view('preparacionterreno.index',['terrenos' => $terrenos]);
    }
    public function postCreate(Request $request)
    {
        $preterreno_count = Preparacionterreno::where('terreno_id', $request['terreno_id'])->count();
        $terrenos = Terreno::all();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        if($preterreno_count)
        {
            $preterreno = Preparacionterreno::where('terreno_id', $request['terreno_id'])->get();
            return view('preparacionterreno.index',['terreno_id' => $request['terreno_id'], 'terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos]);
        }
        return view('preparacionterreno.index',['terreno_id' => $request['terreno_id'], 'terrenos' => $terrenos, 'tecnicos' => $tecnicos]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $terrenos = Terreno::all();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        return view("preparacionterreno.registrar", ['terrenos' => $terrenos, 'tecnicos' => $tecnicos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $preterreno_count = Preparacionterreno::where('terreno_id', $request['terreno_id'])->count();
        if($preterreno_count)
        {
            Preparacionterreno::where('terreno_id', $request['terreno_id'])
                ->update([
                    'ph' => $request['ph'],
                    'plaga_suelo' => $request['plaga_suelo'],
                    'drenage' => $request['drenage'],
                    'erocion' => $request['erocion'],
                    'maleza_preparacion' => $request['maleza_preparacion'],
                    'comentario_preparacion' => $request['comentario_preparacion'],
                    'tecnico_id' => $request['tecnico_id'],
                    'estado' => 'En progreso',
                ]);
        $preterreno = Preparacionterreno::where('terreno_id', $request['terreno_id'])->get();
        }else{
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            $preterreno = Preparacionterreno::create([
                'ph' => $request['ph'],
                'plaga_suelo' => $request['plaga_suelo'],
                'drenage' => $request['drenage'],
                'erocion' => $request['erocion'],
                'maleza_preparacion' => $request['maleza_preparacion'],
                'comentario_preparacion' => $request['comentario_preparacion'],
                'estado' => 'En progreso',
                'terreno_id' => $request['terreno_id'],
                'tecnico_id' => $request['tecnico_id'],
            ]);
        }
        $mensaje = "Cosecha registrado exitosamente";
        $terrenos = Terreno::all();
        $tecnicos = User::where('tipo', "Tecnico")->get();
        return view('preparacionterreno.index',['terreno_id' => $request['terreno_id'], 'terrenos' => $terrenos, 'preterreno' => $preterreno, 'tecnicos' => $tecnicos]);
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
