@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Planificacion de Riego</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/planificacionriegos/siembras') }}">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-6 col-md-offset-1">
                    <div class="form-group{{ $errors->has('siembra_id') ? ' has-error' : '' }}">
                        <label for="siembra_id" class="col-md-5 control-label">Siembra</label>
                        <div class="col-md-7">
                            <select name="siembra_id" class="form-control">
                                @foreach ( $siembras as $siembra )
                                    <option value="{{$siembra['id']}}" @if (old('siembra_id') == $siembra['id']) selected @endif >{{$siembra['preparacionterreno']['terreno']['productor']['nombre']}} {{$siembra['preparacionterreno']['terreno']['productor']['apellido']}} - {{$siembra['preparacionterreno']['terreno']['area_parcela']}} Hec.</option>
                                @endforeach
                            </select>
                            @if ($errors->has('siembra_id'))
                                <span class="help-block">
                            <strong>{{ $errors->first('siembra_id') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Cargar Riegos
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Riegos Planificados</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($riegosband))
                        @if (isset($planificacionriegos))
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Fecha</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($planificacionriegos as $id => $planificacionriego)
                                    <tr>
                                        <td style="text-align: center">{{$planificacionriego['fecha_planificacion']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <center>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-btn fa-user"></i> Añadir Planificacion
                                </button>
                            </center>
                        @else
                            <center>
                                Esta siembra aun no cuenta con una planificacion de riegos<br>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-btn fa-user"></i> Iniciar Planificacion
                                </button>
                            </center>
                        @endif

                    @else
                        No se tienen riegos registrados
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog" style="margin-top: 200px">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Planificacion de riego</h4>
            </div>
            <div class="modal-body">
                <p  style="text-align: center;">Fecha del siguiente riego.</p>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/planificacionriegos/addriego') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12" style="text-align: center;">
                                <input type="date" name="fecha_planificacion">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (isset($siembra_idd))
                            <input type="hidden" name="siembra_id" value="{{ $siembra_idd }}" >
                            <input type="hidden" name="newriego" value="True" >
                        @endif
                        @if (isset($siembra_id))
                            <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                        @endif
                        @if (isset($riego_id))
                            <input type="hidden" name="riego_id" value="{{ $riego_id }}" >
                        @endif
                        <div class="form-group">
                            <div class="col-md-12" style="text-align: center;">
                                <div style="text-align: center;">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-btn fa-user"></i>Registar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
