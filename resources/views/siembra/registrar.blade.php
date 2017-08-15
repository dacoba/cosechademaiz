@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Siembra</h2>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Siembra</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/siembras') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="semilla" class="col-md-4 control-label">Semilla</label>
                            <div class="col-md-6">
                                <select id="semilla" name="semilla" class="form-control">
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
                            <label for="fertilizacion" class="col-md-4 control-label">Fertilizacion</label>
                            <div class="col-md-6">
                                <select id="fertilizacion" name="fertilizacion" class="form-control">
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
                            <label for="densidad_siembra" class="col-md-4 control-label">Densidad de la Siembra</label>
                            <div class="col-md-6">
                                <select id="densidad_siembra" name="densidad_siembra" class="form-control">
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

                        <div class="form-group{{ $errors->has('comentario_siembra') ? ' has-error' : '' }}">
                            <label for="comentario_siembra" class="col-md-4 control-label">Comentario</label>

                            <div class="col-md-6">
                                <input id="comentario_siembra" type="text" class="form-control" name="comentario_siembra" value="{{ old('comentario_siembra') }}">

                                @if ($errors->has('comentario_siembra'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comentario_siembra') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('preparacionterreno_id') ? ' has-error' : '' }}">
                            <label for="preparacionterreno_id" class="col-md-4 control-label">Preparacion del Terreno</label>
                            <div class="col-md-6">
                                <select name="preparacionterreno_id" class="form-control">
                                    @foreach ( $preparacionterrenos as $preparacionterreno )
                                        <option value="{{$preparacionterreno['id']}}" @if (old('preparacionterreno_id') == $preparacionterreno['id']) selected @endif >{{$preparacionterreno['terreno_id']}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('preparacionterreno_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('preparacionterreno_id') }}</strong>
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
