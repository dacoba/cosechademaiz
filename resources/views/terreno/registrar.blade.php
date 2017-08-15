@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Terreno</h2>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Terreno</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/terrenos') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('area_parcela') ? ' has-error' : '' }}">
                            <label for="area_parcela" class="col-md-4 control-label">Area Parcela</label>

                            <div class="col-md-6">
                                <input id="area_parcela" type="number" step="0.01" class="form-control" name="area_parcela" value="{{ $area_parcela or old("area_parcela") }}" style="text-align:right">

                                @if ($errors->has('area_parcela'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area_parcela') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_suelo" class="col-md-4 control-label">Tipo de suelo</label>
                            <div class="col-md-6">
                                <select id="tipo_suelo" name="tipo_suelo" class="form-control">
                                    <option value="Limoso">Limoso</option>
                                    <option value="Arcilloso">Arcilloso</option>
                                    <option value="Turba">Turba</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_relieve" class="col-md-4 control-label">Tipo de relieve</label>
                            <div class="col-md-6">
                                <select id="tipo_relieve" name="tipo_relieve" class="form-control">
                                    <option value="Plana">Plana</option>
                                    <option value="Ladera">Ladera</option>
                                    <option value="Ondulada">Ondulada</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('productor_id') ? ' has-error' : '' }}">
                            <label for="productor_id" class="col-md-4 control-label">Productor</label>
                            <div class="col-md-6">
                                <select name="productor_id" class="form-control">
                                    @foreach ( $productores as $productor )
                                        <option value="{{$productor['id']}}" @if (old('productor_id') == $productor['id']) selected @endif >{{$productor['nombre']}} {{$productor['apellido']}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('productor_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('productor_id') }}</strong>
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
