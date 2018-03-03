@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Preparacion del Terreno</h2>
            </div>
        </div>
        {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/preparacionterrenos/create') }}">--}}
            {{--{{ csrf_field() }}--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-6 col-md-offset-1">--}}
                    {{--<div class="form-group{{ $errors->has('terreno_id') ? ' has-error' : '' }}">--}}
                        {{--<label for="terreno_id" class="col-md-5 control-label">Terreno</label>--}}
                        {{--<div class="col-md-7">--}}
                            {{--<select name="terreno_id" class="form-control">--}}
                                {{--@if (count($terrenos) == 0)--}}
                                    {{--<option value="" disabled selected>No hay terrenos disponibles</option>--}}
                                {{--@else--}}
                                    {{--<option value="" disabled selected>Seleccione un Terreno</option>--}}
                                {{--@endif--}}
                                {{--@foreach ( $terrenos as $terreno )--}}
                                    {{--<option value="{{$terreno['id']}}" @if (isset($terreno_id) and $terreno_id == $terreno['id']) selected @endif >--}}
                                        {{--{{$terreno['productor']['nombre']}} {{$terreno['productor']['apellido']}} - {{$terreno['area_parcela']}} Hec.--}}
                                    {{--</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                            {{--@if ($errors->has('terreno_id'))--}}
                                {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('terreno_id') }}</strong>--}}
                        {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-2">--}}
                    {{--<div class="form-group">--}}
                        {{--<div class="col-md-6">--}}
                            {{--<button type="submit" class="btn btn-primary" @if (count($terrenos) == 0) disabled @endif>--}}
                                {{--<i class="fa fa-btn fa-user"></i> Cargar Preparacion--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</form>--}}
        @if ( Auth::user()->tipo == 'Tecnico')
            <div class="col-md-12">
        @else
            <div class="col-md-8 col-md-offset-2">
        @endif
            <div class="panel panel-default">
                <div class="panel-heading">Datos de la Preparacion del Terreno</div>

                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: right">Area Parcela</th>
                            <th>Productor</th>
                            <th>Tecnico</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @if (isset($preterreno))
                                <td style="text-align: right">{{$preterreno['terreno']['area_parcela']}} Hec.</td>
                                <td>{{$preterreno['terreno']['productor']['nombre']}} {{$preterreno['terreno']['productor']['apellido']}}</td>
                                <td>{{$preterreno['tecnico']['nombre']}} {{$preterreno['tecnico']['apellido']}}</td>
                            @else
                                <td style="text-align: right">{{$terreno['area_parcela']}} Hec.</td>
                                <td>{{$terreno['productor']['nombre']}} {{$terreno['productor']['apellido']}}</td>
                                <td>Sin Tecnico Asignado</td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                    @if ( Auth::user()->tipo == 'Tecnico')
                    <div class="row">
                        <div class="col-lg-6 col-md-5">
                    @endif
                    <center>
                        <form class="form-horizontal" role="form" method="POST" id="form_preparacion" action="{{ url('/preparacionterrenos') }}">
                            {{ csrf_field() }}
                            @if (Auth::user()->tipo == 'Administrador')
                                <div class="form-group{{ $errors->has('tecnico_id') ? ' has-error' : '' }}">
                                    <label for="tecnico_id" class="col-md-4 control-label">Tecnico</label>
                                    <div class="col-md-6">
                                        <select name="tecnico_id" class="form-control" @if ( Auth::user()->tipo == 'Tecnico') disabled @endif>
                                            @foreach ( $tecnicos as $tecnico )
                                                <option value="{{$tecnico['id']}}" @if (isset($preterreno['tecnico_id']) and $preterreno['tecnico_id'] == $tecnico['id']) selected @endif >{{$tecnico['nombre']}} {{$tecnico['apellido']}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tecnico_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tecnico_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if (isset($preterreno))
                                <input type="hidden" name="preterreno_id" value="{{ $preterreno['id']  }}" >
                                @if ( Auth::user()->tipo != 'Administrador')
                                    <input type="hidden" name="tecnico_id" value="{{ $preterreno['tecnico_id']  }}" >
                                    <div class="form-group{{ $errors->has('ph') ? ' has-error' : '' }}">
                                        <label for="ph" class="col-md-5 control-label">Acidez / Alcalinidad <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de las caracteristicas del suelo, optima para la prduccion del maiz de 6 a 7 de pPH."></i></label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="number" id="ph" name="ph" step="0.01" min="4.00" max="10.00" class="form-control" value="{{ $preterreno['ph'] or '4.00' }}" style="text-align:right" onchange="updateBarchar()"/>
                                                <span class="input-group-addon">pH</span>
                                            </div>
                                            @if ($errors->has('ph'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ph') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('plaga_suelo') ? ' has-error' : '' }}">
                                        <label for="plaga_suelo" class="col-md-5 control-label">Plaga Suelo <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de existencia de plagas en el terreno, evaluada en porcentage segun la existencia de plagas (Gusano Cogollero, Gusano Tierrero, Chicharrita, Gusano de la Mazorca)."></i></label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="number" min="1" max="50" step="0.01" id="plaga_suelo" name="plaga_suelo" class="form-control" value="{{ $preterreno['plaga_suelo'] or '1' }}" style="text-align:right" onchange="updateBarchar()"/>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                            @if ($errors->has('plaga_suelo'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('plaga_suelo') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('drenage') ? ' has-error' : '' }}">
                                        <label for="drenage" class="col-md-5 control-label">Drenage <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de la permeabilidad (El maiz no soporta el encharcamiento y rapida de secacion)."></i></label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="number" min="1" max="100" step="0.01" id="drenage" name="drenage" class="form-control" value="{{ $preterreno['drenage'] or '1' }}" style="text-align:right" onchange="updateBarchar()"/>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                            @if ($errors->has('drenage'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('drenage') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('erocion') ? ' has-error' : '' }}">
                                        <label for="erocion" class="col-md-5 control-label">Erocion <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Degradacion del suelo (Reduce la fertilidad por que proboca la perdida de minerales y materia organica), evaluacion 10 optima para la produccion, 1 muy mala (Elaborar estrategias de recuperacion del terreno)"></i></label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="number" min="1" max="100" step="0.01" id="erocion" name="erocion" class="form-control" value="{{ $preterreno['erocion'] or '1' }}" style="text-align:right" onchange="updateBarchar()"/>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                            @if ($errors->has('erocion'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('erocion') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('maleza_preparacion') ? ' has-error' : '' }}">
                                        <label for="maleza_preparacion" class="col-md-5 control-label">Maleza Preparacion <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de existencias de malezas malignaas en el terreno, evaluado en porcentage segun la existencia de maleza."></i></label>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="number" min="1" max="75" step="0.01" id="maleza_preparacion" name="maleza_preparacion" class="form-control" value="{{ $preterreno['maleza_preparacion'] or '1' }}" style="text-align:right" onchange="updateBarchar()"/>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                            @if ($errors->has('maleza_preparacion'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('maleza_preparacion') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('comentario_preparacion') ? ' has-error' : '' }}">
                                        <label for="comentario_preparacion" class="col-md-5 control-label">Observaciones</label>
                                        <div class="col-md-7">
                                            <textarea id="comentario_preparacion" name="comentario_preparacion" class="form-control" rows="3">{{ $preterreno['comentario_preparacion'] or old('comentario_preparacion') }}</textarea>
                                            @if ($errors->has('comentario_preparacion'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('comentario_preparacion') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="simulador_problemas" id="simulador_problemas" value="">
                                    <input type="hidden" name="simulador_altura" id="simulador_altura" value="">
                                    <input type="hidden" name="simulador_humedad" id="simulador_humedad" value="">
                                    <input type="hidden" name="simulador_rendimiento" id="simulador_rendimiento" value="">
                                    <input type="hidden" name="confirm" id="confirm" value="false">

                                @endif
                            @endif
                            <input type="hidden" name="terreno_id" value="{{ $terreno_id }}" >
                            <div class="form-group">
                                <div class="col-md-12" style="text-align:right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>
                                        @if ( Auth::user()->tipo == 'Administrador')
                                            @if (isset($preterreno))
                                                Reasignar Tecnico
                                            @else
                                                Asignar Tecnico
                                            @endif
                                        @else
                                            Guardar
                                        @endif
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
                                                <th>Acidez / Alcalinidad</th>
                                                <td id="m_ph"></td>
                                            </tr>
                                            <tr>
                                                <th>Plaga Suelo</th>
                                                <td id="m_plaga_suelo"></td>
                                            </tr>
                                            <tr>
                                                <th>Drenage</th>
                                                <td id="m_drenage"></td>
                                            </tr>
                                            <tr>
                                                <th>Erocion</th>
                                                <td id="m_erocion"></td>
                                            </tr>
                                            <tr>
                                                <th>Maleza Preparacion</th>
                                                <td id="m_maleza_preparacion"></td>
                                            </tr>
                                            <tr>
                                                <th>Observaciones</th>
                                                <td id="m_comentario_preparacion"></td>
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
                                $('#m_ph').text($('#ph').val() + " pH");
                                $('#m_plaga_suelo').text($('#plaga_suelo').val() + " %");
                                $('#m_drenage').text($('#drenage').val() + " %");
                                $('#m_erocion').text($('#erocion').val() + " %");
                                $('#m_maleza_preparacion').text($('#maleza_preparacion').val() + " %");
                                $('#m_comentario_preparacion').text($('#comentario_preparacion').val());
                            });

                            $('#submit').click(function(){
                                $('#confirm').val(true);
                                $('#form_preparacion').submit();
                            });
                        </script>
                    </center>
                    @if ( Auth::user()->tipo == 'Tecnico')
                        </div>
                        <div class="col-md-7 col-lg-6">
                            <style>
                                text {
                                    font: 0.61em sans-serif !important;
                                }
                                svg {
                                    display: block;
                                }
                                html, body, #chart1, svg {
                                    margin: 0px;
                                    padding: 0px;
                                    height: 100%;
                                    width: 100% !important;
                                }
                            </style>
                            <div id="chart1" style="height: 350px; width: 500px">
                                <svg></svg>
                            </div>
                            <script>
                                $(function() {
                                    updateBarchar();
                                })
                                var chartBar;
                                historicalBarChart = [
                                    {
                                        key: "Cumulative Return",
                                        values: [
                                            {
                                                "label" : "Problemas de produccion" ,
                                                "value" : 1
                                            } ,
                                            {
                                                "label" : "Altura de tallo" ,
                                                "value" : 1
                                            } ,
                                            {
                                                "label" : "Humedad del terreno" ,
                                                "value" : 1
                                            } ,
                                            {
                                                "label" : "Remdimiento de produccion" ,
                                                "value" : 1
                                            }
                                        ]
                                    }
                                ];

                                function updateBarchar(){
                                    var ph_validate = document.getElementById("ph").value;
                                    ph_validate = ph_validate < 4 ? 4 : ph_validate;
                                    ph_validate = ph_validate > 10 ? 10 : ph_validate;
                                    var ph = 10 - (Math.abs(ph_validate - 7) / 0.7);

                                    var plaga_suelo_validate = document.getElementById("plaga_suelo").value;
                                    plaga_suelo_validate = plaga_suelo_validate < 0 ? 0 : plaga_suelo_validate;
                                    plaga_suelo_validate = plaga_suelo_validate > 100 ? 100 : plaga_suelo_validate;
                                    var plaga_suelo = 10 - (plaga_suelo_validate / 10);

                                    var drenage_validate = document.getElementById("drenage").value;
                                    drenage_validate = drenage_validate < 0 ? 0 : drenage_validate;
                                    drenage_validate = drenage_validate > 100 ? 100 : drenage_validate;
                                    var drenage = drenage_validate / 10;

                                    var maleza_preparacion_validate = document.getElementById("maleza_preparacion").value;
                                    maleza_preparacion_validate = maleza_preparacion_validate < 0 ? 0 : maleza_preparacion_validate;
                                    maleza_preparacion_validate = maleza_preparacion_validate > 100 ? 100 : maleza_preparacion_validate;
                                    var maleza_preparacion = 10 - (maleza_preparacion_validate / 10);

                                    var erocion_validate = document.getElementById("erocion").value;
                                    erocion_validate = erocion_validate < 0 ? 0 : erocion_validate;
                                    erocion_validate = erocion_validate > 100 ? 100 : erocion_validate;
                                    var erocion = erocion_validate / 10;

                                    var enfermedades = 7.5;
                                    var semilla = 7.5;

                                    var simulador_problemas = 100 - (100/475) * (((100/10)*ph)+((50/10)*drenage)+((100/10)*plaga_suelo)+((65/10)*maleza_preparacion)+((100/10)*enfermedades)+((60/10)*erocion));
                                    var simulador_altura = (100/290) * (((90/10)*ph)+((60/10)*drenage)+((20/10)*enfermedades)+((30/10)*erocion)+((90/10)*semilla));
                                    var simulador_humedad = (100/145) * (((100/10)*drenage)+((45/10)*maleza_preparacion));
                                    var simulador_rendimiento = (100/535) * (((100/10)*ph)+((75/10)*drenage)+((100/10)*enfermedades)+((100/10)*plaga_suelo)+((30/10)*maleza_preparacion)+((50/10)*semilla)+((80/10)*erocion));

                                    document.getElementById("simulador_problemas").value = simulador_problemas;
                                    document.getElementById("simulador_altura").value = simulador_altura;
                                    document.getElementById("simulador_humedad").value = simulador_humedad;
                                    document.getElementById("simulador_rendimiento").value = simulador_rendimiento;

                                    var ph_validate_sim = document.getElementById("ph").value;
                                    var plaga_suelo_validate_sim = document.getElementById("plaga_suelo").value;
                                    if(ph_validate_sim < 4|| ph_validate_sim > 10 || plaga_suelo_validate_sim > 75){
                                        simulador_problemas = 100;
                                        simulador_altura = 0;
                                        simulador_humedad = 0;
                                        simulador_rendimiento = 0;
                                    }

                                    historicalBarChart[0].values[0].value = simulador_problemas;
                                    historicalBarChart[0].values[1].value = simulador_altura;
                                    historicalBarChart[0].values[2].value = simulador_humedad;
                                    historicalBarChart[0].values[3].value = simulador_rendimiento;

                                    chartBar.update();
                                }
                            </script>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
