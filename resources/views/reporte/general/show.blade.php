@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Reporte General</h2>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Datos del Proceso de Produccion</div>

                <div class="panel-body">
                    <style>
                        /* custom inclusion of right, left and below tabs */

                        .tabs-below > .nav-tabs,
                        .tabs-right > .nav-tabs,
                        .tabs-left > .nav-tabs {
                            border-bottom: 0;
                        }

                        .tab-content > .tab-pane,
                        .pill-content > .pill-pane {
                            display: none;
                        }

                        .tab-content > .active,
                        .pill-content > .active {
                            display: block;
                        }

                        .tabs-below > .nav-tabs {
                            border-top: 1px solid #ddd;
                        }

                        .tabs-below > .nav-tabs > li {
                            margin-top: -1px;
                            margin-bottom: 0;
                        }

                        .tabs-below > .nav-tabs > li > a {
                            -webkit-border-radius: 0 0 4px 4px;
                            -moz-border-radius: 0 0 4px 4px;
                            border-radius: 0 0 4px 4px;
                        }

                        .tabs-below > .nav-tabs > li > a:hover,
                        .tabs-below > .nav-tabs > li > a:focus {
                            border-top-color: #ddd;
                            border-bottom-color: transparent;
                        }

                        .tabs-below > .nav-tabs > .active > a,
                        .tabs-below > .nav-tabs > .active > a:hover,
                        .tabs-below > .nav-tabs > .active > a:focus {
                            border-color: transparent #ddd #ddd #ddd;
                        }

                        .tabs-left > .nav-tabs > li,
                        .tabs-right > .nav-tabs > li {
                            float: none;
                        }

                        .tabs-left > .nav-tabs > li > a,
                        .tabs-right > .nav-tabs > li > a {
                            min-width: 74px;
                            margin-right: 0;
                            margin-bottom: 3px;
                        }

                        .tabs-left > .nav-tabs {
                            float: left;
                            margin-right: 19px;
                            border-right: 1px solid #ddd;
                        }

                        .tabs-left > .nav-tabs > li > a {
                            margin-right: -1px;
                            -webkit-border-radius: 4px 0 0 4px;
                            -moz-border-radius: 4px 0 0 4px;
                            border-radius: 4px 0 0 4px;
                        }

                        .tabs-left > .nav-tabs > li > a:hover,
                        .tabs-left > .nav-tabs > li > a:focus {
                            border-color: #eeeeee #dddddd #eeeeee #eeeeee;
                        }

                        .tabs-left > .nav-tabs .active > a,
                        .tabs-left > .nav-tabs .active > a:hover,
                        .tabs-left > .nav-tabs .active > a:focus {
                            border-color: #ddd transparent #ddd #ddd;
                            *border-right-color: #ffffff;
                        }

                        .tabs-right > .nav-tabs {
                            float: right;
                            margin-left: 19px;
                            border-left: 1px solid #ddd;
                        }

                        .tabs-right > .nav-tabs > li > a {
                            margin-left: -1px;
                            -webkit-border-radius: 0 4px 4px 0;
                            -moz-border-radius: 0 4px 4px 0;
                            border-radius: 0 4px 4px 0;
                        }

                        .tabs-right > .nav-tabs > li > a:hover,
                        .tabs-right > .nav-tabs > li > a:focus {
                            border-color: #eeeeee #eeeeee #eeeeee #dddddd;
                        }

                        .tabs-right > .nav-tabs .active > a,
                        .tabs-right > .nav-tabs .active > a:hover,
                        .tabs-right > .nav-tabs .active > a:focus {
                            border-color: #ddd #ddd #ddd transparent;
                            *border-left-color: #ffffff;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th>Productor</th>
                            <th colspan="2" class="text-right">Area Parcela</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$preterreno['terreno']['productor']['nombre']}} {{$preterreno['terreno']['productor']['apellido']}}</td>
                            <td colspan="2" class="text-right">{{$preterreno['terreno']['area_parcela']}} Hectareas.</td>
                        </tr>
                        </tbody>
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th>Tecnico Responsable</th>
                            <th class="text-right">Codigo del Proceso</th>
                            <th class="text-right">Fecha de inicio</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$preterreno['tecnico']['nombre']}} {{$preterreno['tecnico']['apellido']}}</td>
                            <td class="text-right">{{$preterreno['id']}}</td>
                            <td class="text-right">{{ date('d/m/Y', strtotime($preterreno['created_at'])) }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <style>
                        @media (min-width: 768px) {
                            .sidebar-nav .navbar .navbar-collapse {
                                padding: 0;
                                max-height: none;
                            }
                            .sidebar-nav .navbar ul {
                                float: none;
                                display: block;
                            }
                            .sidebar-nav .navbar li {
                                float: none;
                                display: block;
                            }
                            .sidebar-nav .navbar li a {
                                padding-top: 12px;
                                padding-bottom: 12px;
                            }
                        }
                    </style>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="sidebar-nav">
                                <div class="navbar navbar-default" role="navigation">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <span class="visible-xs navbar-brand">Reportes</span>
                                    </div>
                                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="#tab1" data-toggle="tab">Resumen</a></li>
                                            <li><a href="#tabPlanificaciones" data-toggle="tab">Planificaciones</a></li>
                                            <li><a href="#tabCosecha" data-toggle="tab" onClick="haEchoClick();">Cosecha</a></li>
                                            <li><a href="#tabRiegosyfumigaciones" data-toggle="tab">Riegos y Fumigaciones</a></li>
                                            <li><a href="#tabEstimacion" data-toggle="tab">Estimacion de Produccion</a></li>
                                            <li><a href="#tabCalidad" data-toggle="tab" onClick="haEchoClickCalidad();">Control de Calidad</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <center>
                                        <h2 class="h2-reports">Reportes</h2>
                                    </center>
                                </div>
                                <div class="tab-pane" id="tabPlanificaciones">
                                    <center>
                                        <h2 class="h2-reports">Panificaciones</h2>
                                    </center>
                                    @if($planificaciones['exist'])
                                        <?php
                                        $riego_percent = 100 / $planificaciones['planificacionriego']->count() * $planificaciones['planificacionriegoEnd']->count();
                                        $fumigacion_percent = 100 / $planificaciones['planificacionfumigacion']->count() * $planificaciones['planificacionfumigacionEnd']->count();
                                        ?>
                                        <center>
                                            <div class="skills">
                                                <div class="col-sm-6 col-md-3 col-md-offset-2 text-center reports-skills">
                                            <span data-percent="{{ $riego_percent }}" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                                                <span class="percent">{{ $riego_percent }}</span>
                                            </span>
                                                    <h3 class="text-center">Riego</h3>
                                                    @if ($riego_percent != 100)
                                                        <p class="reports-skills-p"><strong>Fecha del siguiente riego</strong><br>{{ date('H:i a - d/m/Y', strtotime($planificaciones['planificacionriegoPla']->first()['fecha_planificacion'])) }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 col-md-3 col-md-offset-2 text-center reports-skills">
                                            <span data-percent="{{ $fumigacion_percent }}" class="chart easyPieChart" style="barColor:black; width: 140px; height: 140px; line-height: 140px;">
                                                <span class="percent">{{ round($fumigacion_percent, 1) }}</span>
                                            </span>
                                                    <h3 class="text-center">Fumigacion</h3>
                                                    @if ($fumigacion_percent != 100)
                                                        <p class="reports-skills-p"><strong>Fecha de la siguiente fumigacion</strong><br>{{ date('H:i a - d/m/Y', strtotime($planificaciones['planificacionfumigacionPla']->first()['fecha_planificacion'])) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </center>
                                    @else
                                        <p>No hay planificaciones registradas.</p>
                                    @endif
                                </div>
                                <div class="tab-pane" id="tabCosecha">
                                    <center>
                                        <h2 class="h2-reports">Cosecha</h2>
                                    </center>
                                    @if($cosecha['exist'])
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
                                            <div id="chartCosecha" style="height: 250px;">
                                                <svg></svg>
                                            </div>
                                            <p><strong>Comentario: </strong>{{$cosecha['cosecha']['comentario_cosecha']}}</p>
                                        </center>
                                        <script>
                                            var chartBarCosecha;
                                            historicalBarChartCosecha = [
                                                {
                                                    key: "Cumulative Return",
                                                    values: [
                                                        {
                                                            "label" : "Problemas de produccion",
                                                            "value" : <?=$cosecha['cosecha']['problemas_produccion']?>
                                                        } ,
                                                        {
                                                            "label" : "Altura de tallo" ,
                                                            "value" : <?=$cosecha['cosecha']['altura_tallo']?>
                                                        } ,
                                                        {
                                                            "label" : "Humedad del terreno" ,
                                                            "value" : <?=$cosecha['cosecha']['humedad_terreno']?>
                                                        } ,
                                                        {
                                                            "label" : "Remdimiento de produccion" ,
                                                            "value" : <?=$cosecha['cosecha']['rendimiento_produccion']?>
                                                        }
                                                    ]
                                                }
                                            ];
                                            nv.addGraph(function() {
                                                chartBarCosecha = nv.models.discreteBarChart()
                                                    .x(function(d) { return d.label })
                                                    .y(function(d) { return d.value })
                                                    .staggerLabels(true)
                                                    .showValues(true)
                                                    .duration(1)
                                                    .color(['#bc5a45', '#405d27', '#034f84', '#618685']);
                                                ;

                                                d3.select('#chartCosecha svg')
                                                    .datum(historicalBarChartCosecha)
                                                    .call(chartBarCosecha);

                                                nv.utils.windowResize(chartBarCosecha.update);
                                                return chartBarCosecha;
                                            });
                                        </script>
                                        <script>
                                            function haEchoClick() {
                                                nv.addGraph(function() {
                                                    chartBarCosecha = nv.models.discreteBarChart()
                                                        .x(function(d) { return d.label })
                                                        .y(function(d) { return d.value })
                                                        .staggerLabels(true)
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
                                            }
                                        </script>
                                    @else
                                        <p>No hay una cosecha registrada.</p>
                                    @endif
                                </div>
                                <div class="tab-pane" id="tabRiegosyfumigaciones">
                                    <center>
                                        <h2 class="h2-reports">Riegos y Fumigaciones</h2>
                                    </center>
                                    @if($planificaciones['exist'])
                                        <style>
                                            .btn-mini-xs {
                                                padding: 5px 10px;
                                            }
                                        </style>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center">Planificacion</th>
                                                <th style="text-align: center">Fecha de Planificacion</th>
                                                <th style="text-align: center">Estado</th>
                                                <th style="text-align: center">Detalles</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($planificaciones['lista'] as $planificacion)
                                                <tr>
                                                    <td style="text-align: center">{{$planificacion['table_name']}}</td>
                                                    <td style="text-align: center">{{ date('H:i a - d/m/Y', strtotime($planificacion['fecha_planificacion'])) }}</td>
                                                    <td style="text-align: center">{{$planificacion['estado']}}</td>
                                                    <td style="text-align: center">
                                                        @if($planificacion['estado'] != "Registrado")
                                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Aun no se han registrado datos para esta planificacion">
                                                                <button class="btn btn-primary btn-xs btn-mini-xs" disabled>
                                                                    <i class="fa fa-btn fa-file-text-o"></i>
                                                                </button>
                                                            </span>
                                                        @else
                                                            @if($planificacion['table_name'] == "Riego")
                                                                <?php $metodos = ['None', 'Lluvia', 'Pozo de riego']?>
                                                                <button class="btn btn-primary btn-xs btn-mini-xs" onClick="showDetails('{{$planificacion['table_name']}}','{{$metodos[$planificacion['metodos_riego']]}}','{{$planificacion['comportamiento_lluvia']}}','{{$planificacion['problemas_drenaje']}}');">
                                                                    <i class="fa fa-btn fa-file-text-o"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-primary btn-xs btn-mini-xs" onClick="showDetails('{{$planificacion['table_name']}}','{{$planificacion['preventivo_plagas']}}','{{$planificacion['control_malezas']}}','{{$planificacion['control_enfermedades']}}');">
                                                                    <i class="fa fa-btn fa-file-text-o"></i>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <table class="table table-sm" id="tableRiego" style="display: none">
                                                    <thead>
                                                    <tr>
                                                        <th>Dato</th>
                                                        <th class="text-right">Valor</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Metodos de Riego</th>
                                                        <td class="text-right" id="metodos_riego">-</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Comportamineto de lluvia</th>
                                                        <td class="text-right"><span id="comportamiento_lluvia">0</span><strong> %</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Problemas de Drenaje</th>
                                                        <td class="text-right"><span id="problemas_drenaje">0</span><strong> %</strong></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-sm" id="tableFumigacion" style="display: none">
                                                    <thead>
                                                    <tr>
                                                        <th>Dato</th>
                                                        <th class="text-right">Valor</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Preventivo Plagas</th>
                                                        <td class="text-right"><span id="preventivo_plagas">0</span><strong> %</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Control Malezas</th>
                                                        <td class="text-right"><span id="control_malezas">0</span><strong> %</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Control Enfermedades</th>
                                                        <td class="text-right"><span id="control_enfermedades">0</span><strong> %</strong></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script>
                                            function showDetails(value,value1,value2,value3) {
                                                // alert(value);
                                                if(value === "Riego"){
                                                    $('#metodos_riego').text(value1);
                                                    $('#comportamiento_lluvia').text(value2);
                                                    $('#problemas_drenaje').text(value3);
                                                    document.getElementById("tableRiego").style.display = "table";
                                                    document.getElementById("tableFumigacion").style.display = "none";
                                                }else {
                                                    $('#preventivo_plagas').text(value1);
                                                    $('#control_malezas').text(value2);
                                                    $('#control_enfermedades').text(value3);
                                                    document.getElementById("tableRiego").style.display = "none";
                                                    document.getElementById("tableFumigacion").style.display = "table";
                                                }
                                            }
                                        </script>
                                    @else
                                        <p>No hay planificaciones de riegos y fumigaciones.</p>
                                    @endif
                                </div>
                                <div class="tab-pane" id="tabEstimacion">
                                    <center>
                                        <h2 class="h2-reports">Estimacion de Produccion de Maiz</h2>
                                    </center>
                                    @if($estimacion['exist'])
                                        <?php
                                        $plantas_por_hectarea = (10000/($estimacion['siembra']['distancia_surco'] * $estimacion['siembra']['distancia_surco']))*10000;
                                        $rendimiento_produccion = ceil($cosecha['cosecha']['rendimiento_produccion']/25)-1;
                                        $produccion_maiz = $rendimiento_produccion * $plantas_por_hectarea * 0.375 * 0.001;
                                        ?>

                                        <center>
                                            <br>La estimacion de produccion de maiz en base al rendimiento de <?=$cosecha['cosecha']['rendimiento_produccion']?> %
                                            se estima la produccion de <?=round($produccion_maiz,1)?> Toneladas por hectarea aproximadamente, haciendo un total de:.
                                            <br><br><h2 style="text-transform: lowercase"><?=number_format(round($produccion_maiz,1) * $estimacion['siembra']['preparacionterreno']['terreno']['area_parcela'], 0, '.', ','); ?> Toneladas.</h2>
                                        </center>
                                    @else
                                        <p>No hay una siembra y/o cosecha registrada.</p>
                                    @endif
                                </div>
                                <div class="tab-pane" id="tabCalidad">
                                    <center>
                                        <h2 class="h2-reports">Control de Calidad</h2>
                                    </center>
                                    @if($calidad['exist'])
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
                                        <center>
                                            <div id="chart1" style="height: 250px;">
                                                <svg></svg>
                                            </div>
                                        </center>
                                        <script>
                                            // var chartBarCalidad;
                                            historicalBarChart = [
                                                {
                                                    key: "Cumulative Return",
                                                    values: [
                                                        {
                                                            "label" : "Ph" ,
                                                            "value" : <?=$calidad['calidad']['ph']?>
                                                        } ,
                                                        {
                                                            "label" : "Plagas" ,
                                                            "value" : <?=$calidad['calidad']['plagas']?>
                                                        } ,
                                                        {
                                                            "label" : "Drenaje" ,
                                                            "value" : <?=$calidad['calidad']['drenaje']?>
                                                        } ,
                                                        {
                                                            "label" : "Erocion" ,
                                                            "value" : <?=$calidad['calidad']['erocion']?>
                                                        } ,
                                                        {
                                                            "label" : "Malezas" ,
                                                            "value" : <?=$calidad['calidad']['malezas']?>
                                                        } ,
                                                        {
                                                            "label" : "Enfermedades" ,
                                                            "value" : <?=$calidad['calidad']['enfermedades']?>
                                                        }
                                                    ]
                                                }
                                            ];
                                        </script>
                                        <script>
                                            function haEchoClickCalidad() {
                                                nv.addGraph(function() {
                                                    chartBar = nv.models.discreteBarChart()
                                                        .x(function(d) { return d.label })
                                                        .y(function(d) { return d.value })
                                                        .staggerLabels(true)
                                                        .showValues(true)
                                                        .duration(250)
                                                    ;

                                                    d3.select('#chart1 svg')
                                                        .datum(historicalBarChart)
                                                        .call(chartBar);

                                                    nv.utils.windowResize(chartBar.update);
                                                    return chartBar;
                                                });
                                            }
                                        </script>
                                        <center>
                                            <strong>Media : </strong>{{ $calidad['estadistico']['media'] }}<br>
                                            <strong>Varianza : </strong>{{ $calidad['estadistico']['varianza'] }}<br>
                                            <strong>Desviación Estándar : </strong>{{ $calidad['estadistico']['desviacion_estandar'] }}<br>
                                        </center>
                                    @else
                                        <p>No hay una siembra y/o cosecha registrada.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
