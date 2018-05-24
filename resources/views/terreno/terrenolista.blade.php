@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Terrenos</h2>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div style="text-align: right;" class="hidden-sm-up">

                <a href="{{ url('terrenos/create')}}" class="btn btn-primary hidden-xs" @if ( Auth::user()->tipo != 'Administrador') disabled @endif ><i class="fa fa-plus fa-padding-right"></i>Nuevo Terreno</a>
                <a href="{{ url('terrenos/create')}}" class="btn btn-primary hidden-sm hidden-md hidden-lg" @if ( Auth::user()->tipo != 'Administrador') disabled @endif ><i class="fa fa-plus"></i></a>
                <div class="input-group search-table">
                    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Terrenos Registrados</div>
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
                    <style>
                        .btn-mini-xs{
                            padding: 5px 10px;
                        }
                        .btn-mini-xs-form{
                            float: right;
                            padding-left: 4px;
                        }
                    </style>
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: right">Area Parcela</th>
                            <th>Productor</th>
                            <th>Tipo de suelo</th>
                            <th>Tipo de relieve</th>
                            <th>Estado</th>
                            <th style="text-align: center; width: 115px;">Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($terrenos as $terreno)
                            <tr>
                                <td style="text-align: right">{{$terreno['area_parcela']}} Hec.</td>
                                <td>{{$terreno['productor']['nombre']}} {{$terreno['productor']['apellido']}}</td>
                                <td>{{$terreno['tipo_suelo']}}</td>
                                <td>{{$terreno['tipo_relieve']}}</td>
                                <td style="text-align: center">{{$terreno['estado']}}</td>
                                <td style="text-align: center">
                                    <a href="{{ url('terrenos')}}/{{$terreno['id']}}" class="btn btn-primary btn-xs btn-mini-xs"><i class="fa fa-btn fa-file-text-o"></i></a>
                                    @if ( Auth::user()->tipo == 'Administrador')
                                        <a href="{{ url('terrenos')}}/{{$terreno['id']}}/edit" class="btn btn-warning btn-xs btn-mini-xs"><i class="fa fa-btn fa-pencil"></i></a>
                                        <form action="{{ url('terrenos')}}/{{$terreno['id']}}" method="post" class="btn-mini-xs-form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE" >
                                            <button class="btn btn-danger btn-xs btn-mini-xs" type="submit">
                                                <i class="fa fa-btn fa-trash-o"></i>
                                            </button>
                                        </form>
                                    @endif
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
