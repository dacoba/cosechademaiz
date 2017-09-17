@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Cuentas de Productor</h2>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div style="text-align: right;">
                <a href="{{ url('users/productor/create')}}" class="btn btn-primary"><i class="fa fa-plus fa-padding-right"></i>Nuevo Productor</a>
                <div class="input-group search-table">
                    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search...">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Cuentas de Productor</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: right">CI</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th style="text-align: center">Telefono</th>
                            <th>Direccion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($productors as $productor)
                            <tr>
                                <td style="text-align: right">{{$productor['ci']}}</td>
                                <td>{{$productor['nombre']}}</td>
                                <td>{{$productor['apellido']}}</td>
                                <td style="text-align: center">{{$productor['telefono']}}</td>
                                <td>{{$productor['direccion']}}</td>
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
