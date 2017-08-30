@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Fumigacion</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/fumigacions/create') }}">
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
                                <i class="fa fa-btn fa-user"></i> Cargar Fumigaciones
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
                        @if (isset($fumigacion_id))
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Fecha</th>
                                    <th style="text-align: center">Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($planificacionfumigacions as $id => $planificacionfumigacion)
                                    <tr>
                                        <td style="text-align: center">{{$planificacionfumigacion['fecha_planificacion']}}</td>
                                        <td style="text-align: center">{{$planificacionfumigacion['estado']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <center>
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/fumigacions') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="preventivo_plagas" class="col-md-4 control-label">preventivo_plagas</label>
                                        <div class="col-md-6">
                                            <select id="preventivo_plagas" name="preventivo_plagas" class="form-control">
                                                <option value="1" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '1') selected @endif >1</option>
                                                <option value="2" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '2') selected @endif >2</option>
                                                <option value="3" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '3') selected @endif >3</option>
                                                <option value="4" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '4') selected @endif >4</option>
                                                <option value="5" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '5') selected @endif >5</option>
                                                <option value="6" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '6') selected @endif >6</option>
                                                <option value="7" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '7') selected @endif >7</option>
                                                <option value="8" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '8') selected @endif >8</option>
                                                <option value="9" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '9') selected @endif >9</option>
                                                <option value="10" @if (isset($fumigacion['preventivo_plagas']) and $fumigacion['preventivo_plagas'] == '10') selected @endif >10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="control_rutinario" class="col-md-4 control-label">control_rutinario</label>
                                        <div class="col-md-6">
                                            <select id="control_rutinario" name="control_rutinario" class="form-control">
                                                <option value="1" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '1') selected @endif >1</option>
                                                <option value="2" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '2') selected @endif >2</option>
                                                <option value="3" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '3') selected @endif >3</option>
                                                <option value="4" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '4') selected @endif >4</option>
                                                <option value="5" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '5') selected @endif >5</option>
                                                <option value="6" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '6') selected @endif >6</option>
                                                <option value="7" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '7') selected @endif >7</option>
                                                <option value="8" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '8') selected @endif >8</option>
                                                <option value="9" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '9') selected @endif >9</option>
                                                <option value="10" @if (isset($fumigacion['control_rutinario']) and $fumigacion['control_rutinario'] == '10') selected @endif >10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="control_malezas" class="col-md-4 control-label">control_malezas</label>
                                        <div class="col-md-6">
                                            <select id="control_malezas" name="control_malezas" class="form-control">
                                                <option value="1" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '1') selected @endif >1</option>
                                                <option value="2" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '2') selected @endif >2</option>
                                                <option value="3" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '3') selected @endif >3</option>
                                                <option value="4" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '4') selected @endif >4</option>
                                                <option value="5" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '5') selected @endif >5</option>
                                                <option value="6" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '6') selected @endif >6</option>
                                                <option value="7" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '7') selected @endif >7</option>
                                                <option value="8" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '8') selected @endif >8</option>
                                                <option value="9" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '9') selected @endif >9</option>
                                                <option value="10" @if (isset($fumigacion['control_malezas']) and $fumigacion['control_malezas'] == '10') selected @endif >10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="control_insectos" class="col-md-4 control-label">control_insectos</label>
                                        <div class="col-md-6">
                                            <select id="control_insectos" name="control_insectos" class="form-control">
                                                <option value="1" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '1') selected @endif >1</option>
                                                <option value="2" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '2') selected @endif >2</option>
                                                <option value="3" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '3') selected @endif >3</option>
                                                <option value="4" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '4') selected @endif >4</option>
                                                <option value="5" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '5') selected @endif >5</option>
                                                <option value="6" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '6') selected @endif >6</option>
                                                <option value="7" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '7') selected @endif >7</option>
                                                <option value="8" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '8') selected @endif >8</option>
                                                <option value="9" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '9') selected @endif >9</option>
                                                <option value="10" @if (isset($fumigacion['control_insectos']) and $fumigacion['control_insectos'] == '10') selected @endif >10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="control_enfermedades" class="col-md-4 control-label">control_enfermedades</label>
                                        <div class="col-md-6">
                                            <select id="control_enfermedades" name="control_enfermedades" class="form-control">
                                                <option value="1" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '1') selected @endif >1</option>
                                                <option value="2" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '2') selected @endif >2</option>
                                                <option value="3" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '3') selected @endif >3</option>
                                                <option value="4" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '4') selected @endif >4</option>
                                                <option value="5" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '5') selected @endif >5</option>
                                                <option value="6" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '6') selected @endif >6</option>
                                                <option value="7" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '7') selected @endif >7</option>
                                                <option value="8" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '8') selected @endif >8</option>
                                                <option value="9" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '9') selected @endif >9</option>
                                                <option value="10" @if (isset($fumigacion['control_enfermedades']) and $fumigacion['control_enfermedades'] == '10') selected @endif >10</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('comentario_fumigacion') ? ' has-error' : '' }}">
                                        <label for="comentario_fumigacion" class="col-md-4 control-label">Comentario</label>

                                        <div class="col-md-6">
                                            <input id="comentario_fumigacion" type="text" class="form-control" name="comentario_fumigacion" value="{{ $fumigacion['comentario_fumigacion'] or old('comentario_fumigacion') }}">

                                            @if ($errors->has('comentario_fumigacion'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('comentario_fumigacion') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="fumigacion_id" value="{{ $fumigacion_id }}" >
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
                        @else
                            <center>
                                Esta siembra aun no cuenta con una planificacion de fumigacion
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
