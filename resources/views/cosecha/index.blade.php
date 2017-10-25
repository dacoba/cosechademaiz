@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Cosecha</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/cosechas/create') }}">
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
                                <i class="fa fa-btn fa-user"></i> Cargar Siembra
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
                        @if (isset($band))
                            @if ($band)
                                <center>
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/cosechas') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="problemas_produccion" class="col-md-4 control-label">Problemas de Produccion</label>
                                            <div class="col-md-6">
                                                <input type="number" min="1" max="100" id="problemas_produccion" name="problemas_produccion" class="form-control" @if (isset($cosecha[0]['problemas_produccion'])) value="{{ $cosecha[0]['problemas_produccion'] }}" @endif onchange="updateBarchar()"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="altura_tallo" class="col-md-4 control-label">Altura del Tallo</label>
                                            <div class="col-md-6">
                                                <input type="number" min="1" max="100" id="altura_tallo" name="altura_tallo" class="form-control" @if (isset($cosecha[0]['altura_tallo'])) value="{{ $cosecha[0]['altura_tallo'] }}" @endif onchange="updateBarchar()"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="humedad_terreno" class="col-md-4 control-label">Humedad del Terreno</label>
                                            <div class="col-md-6">
                                                <input type="number" min="1" max="100" id="humedad_terreno" name="humedad_terreno" class="form-control" @if (isset($cosecha[0]['humedad_terreno'])) value="{{ $cosecha[0]['humedad_terreno'] }}" @endif onchange="updateBarchar()"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="rendimiento_produccion" class="col-md-4 control-label">Rendimiento de la Produccion</label>
                                            <div class="col-md-6">
                                                <input type="number" min="1" max="100" id="rendimiento_produccion" name="rendimiento_produccion" class="form-control" @if (isset($cosecha[0]['rendimiento_produccion'])) value="{{ $cosecha[0]['rendimiento_produccion'] }}" @endif onchange="updateBarchar()"/>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('comentario_cosecha') ? ' has-error' : '' }}">
                                            <label for="comentario_cosecha" class="col-md-4 control-label">Observaciones</label>

                                            <div class="col-md-6">
                                                <input id="comentario_cosecha" type="text" class="form-control" name="comentario_cosecha" value="{{ $cosecha[0]['comentario_cosecha'] or old('comentario_cosecha') }}">

                                                @if ($errors->has('comentario_cosecha'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('comentario_cosecha') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>

                                        <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                                        @if(isset($siembra))
                                            <input type="hidden" name="preparacionterreno_id" value="{{ $siembra['preparacionterreno_id'] }}" >
                                        @endif
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-user"></i> Register
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </center>
                            @else
                                <center>
                                    Esta siembra aun no ha concluido con sus planificaciones
                                </center>
                            @endif
                        @else
                            <center>
                                Esta siembra aun no cuenta con una planificacion de riego o fumigacion
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
