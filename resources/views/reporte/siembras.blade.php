@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Reporte de Siembras</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/reportes/siembras') }}">
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
                                <i class="fa fa-btn fa-user"></i> Cargar Siembra
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Reporte de siembras</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($siembra_id))
                        @if (isset($band))
                            <div class="row" style="margin-top: 50px;">
                                <div class="col-lg-6 col-md-12">
                                <center>
                                    <h2 class="h2-reports">Panificaciones</h2>
                                    <div class="skills">
                                        <div class="col-sm-6 col-md-3 col-md-offset-2 text-center reports-skills">
                                        <span data-percent="{{ $riego }}" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                                            <span class="percent">{{ $riego }}</span>
                                        </span>
                                            <h3 class="text-center">Riego</h3>
                                            @if (isset($planificacionriegonext) and $planificacionriegonext != False)
                                                <p class="reports-skills-p"><strong>Fecha del siguiente riego</strong><br>{{ $planificacionriegonext[0]['fecha_planificacion'] }}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-6 col-md-3 col-md-offset-2 text-center reports-skills">
                                        <span data-percent="{{ $fumigacion }}" class="chart easyPieChart" style="barColor:black; width: 140px; height: 140px; line-height: 140px;">
                                            <span class="percent">{{ $fumigacion }}</span>
                                        </span>
                                            <h3 class="text-center">Fumigacion</h3>
                                            @if (isset($planificacionfumigacionnext) and $planificacionfumigacionnext != False)
                                                <p class="reports-skills-p"><strong>Fecha de la siguiente fumigacion</strong><br>{{ $planificacionfumigacionnext[0]['fecha_planificacion'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </center>
                                </div>
                                @if(isset($cosecha[0]))
                                    <div class="col-lg-6 col-md-12">
                                        <style>
                                            text {
                                                font: 12px sans-serif;
                                            }
                                            svg {
                                                display: block;
                                            }
                                            html, body, #chartCosecha, svg {
                                                margin: 0px;
                                                padding: 0px;
                                                height: 100%;
                                                width: 100%;
                                            }
                                        </style>
                                        <center>
                                            <h2 class="h2-reports">Cosecha</h2>
                                            <div id="chartCosecha" style="height: 250px;">
                                                <svg></svg>
                                            </div>
                                            <p><strong>Comentario: </strong>{{$cosecha[0]['comentario_cosecha']}}</p>
                                        </center>
                                        <script>
                                            var chartBarCosecha;
                                            historicalBarChartCosecha = [
                                                {
                                                    key: "Cumulative Return",
                                                    values: [
                                                        {
                                                            "label" : "Problemas de produccion",
                                                            "value" : <?=$cosecha[0]['problemas_produccion']?>
                                                        } ,
                                                        {
                                                            "label" : "Altura de tallo" ,
                                                            "value" : <?=$cosecha[0]['altura_tallo']?>
                                                        } ,
                                                        {
                                                            "label" : "Humedad del terreno" ,
                                                            "value" : <?=$cosecha[0]['humedad_terreno']?>
                                                        } ,
                                                        {
                                                            "label" : "Remdimiento de produccion" ,
                                                            "value" : <?=$cosecha[0]['rendimiento_produccion']?>
                                                        }
                                                    ]
                                                }
                                            ];
                                            nv.addGraph(function() {
                                                chartBarCosecha = nv.models.discreteBarChart()
                                                    .x(function(d) { return d.label })
                                                    .y(function(d) { return d.value })
                                                    .staggerLabels(true)
                                                    //.staggerLabels(historicalBarChart[0].values.length > 8)
                                                    .showValues(true)
                                                    .duration(250)
                                                    .color(['#bc5a45', '#405d27', '#034f84', '#618685']);
                                                ;

                                                d3.select('#chartCosecha svg')
                                                    .datum(historicalBarChartCosecha)
                                                    .call(chartBarCosecha);

                                                nv.utils.windowResize(chartBarCosecha.update);
                                                return chartBarCosecha;
                                            });
                                        </script>
                                    </div>
                                @endif
                                <div class="col-lg-6 col-md-12">
                                    <center>
                                        <h2 class="h2-reports">Riegos y Fumigaciones</h2>
                                    </center>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">Fecha</th>
                                            <th style="text-align: center">Estado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $camtidad_riegos = count($riego_lista);
                                        $acum_problemas_drenaje = 0;
                                        $acum_comportamiento_lluvia = 0;

                                        $camtidad_fumigaciones = count($fumigacion_lista);
                                        $acum_preventivo_plagas = 0;
                                        $acum_control_malezas = 0;
                                        $acum_control_enfermedades = 0;
                                        ?>
                                        @foreach ($riego_lista as $riego_one)
                                            <?php
                                                $acum_problemas_drenaje += $riego_one['problemas_drenaje'];
                                                $acum_comportamiento_lluvia += $riego_one['comportamiento_lluvia'];
                                            ?>
                                            <tr style="background: rgba(0, 38, 255, 0.29);">
                                                <td style="text-align: center">Riego</td>
                                                <td style="text-align: center">{{$riego_one['fecha_planificacion']}}</td>
                                                <td style="text-align: center">{{$riego_one['estado']}}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($fumigacion_lista as $fumigacion_one)
                                            <?php
                                                $acum_preventivo_plagas += $fumigacion_one['preventivo_plagas'];
                                                $acum_control_malezas += $fumigacion_one['control_malezas'];
                                                $acum_control_enfermedades += $fumigacion_one['control_enfermedades'];
                                            ?>
                                            <tr style="background: #cea4de;">
                                                <td style="text-align: center">Fumigacion</td>
                                                <td style="text-align: center">{{$fumigacion_one['fecha_planificacion']}}</td>
                                                <td style="text-align: center">{{$fumigacion_one['estado']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(isset($cosecha[0]))
                                    <div class="col-lg-6 col-md-12">
                                        <center>
                                            <h2 class="h2-reports">Estimacion de Produccion de Maiz</h2>
                                        </center>
                                        <?php
                                        $plantas_por_hectarea = (10000/($siembra['distancia_surco'] * $siembra['distancia_surco']))*10000;
                                        $rendimiento_produccion = ceil($cosecha[0]['rendimiento_produccion']/25)-1;
                                        $produccion_maiz = $rendimiento_produccion * $plantas_por_hectarea * 0.375 * 0.001;
                                        ?>

                                        <center>
                                            <br>La estimacion de produccion de maiz en base al rendimiento de <?=$cosecha[0]['rendimiento_produccion']?> %
                                            se estima la produccion de <?=round($produccion_maiz,1)?> Toneladas por hectarea aproximadamente, haciendo un total de:.
                                            <br><br><h2 style="text-transform: lowercase"><?=number_format(round($produccion_maiz,1) * $siembra['preparacionterreno']['terreno']['area_parcela'], 0, '.', ','); ?> Toneladas.</h2>
                                        </center>
                                    </div>
                                @endif
                                <div class="col-lg-12 col-md-12">
                                    <center>
                                        <h2 class="h2-reports">Control de Calidad</h2>
                                        <div id="chart1" style="height: 250px;">
                                            <svg></svg>
                                        </div>
                                        <p><strong>Comentario: </strong>{{$siembra['comentario_siembra']}}</p>
                                    </center>
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
                                    </style>
                                    <?php
                                        $ph_ini = $siembra['preparacionterreno']['ph'];
                                        $fertilizacion = $siembra['fertilizacion'];
                                        $ph_aux = ((7 - $ph_ini) * $fertilizacion) + $ph_ini;
                                        $var_ph = 10 - (abs($ph_aux - 7) / 0.7);

                                        $plaga_suelo_ini = 10 - ($siembra['preparacionterreno']['plaga_suelo'] / 10);
                                        $acum_preventivo_plagas = 10 - ($acum_preventivo_plagas / (10 * $camtidad_fumigaciones));
                                        $var_plagas = ($plaga_suelo_ini + $acum_preventivo_plagas) / 2;

                                        $drenage_ini = $siembra['preparacionterreno']['drenage'] / 10;
                                        $acum_problemas_drenaje = $acum_problemas_drenaje / (10 * $camtidad_riegos);
                                        $acum_comportamiento_lluvia = $acum_comportamiento_lluvia / (10 * $camtidad_riegos);
                                        $var_drenage = ($drenage_ini + $acum_problemas_drenaje + $acum_comportamiento_lluvia) / 3;

                                        $var_erocion = $siembra['preparacionterreno']['erocion'] / 10;

                                        $malezas_ini = 10 - ($siembra['preparacionterreno']['maleza_preparacion'] / 10);
                                        $acum_control_malezas = 10 - ($acum_control_malezas / (10 * $camtidad_fumigaciones));
                                        $var_malezas = ($malezas_ini + $acum_control_malezas) / 2;

                                        $var_enfermedades = $acum_control_enfermedades / (10 * $camtidad_fumigaciones);

                                        $media = ($var_ph + $var_plagas + $var_drenage + $var_erocion + $var_malezas + $var_enfermedades) / 6;
                                        $varianza = (pow(($var_ph - $media), 2) + pow(($var_plagas - $media), 2) + pow(($var_drenage - $media), 2) + pow(($var_erocion - $media), 2) + pow(($var_malezas - $media), 2) + pow(($var_enfermedades - $media), 2)) / 6;
                                        $desviacion_estandar = sqrt($varianza);
                                    ?>
                                    <script>
                                        historicalBarChart = [
                                            {
                                                key: "Cumulative Return",
                                                values: [
                                                    {
                                                        "label" : "Ph" ,
                                                        "value" : <?=$var_ph?>
                                                    } ,
                                                    {
                                                        "label" : "Plagas" ,
                                                        "value" : <?=$var_plagas?>
                                                    } ,
                                                    {
                                                        "label" : "Drenaje" ,
                                                        "value" : <?=$var_drenage?>
                                                    } ,
                                                    {
                                                        "label" : "Erocion" ,
                                                        "value" : <?=$var_erocion?>
                                                    } ,
                                                    {
                                                        "label" : "Malezas" ,
                                                        "value" : <?=$var_malezas?>
                                                    } ,
                                                    {
                                                        "label" : "Enfermedades" ,
                                                        "value" : <?=$var_enfermedades?>
                                                    }
                                                ]
                                            }
                                        ];
                                    </script>

                                    <center>
                                        <strong>Media : </strong><?=$media?><br>
                                        <strong>Varianza : </strong><?=$varianza?><br>
                                        <strong>Desviación Estándar : </strong><?=$desviacion_estandar?><br>
                                    </center>
                                </div>
                            </div>
                        @else
                            <center>
                                Esta siembra aun no cuenta con una planificacion de riego o fumigacion
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
