@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Riego</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/riegos/create') }}">
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
                    @if (isset($siembra_id))
                        @if (isset($riego_id))
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Fecha</th>
                                    <th style="text-align: center">Estado</th>
                                    <th style="text-align: center">Opcion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($planificacionriegos as $id => $planificacionriego)
                                    <tr @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['id'] == $planificacionriego['id']) style="background: rgba(74,75,237,0.58)" @endif>
                                        <td style="text-align: center">{{$planificacionriego['fecha_planificacion']}}</td>
                                        <td style="text-align: center">{{$planificacionriego['estado']}}</td>
                                        <td style="text-align: center">
                                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/riegos/create') }}">
                                            {{ csrf_field() }}
                                                <input type="hidden" name="planificacionriego_id" value="{{$planificacionriego['id']}}" >
                                                <input type="hidden" name="siembra_id" value="{{$siembra_id}}" >
                                                <button type="submit" class="btn btn-primary btn-xs" @if ($planificacionriego['estado'] != 'ejecutado') disabled @endif>
                                                    <i class="fa fa-btn fa-pencil"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if (isset($planificacionriego_done))
                                <center>
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/riegos') }}">
                                        {{ csrf_field() }}
    
                                        <div class="form-group">
                                            <label for="metodos_riego" class="col-md-4 control-label">metodos_riego</label>
                                            <div class="col-md-6">
                                                <select id="metodos_riego" name="metodos_riego" class="form-control">
                                                    <option value="1" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '1') selected @endif >1</option>
                                                    <option value="2" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '2') selected @endif >2</option>
                                                    <option value="3" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '3') selected @endif >3</option>
                                                    <option value="4" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '4') selected @endif >4</option>
                                                    <option value="5" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '5') selected @endif >5</option>
                                                    <option value="6" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '6') selected @endif >6</option>
                                                    <option value="7" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '7') selected @endif >7</option>
                                                    <option value="8" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '8') selected @endif >8</option>
                                                    <option value="9" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '9') selected @endif >9</option>
                                                    <option value="10" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '10') selected @endif >10</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="comportamiento_lluvia" class="col-md-4 control-label">comportamiento_lluvia</label>
                                            <div class="col-md-6">
                                                <select id="comportamiento_lluvia" name="comportamiento_lluvia" class="form-control">
                                                    <option value="1" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '1') selected @endif >1</option>
                                                    <option value="2" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '2') selected @endif >2</option>
                                                    <option value="3" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '3') selected @endif >3</option>
                                                    <option value="4" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '4') selected @endif >4</option>
                                                    <option value="5" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '5') selected @endif >5</option>
                                                    <option value="6" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '6') selected @endif >6</option>
                                                    <option value="7" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '7') selected @endif >7</option>
                                                    <option value="8" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '8') selected @endif >8</option>
                                                    <option value="9" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '9') selected @endif >9</option>
                                                    <option value="10" @if (isset($planificacionriego_done['comportamiento_lluvia']) and $planificacionriego_done['comportamiento_lluvia'] == '10') selected @endif >10</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="problemas_drenaje" class="col-md-4 control-label">problemas_drenaje</label>
                                            <div class="col-md-6">
                                                <select id="problemas_drenaje" name="problemas_drenaje" class="form-control">
                                                    <option value="1" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '1') selected @endif >1</option>
                                                    <option value="2" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '2') selected @endif >2</option>
                                                    <option value="3" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '3') selected @endif >3</option>
                                                    <option value="4" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '4') selected @endif >4</option>
                                                    <option value="5" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '5') selected @endif >5</option>
                                                    <option value="6" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '6') selected @endif >6</option>
                                                    <option value="7" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '7') selected @endif >7</option>
                                                    <option value="8" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '8') selected @endif >8</option>
                                                    <option value="9" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '9') selected @endif >9</option>
                                                    <option value="10" @if (isset($planificacionriego_done['problemas_drenaje']) and $planificacionriego_done['problemas_drenaje'] == '10') selected @endif >10</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="form-group{{ $errors->has('comentario_riego') ? ' has-error' : '' }}">
                                            <label for="comentario_riego" class="col-md-4 control-label">Comentario</label>
    
                                            <div class="col-md-6">
                                                <input id="comentario_riego" type="text" class="form-control" name="comentario_riego" value="{{ $planificacionriego_done['comentario_riego'] or old('comentario_riego') }}">
    
                                                @if ($errors->has('comentario_riego'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('comentario_riego') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
    
                                        <input type="hidden" name="planificacionriego_id" value="{{ $planificacionriego_done['id'] }}" >
                                        <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
    
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-user"></i> Registrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </center>
                            @endif
                        @else
                            <center>
                                Esta siembra aun no cuenta con una planificacion de riegos
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
@endsection
