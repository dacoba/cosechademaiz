@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Planificacion de Fumigacion</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/planificacionfumigacions/siembras') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6 col-md-offset-1">
                    <div class="form-group{{ $errors->has('siembra_id') ? ' has-error' : '' }}">
                        <label for="siembra_id" class="col-md-5 control-label">Siembra</label>
                        <div class="col-md-7">
                            <select name="siembra_id" class="form-control">
                                @foreach ( $siembras as $siembra )
                                    <option value="{{$siembra['id']}}" @if (isset($siembra_id) and $siembra_id == $siembra['id']) selected @endif >{{$siembra['preparacionterreno']['terreno']['productor']['nombre']}} {{$siembra['preparacionterreno']['terreno']['productor']['apellido']}} - {{$siembra['preparacionterreno']['terreno']['area_parcela']}} Hec.</option>
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
                                <i class="fa fa-btn fa-user"></i> Cargar Fumigaciones
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Fumigaciones Planificadas</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($siembra_id))
                        @if (isset($fumigacion_id))
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Fecha</th>
                                    <th style="text-align: center">Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($planificacionfumigacions as $id => $planificacionfumigacion)
                                    <tr>
                                        <td style="text-align: center">{{$planificacionfumigacion['fecha_planificacion']}}</td>
                                        <td style="text-align: center">{{$planificacionfumigacion['estado']}}</td>
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
                                Esta siembra aun no cuenta con una planificacion de fumigacion<br>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-btn fa-user"></i> Iniciar Planificacion
                                </button>
                            </center>
                        @endif
                    @else
                        <center>
                            Seleccione una siembra
                        </center>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog" style="margin-top: 100px">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Planificacion de riego</h4>
            </div>
            <div class="modal-body">
                <p  style="text-align: center;">Fecha de la siguiente fumigacion.</p>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/planificacionfumigacions/addriego') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group">
                            <div class='col-md-10 col-md-offset-1 input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" name="fecha_planificacion"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (isset($siembra_id))
                            <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                            @if (isset($fumigacion_id))
                                <input type="hidden" name="fumigacion_id" value="{{ $fumigacion_id }}" >
                            @else
                                <input type="hidden" name="newriego" value="True" >
                            @endif
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
