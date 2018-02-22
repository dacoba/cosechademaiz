@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Siembras</h2>
            </div>
        </div>
        @if ( Auth::user()->tipo == 'Tecnico')
            <div class="col-md-12">
        @else
            <div class="col-md-12">
        @endif
            <div class="panel panel-default">
                <div class="panel-heading">Registrar Preparacion del Terreno</div>
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
                            <td style="text-align: right">{{$preterreno['terreno']['area_parcela']}} Hec.</td>
                            <td>{{$preterreno['terreno']['productor']['nombre']}} {{$preterreno['terreno']['productor']['apellido']}}</td>
                            <td>{{$preterreno['tecnico']['nombre']}} {{$preterreno['tecnico']['apellido']}}</td>
                            <?php
                                $ph = $preterreno['ph'];
                                $plaga_suelo = $preterreno['plaga_suelo'];
                                $drenage = $preterreno['drenage'];
                                $erocion = $preterreno['erocion'];
                                $maleza_preparacion = $preterreno['maleza_preparacion'];
                            ?>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-6 col-md-5">
                            <center>
                                <form class="form-horizontal" role="form" method="POST" id="form_siembra" action="{{ url('/siembras') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="preparacionterreno_id" value="{{ $preterreno['id']  }}" >
                                    @if (isset($siembra))
                                        <input type="hidden" name="siembra_id" value="{{ $siembra['id']  }}" >
                                    @endif
                                        <div class="form-group">
                                        <label for="semilla" class="col-md-5 control-label">Semilla  <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Semilla utilizada para la siembra."></i></label>
                                        <div class="col-md-6">
                                            <select id="semilla" name="semilla" class="form-control" onchange="updateBarchar()">
                                                <option value="1" @if (isset($siembra['semilla']) and $siembra['semilla'] == '1') selected @endif >No Certificada</option>
                                                <option value="2" @if (isset($siembra['semilla']) and $siembra['semilla'] == '2') selected @endif >Certificada</option>
                                                <option value="3" @if (isset($siembra['semilla']) and $siembra['semilla'] == '3') selected @endif >Registrada</option>
                                                <option value="4" @if (isset($siembra['semilla']) and $siembra['semilla'] == '4') selected @endif >Basica</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fertilizacion" class="col-md-5 control-label">Fertilizacion
                                            @if (isset($ph_aux) and $ph_aux < 5)
                                                <i class="fa fa-question-circle" aria-hidden="true" style="color:#d49e41;cursor: pointer;" title="Evaluacion de la utilizacion de diferentes quimicos. El Ph registrado es menor a 5, se recomienda el uso de nitrtos que elevan el Ph"></i>
                                            @endif
                                            @if (isset($ph_aux) and $ph_aux >=5 and $ph_aux <= 7)
                                                <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de la utilizacion de diferentes quimicos. El Ph registrado esta entre 5 y 7, "></i>
                                            @endif
                                            @if (isset($ph_aux) and $ph_aux == '1')
                                                <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de la utilizacion de diferentes quimicos o estrategias para fortalecer el crecimiento del maiz (10 es la correcta utilizacion de fertilizantes, 1 muy mala)"></i>
                                            @endif
                                            <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de la utilizacion de diferentes quimicos o estrategias para fortalecer el crecimiento del maiz (10 es la correcta utilizacion de fertilizantes, 1 muy mala)"></i>
                                        </label>
                                        <div class="col-md-6">
                                            <select id="fertilizacion" name="fertilizacion" class="form-control" onchange="updateBarchar()">
                                                <option value="0" @if (isset($siembra['fertilizacion']) and $siembra['fertilizacion'] == '0') selected @endif >Fertiliacion no Correcta</option>
                                                <option value="1" @if (isset($siembra['fertilizacion']) and $siembra['fertilizacion'] == '1') selected @endif >Fertilizacion Correcta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="distancia_surco" class="col-md-5 control-label">Distancia entre surcos <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de la distancia de surco a surco (optimo 80cm) y de planta a planta (50cm optimo), 10 correcta distribucion, 1 muy mala"></i></label>
                                        <div class="col-md-6">
                                            <input type="number" id="distancia_surco" name="distancia_surco" step="0.01" class="form-control" value="{{ $siembra['distancia_surco'] or '0.00' }}" style="text-align:right" onchange="updateBarchar()"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="distancia_planta" class="col-md-5 control-label">Distancia entre plantas <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de la distancia de surco a surco (optimo 80cm) y de planta a planta (50cm optimo), 10 correcta distribucion, 1 muy mala"></i></label>
                                        <div class="col-md-6">
                                            <input type="number" id="distancia_planta" name="distancia_planta" step="0.01" class="form-control" value="{{ $siembra['distancia_planta'] or '0.00' }}" style="text-align:right" onchange="updateBarchar()"/>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('comentario_siembra') ? ' has-error' : '' }}">
                                        <label for="comentario_siembra" class="col-md-5 control-label">Observacion</label>
                                        <div class="col-md-6">
                                            <input id="comentario_siembra" type="text" class="form-control" name="comentario_siembra" value="{{ $siembra['comentario_siembra'] or old('comentario_siembra') }}">
                                            @if ($errors->has('comentario_siembra'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('comentario_siembra') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="simulador_problemas" id="simulador_problemas" value="">
                                    <input type="hidden" name="simulador_altura" id="simulador_altura" value="">
                                    <input type="hidden" name="simulador_humedad" id="simulador_humedad" value="">
                                    <input type="hidden" name="simulador_rendimiento" id="simulador_rendimiento" value="">
                                    <input type="hidden" name="confirm" id="confirm" value="false">

                                    <div class="form-group">
                                        <div class="col-md-11" style="text-align:right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-save"></i> Guardar
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
                                                        <th>Semilla</th>
                                                        <td id="m_semilla"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fertilizacion</th>
                                                        <td id="m_fertilizacion"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Distancia entre surcos</th>
                                                        <td id="m_distancia_surco"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Distancia entre plantas</th>
                                                        <td id="m_distancia_planta"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Observaciones</th>
                                                        <td id="m_comentario_siembra"></td>
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
                                        $('#m_semilla').text($('#semilla option:selected').html());
                                        $('#m_fertilizacion').text($('#fertilizacion option:selected').html());
                                        $('#m_distancia_surco').text($('#distancia_surco').val() + " cm");
                                        $('#m_distancia_planta').text($('#distancia_planta').val() + " cm");
                                        $('#m_comentario_siembra').text($('#comentario_siembra').val());
                                    });

                                    $('#submit').click(function(){
                                        $('#confirm').val(true);
                                        $('#form_siembra').submit();
                                    });
                                </script>
                            </center>
                        </div>
                        <div class="col-md-7 col-lg-6">
                            <style>
                                text {
                                    font: 12px sans-serif;
                                }
                                svg {
                                    display: block;
                                }
                                html, body, #chart1, svg {
                                    margin: 0px;
                                    padding: 0px;
                                    height: 100%;
                                    width: 100%;
                                }
                                .preterreno{
                                    text-align: center;
                                    font-weight: bold;
                                }
                            </style>
                            <table width="80%" border="1px grey" style="margin-left: auto;margin-right: auto;">
                                <tr>
                                    <td class="preterreno" style="background: rgb(31, 119, 180);"><?=round($simulador['problemas'], 2);?> %</td>
                                    <td class="preterreno" style="background: rgb(174, 199, 232);"><?=round($simulador['altura'], 2);?> %</td>
                                    <td class="preterreno" style="background: rgb(255, 127, 14);"><?=round($simulador['humedad'], 2);?> %</td>
                                    <td class="preterreno" style="background: rgb(255, 187, 120);"><?=round($simulador['rendimiento'], 2);?> %</td>
                                </tr>
                            </table>
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

                                    var ph_ini = <?=$ph?>;
                                    var fertilizacion = document.getElementById("fertilizacion").value;
                                    var ph_aux = ((7 - ph_ini) * fertilizacion) + ph_ini
                                    var ph = 10 - (Math.abs(ph_aux - 7) / 0.7);

                                    var plaga_suelo = 10 - (<?=$plaga_suelo?> / 10);
                                    var drenage = <?=$drenage?> / 10;
                                    var maleza_preparacion = 10 - (<?=$maleza_preparacion?> / 10);
                                    var erocion = <?=$erocion?> / 10;

                                    var semilla = document.getElementById("semilla").value * 2.5;
                                    var enfermedades = 7.5;

                                    var simulador_problemas = 100 - (100/475) * (((100/10)*ph)+((50/10)*drenage)+((100/10)*plaga_suelo)+((65/10)*maleza_preparacion)+((100/10)*enfermedades)+((60/10)*erocion));
                                    var simulador_altura = (100/290) * (((90/10)*ph)+((60/10)*drenage)+((20/10)*enfermedades)+((30/10)*erocion)+((90/10)*semilla));
                                    var simulador_humedad = (100/145) * (((100/10)*drenage)+((45/10)*maleza_preparacion));
                                    var simulador_rendimiento = (100/535) * (((100/10)*ph)+((75/10)*drenage)+((100/10)*enfermedades)+((100/10)*plaga_suelo)+((30/10)*maleza_preparacion)+((50/10)*semilla)+((80/10)*erocion));

                                    document.getElementById("simulador_problemas").value = simulador_problemas;
                                    document.getElementById("simulador_altura").value = simulador_altura;
                                    document.getElementById("simulador_humedad").value = simulador_humedad;
                                    document.getElementById("simulador_rendimiento").value = simulador_rendimiento;

                                    historicalBarChart[0].values[0].value = simulador_problemas;
                                    historicalBarChart[0].values[1].value = simulador_altura;
                                    historicalBarChart[0].values[2].value = simulador_humedad;
                                    historicalBarChart[0].values[3].value = simulador_rendimiento;

                                    chartBar.update();
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
