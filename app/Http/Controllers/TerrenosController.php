<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Terreno;
use Validator;

use App\Http\Requests;

class TerrenosController extends Controller
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
            'area_parcela' => 'numeric|min:0.01',
            'productor_id' => 'required',
        ]);
    }
    public function index()
    {
//        foreach(timezone_abbreviations_list() as $abbr => $timezone){
//            foreach($timezone as $val){
//                if(isset($val['timezone_id'])){
//                    var_dump($abbr,$val['timezone_id']);
//                }
//            }
//        }
        $terrenos = Terreno::with('productor')->get();
        return view('terreno.terrenolista',['terrenos' => $terrenos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productores = User::where('tipo', "Productor")->get();
        return view("terreno.registrar", ['productores' => $productores, 'area_parcela' => "0.00"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        Terreno::create([
            'area_parcela' => $request['area_parcela'],
            'tipo_suelo' => $request['tipo_suelo'],
            'tipo_relieve' => $request['tipo_relieve'],
            'estado' => 'Cerrado',
            'productor_id' => $request['productor_id'],
        ]);
        $mensaje = "Terreno registrado exitosamente";
        $productores = User::where('tipo', "Productor")->get();
        return view("terreno.registrar", ['productores' => $productores, 'mensaje' => $mensaje , 'area_parcela' => "0.00"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $terreno = Terreno::with('productor')->where('id', $id)->get();
        $terreno = $terreno[0];
        return view("terreno.terrenoshow",['terreno' => $terreno]);
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
