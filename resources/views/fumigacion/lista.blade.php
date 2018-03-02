@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Planificacion de Fumigacion</h2>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="hidden-sm-up" align="right">

                <div class="input-group search-table" style="float: none;">
                    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Filtrar Terreno...">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Siembras registradas</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                @if (isset($success))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $success }}
                    </div>
                @endif
                @if (isset($error))
                    <div class="alert alert-danger">
                        <strong>¡Error! </strong>{{ $error }}
                    </div>
                @endif
                <div class="panel-body">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: right">Area Parcela</th>
                            <th>Productor</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($preterrenos as $preterreno)
                            @if(!isset($preterreno['siembra']['fumigacion']['estado']) or ($preterreno['siembra']['fumigacion']['estado'] == "Abierto"))
                                <tr>
                                    <td style="text-align: right">{{$preterreno['terreno']['area_parcela']}} Hec.</td>
                                    <td>{{$preterreno['terreno']['productor']['nombre']}} {{$preterreno['terreno']['productor']['apellido']}}</td>
                                    <td style="text-align: center">{{$preterreno['estado']}}</td>
                                    <td style="text-align: center">
                                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/fumigacions/create') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="siembra_id" value="{{$preterreno['siembra']['id']}}" >
                                            <button type="submit" class="btn btn-primary btn-xs">
                                                <i class="fa fa-btn fa-pencil"></i>
                                            </button>
                                        </form>
    {{--                                    <a href="{{ url('siembras')}}/{{$preterreno['id']}}/edit" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-file-text-o"></i></a>--}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @if ( Auth::user()->tipo == 'Administrador' and isset($terrenos))
                            @foreach ($terrenos as $terreno)
                                <tr>
                                    <td style="text-align: right">{{$terreno['area_parcela']}} Hec.</td>
                                    <td>{{$terreno['productor']['nombre']}} {{$terreno['productor']['apellido']}}</td>
                                    <td style="text-align: center">{{$terreno['estado']}}</td>
                                    <td style="text-align: center">
                                        <a href="{{ url('preparacionterrenos')}}/{{$terreno['id']}}/create" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-file-text-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
