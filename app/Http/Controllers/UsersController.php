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
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function validatorTecnico(array $data)
    {
        return Validator::make($data, [
            'ci' => 'required|max:10|unique:users',
            'nombre' => 'required|max:255',
            'login' => 'required|max:15|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
    protected function validatorTecnicoUpdate(array $data)
    {
        return Validator::make($data, [
            'ci' => 'required|max:10',
            'nombre' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);
    }

    protected function validatorProductor(array $data)
    {
        return Validator::make($data, [
            'ci' => 'required|max:10|unique:users',
            'nombre' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
        ]);
    }

    protected function validatorProductorUpdate(array $data)
    {
        return Validator::make($data, [
            'ci' => 'required|max:10',
            'nombre' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);
    }

    public function index()
    {
        $usuarios = User::all();
        return view('user.mostrar',['usuarios' => $usuarios]);
    }
    public function indexProductor()
    {
        $productors = User::where('tipo', "Productor")->orderBy('apellido', 'asc')->get();
        return view("user.productorlista",['productors' => $productors]);
    }
    public function indexTecnico()
    {
        $tecnicos = User::where('tipo', "Tecnico")->orderBy('apellido', 'asc')->get();
        return view("user.tecnicolista",['tecnicos' => $tecnicos]);
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
            'email' => $request['email'],
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
            'email' => $request['email'],
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
    public function showProductor($id)
    {
        $productor = User::find($id);
        return view("user.productorshow",['productor' => $productor]);
    }

    public function showTecnico($id)
    {
        $tecnico = User::find($id);
        return view("user.tecnicoshow",['tecnico' => $tecnico]);
    }

    public function editProductor($id)
    {
        $productor = User::find($id);
        return view("user.productor",['productor' => $productor]);
    }

    public function editTecnico($id)
    {
        $tecnico = User::find($id);
        return view("user.tecnico",['tecnico' => $tecnico]);
    }

    public function updateProductor(Request $request, $id)
    {
        $validator = $this->validatorProductorUpdate($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        User::where('id', $id)
            ->update([
                'nombre' => $request['nombre'],
                'apellido' => $request['apellido'],
                'telefono' => $request['telefono'],
                'direccion' => $request['direccion'],
                'email' => $request['email'],
            ]);

        $productors = User::where('tipo', "Productor")->orderBy('apellido', 'asc')->get();
        return view("user.productorlista",['productors' => $productors]);
    }

    public function updateTecnico(Request $request, $id)
    {
        $validator = $this->validatorTecnicoUpdate($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        User::where('id', $id)
            ->update([
                'nombre' => $request['nombre'],
                'apellido' => $request['apellido'],
                'telefono' => $request['telefono'],
                'direccion' => $request['direccion'],
                'email' => $request['email'],
            ]);

        $tecnicos = User::where('tipo', "Tecnico")->orderBy('apellido', 'asc')->get();
        return view("user.tecnicolista",['tecnicos' => $tecnicos]);
    }

    public function destroy($id)
    {
        //
    }
}
