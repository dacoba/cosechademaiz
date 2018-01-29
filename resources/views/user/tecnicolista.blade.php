@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Cuentas de Tecnico</h2>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div style="text-align: right;" class="hidden-sm-up">

                <a href="{{ url('users/tecnico/create')}}" class="btn btn-primary hidden-xs"><i class="fa fa-plus fa-padding-right"></i>Nuevo Tecnico</a>
                <a href="{{ url('users/tecnico/create')}}" class="btn btn-primary hidden-sm hidden-md hidden-lg"><i class="fa fa-plus"></i></a>
                <div class="input-group search-table">
                    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search...">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Cuentas de Tecnico</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($error))
                        <div class="alert alert-danger">
                            <strong>¡Error! </strong>{{ $error }}
                        </div>
                    @endif
                    @if (isset($success))
                        <div class="alert alert-success">
                            <strong>¡Exitoso! </strong>{{ $success }}
                        </div>
                    @endif
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: right">CI</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th style="text-align: center">Telefono</th>
                            <th>Direccion</th>
                            <th style="text-align: center">Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tecnicos as $tecnico)
                            <tr>
                                <td style="text-align: right">{{$tecnico['ci']}}</td>
                                <td>{{$tecnico['nombre']}}</td>
                                <td>{{$tecnico['apellido']}}</td>
                                <td>{{$tecnico['email']}}</td>
                                <td style="text-align: center">{{$tecnico['telefono']}}</td>
                                <td>{{$tecnico['direccion']}}</td>
                                <td style="text-align: center">
                                    <a href="{{ url('users/tecnico')}}/{{$tecnico['id']}}" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-file-text-o"></i></a>
                                    <a href="{{ url('users/tecnico')}}/{{$tecnico['id']}}/edit" class="btn btn-warning btn-xs"><i class="fa fa-btn fa-pencil"></i></a>
                                    <form action="{{ url('users/tecnico')}}/{{$tecnico['id']}}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE" >
                                        <button class="btn btn-danger btn-xs" type="submit">
                                            <i class="fa fa-btn fa-trash-o"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
