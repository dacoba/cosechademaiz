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

                            <div class="col-md-6 show-user">
                                {{ $productor['ci']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6 show-user">
                                {{ $productor['nombre']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('apellido') ? ' has-error' : '' }}">
                            <label for="apellido" class="col-md-4 control-label">Apellido</label>

                            <div class="col-md-6 show-user">
                                {{ $productor['apellido']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo electronico</label>

                            <div class="col-md-6 show-user">
                                {{ $productor['email']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                            <label for="telefono" class="col-md-4 control-label">Telefono</label>

                            <div class="col-md-6 show-user">
                                {{ $productor['telefono']}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Direccion</label>

                            <div class="col-md-6 show-user">
                                {{ $productor['direccion']}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <a href="{{ url('users/productor')}}" class="btn btn-danger pull-right button-back-alone"><i class="fa fa-backward fa-padding-right"></i>Atras</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
