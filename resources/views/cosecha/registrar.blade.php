@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Cosecha</h2>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Cosecha</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/cosechas') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="problemas_produccion" class="col-md-4 control-label">problemas_produccion</label>
                            <div class="col-md-6">
                                <select id="problemas_produccion" name="problemas_produccion" class="form-control">
                                    <option value="1" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '1') selected @endif >1</option>
                                    <option value="2" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '2') selected @endif >2</option>
                                    <option value="3" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '3') selected @endif >3</option>
                                    <option value="4" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '4') selected @endif >4</option>
                                    <option value="5" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '5') selected @endif >5</option>
                                    <option value="6" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '6') selected @endif >6</option>
                                    <option value="7" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '7') selected @endif >7</option>
                                    <option value="8" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '8') selected @endif >8</option>
                                    <option value="9" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '9') selected @endif >9</option>
                                    <option value="10" @if (isset($cosecha['problemas_produccion']) and $cosecha['problemas_produccion'] == '10') selected @endif >10</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="altura_tallo" class="col-md-4 control-label">altura_tallo</label>
                            <div class="col-md-6">
                                <select id="altura_tallo" name="altura_tallo" class="form-control">
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
                            <label for="humedad_terreno" class="col-md-4 control-label">humedad_terreno</label>
                            <div class="col-md-6">
                                <select id="humedad_terreno" name="humedad_terreno" class="form-control">
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
                            <label for="rendimiento_produccion" class="col-md-4 control-label">rendimiento_produccion</label>
                            <div class="col-md-6">
                                <select id="rendimiento_produccion" name="rendimiento_produccion" class="form-control">
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

                        <div class="form-group{{ $errors->has('comentario_cosecha') ? ' has-error' : '' }}">
                            <label for="comentario_cosecha" class="col-md-4 control-label">Comentario</label>

                            <div class="col-md-6">
                                <input id="comentario_cosecha" type="text" class="form-control" name="comentario_cosecha" value="{{ old('comentario_cosecha') }}">

                                @if ($errors->has('comentario_cosecha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comentario_cosecha') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('siembra_id') ? ' has-error' : '' }}">
                            <label for="siembra_id" class="col-md-4 control-label">siembra_id</label>
                            <div class="col-md-6">
                                <select name="siembra_id" class="form-control">
                                    @foreach ( $siembras as $siembra )
                                        <option value="{{$siembra['id']}}" @if (old('siembra_id') == $siembra['id']) selected @endif >{{$siembra['id']}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('siembra_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('siembra_id') }}</strong>
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
