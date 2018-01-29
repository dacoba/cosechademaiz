@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Terrenos</h2>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> @if (isset($terreno)) Actualizar @else Registrar @endif Cuenta de Productor</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($terreno))
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/terrenos') }}/{{ $terreno['id'] }}">
                    @else
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/terrenos') }}">
                    @endif
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('area_parcela') ? ' has-error' : '' }}">
                            <label for="area_parcela" class="col-md-4 control-label">Area Parcela</label>

                            <div class="col-md-6">
                                <input id="area_parcela" type="text" class="form-control" name="area_parcela" value="{{ $terreno['area_parcela'] or old('area_parcela') }}" @if (isset($terreno)) readonly @endif>
                                @if ($errors->has('area_parcela'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area_parcela') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('productor') ? ' has-error' : '' }}">
                            <label for="productor" class="col-md-4 control-label">Productor</label>

                            <div class="col-md-6">
                                <input id="produuctor" type="text" class="form-control" name="produuctor" value="{{ $terreno['productor']['nombre']}} {{$terreno['productor']['apellido'] or '' }}" @if (isset($terreno)) readonly @endif>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tipo_suelo') ? ' has-error' : '' }}">
                            <label for="tipo_suelo" class="col-md-4 control-label">Tipo de suelo</label>

                            <div class="col-md-6">
                                <select id="tipo_suelo" name="tipo_suelo" class="form-control">
                                    <option value="Limoso" @if($terreno['tipo_suelo'] == "Limoso") selected @endif>Limoso</option>
                                    <option value="Arcilloso" @if($terreno['tipo_suelo'] == "Arcilloso") selected @endif>Arcilloso</option>
                                    <option value="Turba" @if($terreno['tipo_suelo'] == "Turba") selected @endif>Turba</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tipo_relieve') ? ' has-error' : '' }}">
                            <label for="tipo_relieve" class="col-md-4 control-label">Tipo de relieve</label>

                            <div class="col-md-6">
                                <select id="tipo_relieve" name="tipo_relieve" class="form-control">
                                    <option value="Plana" @if($terreno['tipo_relieve'] == "Plana") selected @endif>Plana</option>
                                    <option value="Ladera" @if($terreno['tipo_relieve'] == "Ladera") selected @endif>Ladera</option>
                                    <option value="Ondulada" @if($terreno['tipo_relieve'] == "Ondulada") selected @endif>Ondulada</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
                            <label for="estado" class="col-md-4 control-label">Estado</label>

                            <div class="col-md-6 show-user">
                                {{$terreno['estado'] or "Cerrado"}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="hidden" name="_method" value="PUT">
                                <button type="submit" class="btn pull-right btn-warning margin-left-md">
                                    <i class="fa fa-btn fa-pencil"></i> Modificar terreno
                                </button>
                                <a href="{{ url('terrenos')}}" class="btn btn-danger pull-right button-back"><i class="fa fa-backward fa-padding-right"></i>Atras</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
