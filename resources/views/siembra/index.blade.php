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
                            @if (isset($siembra))
                                <td style="text-align: right">{{$siembra['preparacionterreno']['terreno']['area_parcela']}} Hec.</td>
                                <td>{{$siembra['preparacionterreno']['terreno']['productor']['nombre']}} {{$siembra['preparacionterreno']['terreno']['productor']['apellido']}}</td>
                                <td>{{$siembra['preparacionterreno']['tecnico']['nombre']}} {{$siembra['preparacionterreno']['tecnico']['apellido']}}</td>
                                <?php
                                    $ph = $siembra['preparacionterreno']['ph'];
                                    $plaga_suelo = $siembra['preparacionterreno']['plaga_suelo'];
                                    $drenage = $siembra['preparacionterreno']['drenage'];
                                    $erocion = $siembra['preparacionterreno']['erocion'];
                                    $maleza_preparacion = $siembra['preparacionterreno']['maleza_preparacion'];
                                ?>
                            @else
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
                            @endif
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-6 col-md-5">
                            <center>
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/siembras') }}">
                                    {{ csrf_field() }}
                                    @if (isset($siembra))
                                        <input type="hidden" name="siembra_id" value="{{ $siembra['id']  }}" >
                                    @else
                                        <input type="hidden" name="preparacionterreno_id" value="{{ $preterreno['id']  }}" >
                                    @endif
                                        <div class="form-group">
                                        <label for="semilla" class="col-md-4 control-label">Semilla  <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Semilla utilizada para la siembra."></i></label>
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
                                        <label for="fertilizacion" class="col-md-4 control-label">Fertilizacion
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
                                                <option value="0" @if (isset($siembra['fertilizacion']) and $siembra['fertilizacion'] == '1') selected @endif >Fertiliacion no Correcta</option>
                                                <option value="1" @if (isset($siembra['fertilizacion']) and $siembra['fertilizacion'] == '10') selected @endif >Fertilizacion Correcta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="densidad_siembra" class="col-md-4 control-label">Densidad de la Siembra <i class="fa fa-question-circle" aria-hidden="true" style="color:#428bca;cursor: pointer;" title="Evaluacion de la distancia de surco a surco (optimo 80cm) y de planta a planta (50cm optimo), 10 correcta distribucion, 1 muy mala"></i></label>
                                        <div class="col-md-6">
                                            <select id="densidad_siembra" name="densidad_siembra" class="form-control" onchange="updateBarchar()">
                                                <option value="1" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '1') selected @endif >1</option>
                                                <option value="2" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '2') selected @endif >2</option>
                                                <option value="3" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '3') selected @endif >3</option>
                                                <option value="4" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '4') selected @endif >4</option>
                                                <option value="5" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '5') selected @endif >5</option>
                                                <option value="6" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '6') selected @endif >6</option>
                                                <option value="7" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '7') selected @endif >7</option>
                                                <option value="8" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '8') selected @endif >8</option>
                                                <option value="9" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '9') selected @endif >9</option>
                                                <option value="10" @if (isset($siembra['densidad_siembra']) and $siembra['densidad_siembra'] == '10') selected @endif >10</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('comentario_siembra') ? ' has-error' : '' }}">
                                        <label for="comentario_siembra" class="col-md-4 control-label">Observacion</label>
                                        <div class="col-md-6">
                                            <input id="comentario_siembra" type="text" class="form-control" name="comentario_siembra" value="{{ old('comentario_siembra') }}">
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

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-user"></i>
                                                @if ( Auth::user()->tipo == 'Administrador')
                                                    @if (isset($preterreno))
                                                        Asignar Tecnico
                                                    @else
                                                        Iniciar Cosecha
                                                    @endif
                                                @else
                                                    Registrar Datos
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </form>
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