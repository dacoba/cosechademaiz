@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Cuentas de Productor</h2>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> @if (isset($productor)) Actualizar @else Registrar @endif Cuenta de Productor</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($productor))
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/productor') }}/{{ $productor['id'] }}">
                    @else
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/productor') }}">
                    @endif
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('ci') ? ' has-error' : '' }}">
                            <label for="ci" class="col-md-4 control-label">CI</label>

                            <div class="col-md-6">
                                <input id="ci" type="text" class="form-control" name="ci" value="{{ $productor['ci'] or old('ci') }}" @if (isset($productor)) readonly @endif>
                                @if ($errors->has('ci'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ci') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $productor['nombre'] or old('nombre') }}">
                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('apellido') ? ' has-error' : '' }}">
                            <label for="apellido" class="col-md-4 control-label">Apellido</label>

                            <div class="col-md-6">
                                <input id="apellido" type="text" class="form-control" name="apellido" value="{{ $productor['apellido'] or old('apellido') }}">

                                @if ($errors->has('apellido'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apellido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo electronico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $productor['email'] or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                            <label for="telefono" class="col-md-4 control-label">Telefono</label>

                            <div class="col-md-6">
                                <input id="telefono" type="number" class="form-control" name="telefono" value="{{ $productor['telefono'] or old('telefono') }}">

                                @if ($errors->has('telefono'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Direccion</label>

                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control" name="direccion" value="{{ $productor['direccion'] or old('direccion') }}">

                                @if ($errors->has('direccion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                @if (isset($productor))
                                    <input type="hidden" name="_method" value="PUT">
                                    <button type="submit" class="btn pull-right btn-warning margin-left-md">
                                        <i class="fa fa-btn fa-pencil"></i> Modificar usuario
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-btn fa-user"></i> Registrar
                                    </button>
                                @endif
                                <a href="{{ url('users/productor')}}" class="btn btn-danger pull-right button-back"><i class="fa fa-backward fa-padding-right"></i>Atras</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
