@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Terrenos</h2>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> @if (isset($terreno)) Actualizar @else Registrar @endif Cuenta de Productor</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($terreno))
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/terrenos') }}/{{ $terreno['id'] }}">
                    @else
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/terrenos') }}">
                    @endif
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('area_parcela') ? ' has-error' : '' }}">
                            <label for="area_parcela" class="col-md-4 control-label">Area Parcela</label>

                            <div class="col-md-6 show-user">
                                {{ $terreno['area_parcela']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('productor') ? ' has-error' : '' }}">
                            <label for="productor" class="col-md-4 control-label">Productor</label>

                            <div class="col-md-6 show-user">
                                {{$terreno['productor']['nombre']}} {{$terreno['productor']['apellido']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tipo_suelo') ? ' has-error' : '' }}">
                            <label for="tipo_suelo" class="col-md-4 control-label">Tipo de suelo</label>

                            <div class="col-md-6 show-user">
                                {{ $terreno['tipo_suelo']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tipo_relieve') ? ' has-error' : '' }}">
                            <label for="tipo_relieve" class="col-md-4 control-label">Tipo de relieve</label>

                            <div class="col-md-6 show-user">
                                {{ $terreno['tipo_relieve']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
                            <label for="estado" class="col-md-4 control-label">Estado</label>

                            <div class="col-md-6 show-user">
                                {{$preterreno['estado']}}
                            </div>
                        </div>
                        @if ( Auth::user()->tipo == 'Productor')
                            @if (isset($preterreno))
                                <center><h2>Preprapracion del terreno</h2></center>

                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td><b>PH</b></td>
                                        <td>{{$preterreno['ph']}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Plaga Suelo</b></td>
                                        <td>{{$preterreno['plaga_suelo']}} %</td>
                                    </tr>
                                    <tr>
                                        <td><b>Drenaje</b></td>
                                        <td>{{$preterreno['drenaje']}} %</td>
                                    </tr>
                                    <tr>
                                        <td><b>Erocion</b></td>
                                        <td>{{$preterreno['erocion']}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Maleza Preparacion</b></td>
                                        <td>{{$preterreno['maleza_preparacion']}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endif
                        @endif
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <a href="{{ url('terrenos')}}" class="btn btn-danger pull-right button-back-alone"><i class="fa fa-backward fa-padding-right"></i>Atras</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
