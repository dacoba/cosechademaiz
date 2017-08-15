@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Preparacion del Terreno</h2>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Preparacion del Terreno</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/preparacionterrenos') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="ph" class="col-md-4 control-label">PH</label>
                            <div class="col-md-6">
                                <select id="ph" name="ph" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="plaga_suelo" class="col-md-4 control-label">plaga_suelo</label>
                            <div class="col-md-6">
                                <select id="plaga_suelo" name="plaga_suelo" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="drenage" class="col-md-4 control-label">drenage</label>
                            <div class="col-md-6">
                                <select id="drenage" name="drenage" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="erocion" class="col-md-4 control-label">erocion</label>
                            <div class="col-md-6">
                                <select id="erocion" name="erocion" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="maleza_preparacion" class="col-md-4 control-label">maleza_preparacion</label>
                            <div class="col-md-6">
                                <select id="maleza_preparacion" name="maleza_preparacion" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('comentario_preparacion') ? ' has-error' : '' }}">
                            <label for="comentario_preparacion" class="col-md-4 control-label">Comentario</label>

                            <div class="col-md-6">
                                <input id="comentario_preparacion" type="text" class="form-control" name="comentario_preparacion" value="{{ old('comentario_preparacion') }}">

                                @if ($errors->has('comentario_preparacion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comentario_preparacion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('terreno_id') ? ' has-error' : '' }}">
                            <label for="terreno_id" class="col-md-4 control-label">Terreno</label>
                            <div class="col-md-6">
                                <select name="terreno_id" class="form-control">
                                    @foreach ( $terrenos as $terreno )
                                        <option value="{{$terreno['id']}}" @if (old('terreno_id') == $terreno['id']) selected @endif >{{$terreno['area_parcela']}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('terreno_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('terreno_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tecnico_id') ? ' has-error' : '' }}">
                            <label for="tecnico_id" class="col-md-4 control-label">Tipo de Producto</label>
                            <div class="col-md-6">
                                <select name="tecnico_id" class="form-control">
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
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
