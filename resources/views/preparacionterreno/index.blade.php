@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Preparacion del Terreno</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/preparacionterrenos/create') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6 col-md-offset-1">
                    <div class="form-group{{ $errors->has('terreno_id') ? ' has-error' : '' }}">
                        <label for="terreno_id" class="col-md-5 control-label">Terreno</label>
                        <div class="col-md-7">
                            <select name="terreno_id" class="form-control">
                                @foreach ( $terrenos as $terreno )
                                    <option value="{{$terreno['id']}}" @if (isset($terreno_id) and $terreno_id == $terreno['id']) selected @endif >
                                        {{$terreno['productor']['nombre']}} {{$terreno['productor']['apellido']}} - {{$terreno['area_parcela']}} Hec.
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('terreno_id'))
                                <span class="help-block">
                            <strong>{{ $errors->first('terreno_id') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Cargar Preparacion
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Preparacion del Terreno</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($terreno_id))
                        <center>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/preparacionterrenos') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('tecnico_id') ? ' has-error' : '' }}">
                                    <label for="tecnico_id" class="col-md-4 control-label">Tecnico</label>
                                    <div class="col-md-6">
                                        <select name="tecnico_id" class="form-control" @if ( Auth::user()->tipo == 'Tecnico') disabled @endif>
                                            @foreach ( $tecnicos as $tecnico )
                                                <option value="{{$tecnico['id']}}" @if (old('tecnico_id') == $tecnico['id']) selected @endif >{{$tecnico['nombre']}} {{$tecnico['apellido']}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tecnico_id'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('tecnico_id') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ph" class="col-md-4 control-label">PH</label>
                                    <div class="col-md-6">
                                        <select id="ph" name="ph" class="form-control">
                                            <option value="1" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="plaga_suelo" class="col-md-4 control-label">Plaga Suelo</label>
                                    <div class="col-md-6">
                                        <select id="plaga_suelo" name="plaga_suelo" class="form-control">
                                            <option value="1" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="drenage" class="col-md-4 control-label">Drenage</label>
                                    <div class="col-md-6">
                                        <select id="drenage" name="drenage" class="form-control">
                                            <option value="1" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="erocion" class="col-md-4 control-label">Erocion</label>
                                    <div class="col-md-6">
                                        <select id="erocion" name="erocion" class="form-control">
                                            <option value="1" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['erocion']) and $preterreno[0]['erocion'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="maleza_preparacion" class="col-md-4 control-label">Maleza Preparacion</label>
                                    <div class="col-md-6">
                                        <select id="maleza_preparacion" name="maleza_preparacion" class="form-control">
                                            <option value="1" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('comentario_preparacion') ? ' has-error' : '' }}">
                                    <label for="comentario_preparacion" class="col-md-4 control-label">Comentario</label>

                                    <div class="col-md-6">
                                        <input id="comentario_preparacion" type="text" class="form-control" name="comentario_preparacion" value="{{ $preterreno[0]['comentario_preparacion'] or old('comentario_preparacion') }}">

                                        @if ($errors->has('comentario_preparacion'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('comentario_preparacion') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" name="terreno_id" value="{{ $terreno_id }}" >

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
                            Seleccione un Terreno
                        </center>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
