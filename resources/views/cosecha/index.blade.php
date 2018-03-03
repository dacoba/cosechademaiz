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
                <div class="panel-heading">Fumigaciones Planificadas</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <center>
                        <form class="form-horizontal" role="form" method="POST" id="form_cosecha" action="{{ url('/cosechas') }}/{{ $cosecha['id'] }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="problemas_produccion" class="col-md-5 control-label">Problemas de Produccion</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" min="1" max="100" id="problemas_produccion" name="problemas_produccion" class="form-control text-right" value="{{ $cosecha['problemas_produccion'] }}">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="altura_tallo" class="col-md-5 control-label">Altura del Tallo</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" min="1" max="100" id="altura_tallo" name="altura_tallo" class="form-control text-right" value="{{ $cosecha['altura_tallo'] }}"/>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="humedad_terreno" class="col-md-5 control-label">Humedad del Terreno</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" min="1" max="100" id="humedad_terreno" name="humedad_terreno" class="form-control text-right" value="{{ $cosecha['humedad_terreno'] }}"/>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rendimiento_produccion" class="col-md-5 control-label">Rendimiento de la Produccion</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" min="1" max="100" id="rendimiento_produccion" name="rendimiento_produccion" class="form-control text-right" value="{{ $cosecha['rendimiento_produccion'] }}"/>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('comentario_cosecha') ? ' has-error' : '' }}">
                                <label for="comentario_cosecha" class="col-md-5 control-label">Observaciones</label>

                                <div class="col-md-6">
                                    <textarea id="comentario_cosecha" name="comentario_cosecha" class="form-control" rows="3">{{ $cosecha['comentario_cosecha'] or old('comentario_cosecha') }}</textarea>
                                    @if ($errors->has('comentario_cosecha'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('comentario_cosecha') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT" >
                            <input type="hidden" name="siembra_id" value="{{$cosecha['siembra_id']}}" >
                            <input type="hidden" name="confirm" id="confirm" value="false">
                            <div class="form-group">
                                <div class="col-md-11" style="text-align:right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Guardar
                                    </button>
                                    @if ( Auth::user()->tipo == 'Tecnico')
                                        <input type="button" name="btn" value="Guardar y Confirmar" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-success" />
                                    @endif
                                </div>
                            </div>
                        </form>
                        <style>
                            #confirm_data tr td{
                                text-align:right;
                            }
                        </style>
                        <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Confirmar datos
                                    </div>
                                    <div class="modal-body">
                                        Los siguientes datos seran almacenados para la siguiente etapa.
                                        <table class="table" id="confirm_data">
                                            <tr>
                                                <th>Problemas de Produccion</th>
                                                <td id="m_problemas_produccion"></td>
                                            </tr>
                                            <tr>
                                                <th>Altura del Tallo</th>
                                                <td id="m_altura_tallo"></td>
                                            </tr>
                                            <tr>
                                                <th>Humedad del Terreno</th>
                                                <td id="m_humedad_terreno"></td>
                                            </tr>
                                            <tr>
                                                <th>Rendimiento de la Produccion</th>
                                                <td id="m_rendimiento_produccion"></td>
                                            </tr>
                                            <tr>
                                                <th>Observaciones</th>
                                                <td id="m_comentario_cosecha"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <a href="#" id="submit" class="btn btn-success success">Confirmar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $('#submitBtn').click(function() {
                                $('#m_problemas_produccion').text($('#problemas_produccion').val() + " %");
                                $('#m_altura_tallo').text($('#altura_tallo').val() + " %");
                                $('#m_humedad_terreno').text($('#humedad_terreno').val() + " %");
                                $('#m_rendimiento_produccion').text($('#rendimiento_produccion').val() + " %");
                                $('#m_comentario_cosecha').text($('#comentario_cosecha').val());
                            });

                            $('#submit').click(function(){
                                $('#confirm').val(true);
                                $('#form_cosecha').submit();
                            });
                        </script>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
