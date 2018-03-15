@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Reporte de Estados</h2>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="hidden-sm-up" align="right">

                <div class="input-group search-table" style="float: none;">
                    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Procesos de Produccion</div>
                <div class="panel-body">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <span class="navbar-brand"><i class="glyphicon glyphicon-search"></i></span>
                            </div>

                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <form class="navbar-form navbar-left" method="POST">
                                    {{ csrf_field() }}
                                    @if ( Auth::user()->tipo != 'Productor')
                                        <div class="form-group">
                                            <select name="productor_id" class="form-control">
                                                <option value="0">Todos los Productores</option>
                                                @foreach ( $productores as $productor )
                                                <option value="{{$productor['id']}}" @if (isset($values['productor_id']) and $values['productor_id'] == $productor['id']) selected @endif >{{$productor['nombre']}} {{$productor['apellido']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if ( Auth::user()->tipo != 'Tecnico')
                                        <div class="form-group">
                                            <select name="tecnico_id" class="form-control">
                                                <option value="0">Todos los Tecnicos</option>
                                                @foreach ( $tecnicos as $tecnico )
                                                    <option value="{{$tecnico['id']}}" @if (isset($values['tecnico_id']) and $values['tecnico_id'] == $tecnico['id']) selected @endif >{{$tecnico['nombre']}} {{$tecnico['apellido']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <select name="terreno_id" class="form-control">
                                            <option class="text-right" value="0">Todos los Terrenos</option>
                                            @foreach ( $terrenos as $terreno )
                                                <option class="text-right" value="{{$terreno['id']}}" @if (isset($values['terreno_id']) and $values['terreno_id'] == $terreno['id']) selected @endif >{{$terreno['area_parcela']}} Hec., {{$terreno['tipo_suelo']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-default">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </nav>
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: center">Codigo</th>
                            <th style="text-align: right">Area Parcela</th>
                            <th>Productor</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($preterrenos as $preterreno)
                            <tr>
                                <td style="text-align: center">{{$preterreno['id']}}</td>
                                <td style="text-align: right">{{$preterreno['terreno']['area_parcela']}} Hec.</td>
                                <td>{{$preterreno['terreno']['productor']['nombre']}} {{$preterreno['terreno']['productor']['apellido']}}</td>
                                <td style="text-align: center">{{$preterreno['estado']}}</td>
                                <td style="text-align: center">
                                    <a href="{{ url('reportes/estados')}}/{{$preterreno['id']}}" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-pencil"></i></a>
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
