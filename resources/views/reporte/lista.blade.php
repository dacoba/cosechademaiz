@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Reportes</h2>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="hidden-sm-up" align="right">

                <div class="input-group">
                    <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Filtrar Resultados" style="width: 300px;float: right;">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="button" disabled>
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Procesos de Produccion</div>
                <div class="panel-body">
                    <div class="row">
                    <form class="navbar-form" method="POST" action="{{url('reportes')}}">
                        {{ csrf_field() }}
                        <div class="col-sm-6 p-2">
                            <div class="input-group w-100">
                                <input type="date" class="form-control text-right" name="date_from" value="{{ $date_from or old('date_from')}}" aria-describedby="date_from-addon">
                                <span class="input-group-addon" id="date_from-addon">Fecha de Inicio</span>
                            </div>
                        </div>
                        <div class="col-sm-6 p-2">
                            <div class="input-group w-100">
                                <input type="date" class="form-control text-right" name="date_to" value="{{ $date_to or old('date_to')}}" aria-describedby="date_to-addon">
                                <span class="input-group-addon" id="date_to-addon">Fecha de fin</span>
                            </div>
                        </div>
                        @if ( Auth::user()->tipo != 'Productor')
                            <div class="col-sm-6 p-2">
                                <div class="input-group w-100">
                                    <select name="productor_id" class="form-control" aria-describedby="productor-addon">
                                        <option value="0">Todos los Productores</option>
                                        @foreach ( $productores as $productor )
                                            <option value="{{$productor['id']}}" @if (isset($values['productor']) and $values['productor'] == $productor['id']) selected @endif >{{$productor['nombre']}} {{$productor['apellido']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon" id="productor-addon">Productor</span>
                                </div>
                            </div>
                        @endif
                        @if($terrenos != [])
                            <div class="col-sm-6 p-2">
                                <div class="input-group w-100">
                                    <select name="terreno_id" class="form-control" aria-describedby="terreno-addon">
                                        <option class="text-right" value="0">Todos los Terrenos</option>
                                        @foreach ( $terrenos as $terreno )
                                            <option class="text-right" value="{{$terreno['id']}}" @if (isset($values['terreno']) and $values['terreno'] == $terreno['id']) selected @endif >{{$terreno['area_parcela']}} Hec., {{$terreno['tipo_suelo']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon" id="terreno-addon">Terreno</span>
                                </div>
                            </div>
                        @endif
                        @if ( Auth::user()->tipo != 'Tecnico')
                            <div class="col-sm-6 p-2">
                                <div class="input-group w-100">
                                    <select name="tecnico" class="form-control" aria-describedby="tecnico-addon">
                                        <option value="0">Todos los Tecnicos</option>
                                        @foreach ( $tecnicos as $tecnico )
                                            <option value="{{$tecnico['id']}}" @if (isset($values['tecnico']) and $values['tecnico'] == $tecnico['id']) selected @endif >{{$tecnico['nombre']}} {{$tecnico['apellido']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon" id="tecnico-addon">Tecnico</span>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-6 p-2">
                            <div class="input-group w-100">
                                <select name="estado" class="form-control" aria-describedby="tecnico-addon">
                                    <option value="0">Todos los Estados</option>
                                    @foreach ( $estados as $estado )
                                        <option value="{{$estado}}" @if (isset($values['estado']) and $values['estado'] == $estado) selected @endif >{{$estado}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon" id="tecnico-addon">Estado</span>
                            </div>
                        </div>
                        <div class="col-sm-6 p-2 float-r">
                            <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                        </div>
                    </form>
                    </div>
                    <br>
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th class="text-center">Fecha de Inicio</th>
                            <th>Productor</th>
                            <th class="text-center">Area Parcela</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($preterrenos as $preterreno)
                            <tr>
                                <td class="text-right">{{$preterreno['created_at']->format('d F Y')}}</td>
                                <td>{{$preterreno['terreno']['productor']['nombre']}} {{$preterreno['terreno']['productor']['apellido']}}</td>
                                <td class="text-right">{{$preterreno['terreno']['area_parcela']}} Hec.</td>
                                <td class="text-center">{{$preterreno['estado']}}</td>
                                <td class="text-center">
                                    <a href="{{ url('reportes')}}/{{$preterreno['id']}}" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-pencil"></i></a>
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
