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
                                <div class="col-lg-6 col-md-12">
                                    <center>
                                        <h2 class="h2-reports">Siembra</h2>
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
                                    <script>
                                        historicalBarChart = [
                                            {
                                                key: "Cumulative Return",
                                                values: [
                                                    {
                                                        "label" : "Semilla" ,
                                                        "value" : <?=$siembra['semilla']?>
                                                    } ,
                                                    {
                                                        "label" : "Fertilizacion" ,
                                                        "value" : <?=$siembra['fertilizacion']?>
                                                    } ,
                                                    {
                                                        "label" : "Densidad de la siembra" ,
                                                        "value" : <?=$siembra['densidad_siembra']?>
                                                    }
                                                ]
                                            }
                                        ];
                                    </script>
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
                                        @foreach ($riego_lista as $riego_one)
                                            <tr style="background: rgba(0, 38, 255, 0.29);">
                                                <td style="text-align: center">Riego</td>
                                                <td style="text-align: center">{{$riego_one['fecha_planificacion']}}</td>
                                                <td style="text-align: center">{{$riego_one['estado']}}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($fumigacion_lista as $fumigacion_one)
                                            <tr style="background: #cea4de;">
                                                <td style="text-align: center">Fumigacion</td>
                                                <td style="text-align: center">{{$fumigacion_one['fecha_planificacion']}}</td>
                                                <td style="text-align: center">{{$fumigacion_one['estado']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
