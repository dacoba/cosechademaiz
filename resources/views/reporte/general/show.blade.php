@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="pfblock-header">
            <h2 class="pfblock-title">
                <a href="{{ url('reportes')}}/{{$preterreno['id']}}">
                    <i class="fa fa-chevron-circle-left"></i>
                </a>Reporte General
            </h2>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Datos del Proceso de Produccion
                </div>

                <div class="panel-body">
                    <a class="print hidden-print pull-right"
                       target="_blank"
                       href="{{ url('/pdf/general') }}/{{$preterreno['id']}}">
                        <i class="fa fa-file-pdf-o"></i> Exportar PDF
                    </a>
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
                                            <li class="active"><a href="#tab1" data-toggle="tab">Preparacion y Siembra</a></li>
                                            <li><a href="#tabPlanificaciones" data-toggle="tab">Riegos y Fumigaciones</a></li>
                                            <li><a href="#tabCosecha" data-toggle="tab" onClick="haEchoClick();">Cosecha</a></li>
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
                                        <h2 class="h2-reports">Preparacion y Siembra</h2>
                                    </center>
                                </div>
                                <div class="tab-pane" id="tabPlanificaciones">
                                    <h2 class="h2-reports text-center">Riegos y Fumigaciones</h2>
                                    @if($planificaciones['exist'])
                                        <div class="row text-center mb-30">
                                            <div class="skills">
                                                @if($planificaciones['riego_exist'])
                                                    @php($riego_percent = 100 / $planificaciones['planificacionriego']->count() * $planificaciones['planificacionriegoEnd']->count())
                                                    <div class="col-sm-6 col-md-3 col-md-offset-2 text-center reports-skills">
                                                    <span data-percent="{{ $riego_percent }}" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                                                        <span class="percent">{{ $riego_percent }}</span>
                                                    </span>
                                                    <h3 class="text-center mt-5">Riego</h3>
                                                    @if ($riego_percent != 100)
                                                        <p class="reports-skills-p"><strong>Fecha del siguiente riego</strong><br>{{ date('H:i a - d/m/Y', strtotime($planificaciones['planificacionriegoPla']->first()['fecha_planificacion'])) }}</p>
                                                    @endif
                                                    </div>
                                                @endif
                                                @if($planificaciones['fumifacion_exist'])
                                                    @php($fumigacion_percent = 100 / $planificaciones['planificacionfumigacion']->count() * $planificaciones['planificacionfumigacionEnd']->count())
                                                    <div class="col-sm-6 col-md-3 col-md-offset-2 text-center reports-skills">
                                                    <span data-percent="{{ $fumigacion_percent }}" class="chart easyPieChart" style="barColor:black; width: 140px; height: 140px; line-height: 140px;">
                                                        <span class="percent">{{ round($fumigacion_percent, 1) }}</span>
                                                    </span>
                                                    <h3 class="text-center mt-5">Fumigacion</h3>
                                                    @if ($fumigacion_percent != 100)
                                                        <p class="reports-skills-p"><strong>Fecha de la siguiente fumigacion</strong><br>{{ date('H:i a - d/m/Y', strtotime($planificaciones['planificacionfumigacionPla']->first()['fecha_planificacion'])) }}</p>
                                                    @endif
                                                    </div>
                                                 @endif
                                            </div>
                                        </div>
                                        <style>
                                            .btn-mini-xs {
                                                padding: 5px 10px;
                                            }
                                        </style>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Planificacion</th>
                                                <th class="text-center">Fecha de Planificacion</th>
                                                <th class="text-center hidden-xs">Hora de Planificacion</th>
                                                <th class="text-center hidden-xs">Estado</th>
                                                <th class="text-center">Detalles</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($planificaciones['lista'] as $planificacion)
                                                <tr>
                                                    <td class="text-center">{{$planificacion['table_name']}}</td>
                                                    <td class="text-center">{{ $planificacion['fecha_planificacion']->format('d F Y') }}</td>
                                                    <td class="text-center hidden-xs">{{ $planificacion['fecha_planificacion']->format('H:i a') }}</td>
                                                    <td class="text-center hidden-xs">{{$planificacion['estado']}}</td>
                                                    <td class="text-center">
                                                        @if($planificacion['estado'] != "Registrado")
                                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Aun no se han registrado datos para esta planificacion">
                                                                <button class="btn btn-primary btn-xs btn-mini-xs" disabled>
                                                                    <i class="fa fa-btn fa-file-text-o"></i>
                                                                </button>
                                                            </span>
                                                        @else
                                                            <button class="btn btn-primary btn-xs btn-mini-xs" data-toggle="collapse" data-target="#planificacion_{{$planificacion['id']}}{{$planificacion['table_name']}}">
                                                                <i class="fa fa-btn fa-file-text-o"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($planificacion['estado'] == "Registrado")
                                                    <tr>
                                                        <td colspan="5" class="p-0">
                                                            <div id="planificacion_{{$planificacion['id']}}{{$planificacion['table_name']}}" class="collapse col-md-6 col-md-offset-3">
                                                                @if($planificacion['table_name'] == "Riego")
                                                                    <?php $metodos = ['None', 'Lluvia', 'Pozo de riego']?>
                                                                    <ul class="list-group mb-0 p-15">
                                                                        <li class="list-group-item">
                                                                            <strong>Metodos de Riego:</strong>
                                                                            <span class="pull-right">{{$metodos[$planificacion['metodos_riego']]}}</span>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <strong>Comportamineto de lluvia:</strong>
                                                                            <span class="pull-right">{{$planificacion['comportamiento_lluvia']}} %</span>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <strong>Problemas de Drenaje:</strong>
                                                                            <span class="pull-right">{{$planificacion['problemas_drenaje']}} %</span>
                                                                        </li>
                                                                    </ul>
                                                                @else
                                                                    <ul class="list-group mb-0 p-15">
                                                                        <li class="list-group-item">
                                                                            <strong>Preventivo Plagas:</strong>
                                                                            <span class="pull-right">{{$planificacion['preventivo_plagas']}} %</span>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <strong>Control Malezas:</strong>
                                                                            <span class="pull-right">{{$planificacion['control_malezas']}} %</span>
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            <strong>Control Enfermedades:</strong>
                                                                            <span class="pull-right">{{$planificacion['control_enfermedades']}} %</span>
                                                                        </li>
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No hay planificaciones de riegos y fumigaciones.</p>
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
                                            <div id="chartCosecha" style="height: 400px;">
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
                                <div class="tab-pane" id="tabEstimacion">
                                    <h2 class="h2-reports text-center">Estimacion de Produccion</h2>
                                    @if($estimacion['exist'])
                                        <div class="row mb-30 text-center">
                                            @for($i=0;$i<4;$i++)
                                                <div class="col-xs-3">
                                                    <div class="card{{$estimacion['rendimiento_produccion'] == $i ? ' card-selected' : '' }}" >
                                                        <div class="card-body">
                                                            @if($estimacion['rendimiento_produccion'] == $i)
                                                                <img src="{{URL::asset('img/corn'.$i.'.png')}}">
                                                            @else
                                                                <img src="{{URL::asset('img/corn'.$i.'_n.png')}}">
                                                            @endif
                                                            <h1 class="{{$estimacion['rendimiento_produccion'] == $i ? 'text-success' : 'text-muted' }}">{{$i}}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="text-center">
                                            La estimacion de produccion de maiz en base al rendimiento de
                                            <h2 class="mb-0 font-s-15"><?=$estimacion['rendimiento']?> %</h2>
                                            Se estima una produccion por hectaria de
                                            <h2 class="font-s-15 text-lowercase"><?=$estimacion['produccion_por_hectaria']?> Toneladas</h2>
                                            Un total de
                                            <h2 class="mb-0 text-lowercase"><?=$estimacion['produccion_total']; ?> Toneladas</h2>
                                        </div>
                                    @else
                                        <p>No hay una siembra y/o cosecha registrada.</p>
                                    @endif
                                </div>
                                <div class="tab-pane" id="tabCalidad">
                                    <h2 class="h2-reports text-center">Control de Calidad</h2>
                                    @if($calidad['exist'])
                                        <div class="row text-ceter mb-30">
                                            <strong class="col-xs-7 col-sm-6 text-right">Media : </strong>
                                            <span class="col-xs-5 col-sm-6 text-left">{{ $calidad['estadistico']['media'] }}</span>
                                            <strong class="col-xs-7 col-sm-6 text-right">Varianza : </strong>
                                            <span class="col-xs-5 col-sm-6 text-left">{{ $calidad['estadistico']['varianza'] }}</span>
                                            <strong class="col-xs-7 col-sm-6 text-right">Desviación Estándar : </strong>
                                            <span class="col-xs-5 col-sm-6 text-left">{{ $calidad['estadistico']['desviacion_estandar'] }}</span>
                                        </div>
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
                                            <div id="chartCalidad" style="height: 400px;">
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
                                                var datom = [
                                                    {
                                                        values: [{x:0, y:5}, {x:100, y:5}],
                                                        key: 'No Certificado',
                                                        color: '#E74C3C'
                                                    },
                                                    {
                                                        values: [{x:0, y:7.5}, {x:100, y:7.5}],
                                                        key: 'Registrado',
                                                        color: '#2980B9'
                                                    },
                                                    {
                                                        values: [{x:0, y:10}, {x:100, y:10}],
                                                        key: 'Certificado',
                                                        color: '#27AE60'
                                                    }
                                                ];

                                                nv.addGraph(function() {
                                                    var chartBar = nv.models.lineChart();
                                                    chartBar.legend.updateState(false)
                                                    chartBar.showXAxis(false)
                                                    chartBar.showYAxis(false)
                                                    chartBar.yDomain([0,12])

                                                    d3.select('#chartCalidad svg')
                                                        .datum(datom)
                                                        .transition().duration(500)
                                                        .call(chartBar)
                                                    ;

                                                    var chartBar = nv.models.discreteBarChart()
                                                        .x(function(d) { return d.label })
                                                        .y(function(d) { return d.value })
                                                        .yDomain([0,12])
                                                        .staggerLabels(true)
                                                        .showValues(true)
                                                        .duration(250)
                                                    ;

                                                    d3.select('#chartCalidad svg')
                                                        .datum(historicalBarChart)
                                                        .call(chartBar);

                                                    nv.utils.windowResize(chartBar.update);
                                                    return chartBar;
                                                });
                                            }
                                        </script>
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
