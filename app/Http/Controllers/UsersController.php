<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validatorTecnico(array $data)
    {
        return Validator::make($data, [
            'ci' => 'required|max:10|unique:users',
            'nombre' => 'required|max:255',
            'login' => 'required|max:15|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function validatorProductor(array $data)
    {
        return Validator::make($data, [
            'ci' => 'required|max:10|unique:users',
            'nombre' => 'required|max:255',
        ]);
    }

    public function index()
    {
        $usuarios = User::all();
        return view('user.mostrar',['usuarios' => $usuarios]);
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
    public function createTecnico()
    {
        return view("user.tecnico");
    }
    public function createProductor()
    {
        return view("user.productor");
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

    public function storeTecnico(Request $request)
    {
        $validator = $this->validatorTecnico($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        User::create([
            'ci' => $request['ci'],
            'nombre' => $request['nombre'],
            'apellido' => $request['apellido'],
            'telefono' => $request['telefono'],
            'direccion' => $request['direccion'],
            'tipo' => "Tecnico",
            'login' => $request['login'],
            'password' => bcrypt($request['password']),
        ]);
        $mensaje = "Tecnico registrado exitosamente";
        return view("user.tecnico",['mensaje' => $mensaje]);
    }
    public function storeProductor(Request $request)
    {
        $validator = $this->validatorProductor($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        User::create([
            'ci' => $request['ci'],
            'nombre' => $request['nombre'],
            'apellido' => $request['apellido'],
            'telefono' => $request['telefono'],
            'direccion' => $request['direccion'],
            'tipo' => "Productor",
            'login' => $request['ci'],
            'password' => bcrypt($request['ci']),
        ]);
        $mensaje = "Productor registrado exitosamente";
        return view("user.productor",['mensaje' => $mensaje]);
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
