@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Simulador</h2>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Datos de simulacion</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/siembras') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <h2 class="text-center">Preparacion del terreno</h2>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="ph" class="col-md-4 control-label">PH</label>
                                    <div class="col-md-6">
                                        <select id="ph" name="ph" class="form-control" onchange="updateBarchar()">
                                            <option value="1" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['ph']) and $preterreno[0]['ph'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="drenage" class="col-md-4 control-label">Drenage</label>
                                    <div class="col-md-6">
                                        <select id="drenage" name="drenage" class="form-control" onchange="updateBarchar()">
                                            <option value="1" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['drenage']) and $preterreno[0]['drenage'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="plaga_suelo" class="col-md-4 control-label">Plaga Suelo</label>
                                    <div class="col-md-6">
                                        <select id="plaga_suelo" name="plaga_suelo" class="form-control" onchange="updateBarchar()">
                                            <option value="1" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['plaga_suelo']) and $preterreno[0]['plaga_suelo'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="maleza_preparacion" class="col-md-4 control-label">Maleza Preparacion</label>
                                    <div class="col-md-6">
                                        <select id="maleza_preparacion" name="maleza_preparacion" class="form-control" onchange="updateBarchar()">
                                            <option value="1" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '1') selected @endif >1</option>
                                            <option value="2" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '2') selected @endif >2</option>
                                            <option value="3" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '3') selected @endif >3</option>
                                            <option value="4" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '4') selected @endif >4</option>
                                            <option value="5" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '5') selected @endif >5</option>
                                            <option value="6" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '6') selected @endif >6</option>
                                            <option value="7" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '7') selected @endif >7</option>
                                            <option value="8" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '8') selected @endif >8</option>
                                            <option value="9" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '9') selected @endif >9</option>
                                            <option value="10" @if (isset($preterreno[0]['maleza_preparacion']) and $preterreno[0]['maleza_preparacion'] == '10') selected @endif >10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h2 class="text-center">Siembra</h2>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="semilla" class="col-md-4 control-label">Semilla</label>
                                    <div class="col-md-6">
                                        <select id="semilla" name="semilla" class="form-control" onchange="updateBarchar()">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fertilizacion" class="col-md-4 control-label">Fertilizacion</label>
                                    <div class="col-md-6">
                                        <select id="fertilizacion" name="fertilizacion" class="form-control" onchange="updateBarchar()">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="densidad_siembra" class="col-md-6 control-label">Densidad de la Siembra</label>
                                    <div class="col-md-6">
                                        <select id="densidad_siembra" name="densidad_siembra" class="form-control" onchange="updateBarchar()">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h2 class="text-center">Planificaciones</h2>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="planificacion_riego" class="col-md-4 control-label">Cantidad de Riegos</label>
                                    <div class="col-md-6">
                                        <select id="planificacion_riego" name="planificacion_riego" class="form-control" onchange="updateBarchar()">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="planificacion_fumigacion" class="col-md-4 control-label">Camtidad de fumigaciones</label>
                                    <div class="col-md-6">
                                        <select id="planificacion_fumigacion" name="planificacion_fumigacion" class="form-control" onchange="updateBarchar()">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg">
                                    <i class="fa fa-btn fa-bomb"></i> Simular
                                </button>
                            </div>
                        </div>
                    </form>

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
                    {{--<div id="chart0" style="height: 500px;"></div>--}}
                    {{--<div class="text-center">--}}
                        {{--<button onclick="randomizeFillOpacity();">Randomize fill opacity</button>--}}
                    {{--</div>--}}
                    <div id="chart1" style="height: 350px; width: 500px">
                        <svg></svg>
                    </div>
                    <script>
                        var chartBar;
                        historicalBarChart = [
                            {
                                key: "Cumulative Return",
                                values: [
                                    {
                                        "label" : "Problemas de produccion" ,
                                        "value" : Math.random(1,10)
                                    } ,
                                    {
                                        "label" : "Altura de tallo" ,
                                        "value" : Math.random(1,10)
                                    } ,
                                    {
                                        "label" : "Humedad del terreno" ,
                                        "value" : Math.random(1,10)
                                    } ,
                                    {
                                        "label" : "Remdimiento de produccion" ,
                                        "value" : Math.random(1,10)
                                    }
                                ]
                            }
                        ];
                    </script>
                    <script>
                        // Wrapping in nv.addGraph allows for '0 timeout render', stores rendered charts in nv.graphs, and may do more in the future... it's NOT required
                        var chart;
                        var data;

                        function updateBarchar(){
                            var ph = document.getElementById("ph").value;
                            var drenage = document.getElementById("drenage").value;
                            var fertilizacion = document.getElementById("fertilizacion").value;
                            var plaga_suelo = document.getElementById("plaga_suelo").value;
                            var maleza_preparacion = document.getElementById("maleza_preparacion").value;
                            var semilla = document.getElementById("semilla").value;
                            var densidad_siembra = document.getElementById("densidad_siembra").value;

                            historicalBarChart[0].values[0].value = (100/330) * (((100/10)*ph)+((50/10)*drenage)+((95/10)*plaga_suelo)+((60/10)*maleza_preparacion)+((25/10)*densidad_siembra));
                            historicalBarChart[0].values[1].value = (100/365) * (((90/10)*ph)+((60/10)*drenage)+((55/10)*fertilizacion)+((50/10)*maleza_preparacion)+((90/10)*semilla)+((20/10)*densidad_siembra));
                            historicalBarChart[0].values[2].value = (100/200) * (((95/10)*drenage)+((45/10)*maleza_preparacion)+((60/10)*densidad_siembra));
                            historicalBarChart[0].values[3].value = (100/495) * (((90/10)*ph)+((75/10)*drenage)+((65/10)*fertilizacion)+((50/10)*plaga_suelo)+((40/10)*maleza_preparacion)+((100/10)*semilla)+((75/10)*densidad_siembra));

                            chartBar.update();
                        }

                        var randomizeFillOpacity = function() {
                            var rand = Math.random(0,1);
                            for (var i = 0; i < 100; i++) {
                                data[4].values[i].y = Math.sin(i/(5 + rand)) * .4 * rand - .25;
                            }
                            data[4].fillOpacity = rand;
                            chart.update();
                            for (var i = 0; i < 4; i++) {
                                historicalBarChart[0].values[i].value = (Math.random() + 0.01) * 10;
                            }
                            chartBar.update();
                        };

                        nv.addGraph(function() {
                            chart = nv.models.lineChart()
                                .options({
                                    duration: 300,
                                    useInteractiveGuideline: true
                                })
                            ;

                            // chart sub-models (ie. xAxis, yAxis, etc) when accessed directly, return themselves, not the parent chart, so need to chain separately
                            chart.xAxis
                                .axisLabel("Tiempo (dias)")
                                .tickFormat(d3.format(',.1f'))
                                .staggerLabels(true)
                            ;

                            chart.yAxis
                                .axisLabel('Medida (valor)')
                                .tickFormat(function(d) {
                                    if (d == null) {
                                        return 'N/A';
                                    }
                                    return d3.format(',.2f')(d);
                                })
                            ;

                            data = sinAndCos();

                            d3.select('#chart0').append('svg')
                                .datum(data)
                                .call(chart);

                            nv.utils.windowResize(chart.update);

                            return chart;
                        });

                        function sinAndCos() {
                            var sin = [],
                                sin2 = [],
                                cos = [],
                                rand = [],
                                rand2 = []
                            ;

                            for (var i = 0; i < 100; i++) {
                                sin.push({x: i, y: i % 10 == 5 ? null : Math.sin(i/10) }); //the nulls are to show how defined works
                                sin2.push({x: i, y: Math.sin(i/5) * 0.4 - 0.25});
                                cos.push({x: i, y: .5 * Math.cos(i/10)});
//                                rand.push({x:i, y: Math.random() / 10});
                                rand.push({x:i, y: 1});
                                rand2.push({x: i, y: Math.cos(i/10) + Math.random() / 10 })
                            }

                            return [
                                {
                                    area: true,
                                    values: sin,
                                    key: "Problemas de produccion",
                                    color: "#ff7f0e",
                                    strokeWidth: 4,
                                    classed: 'dashed'
                                },
                                {
                                    values: cos,
                                    key: "Altura de tallo",
                                    color: "#2ca02c"
                                },
                                {
                                    values: rand,
                                    key: "Humedad del terreno",
                                    color: "#2222ff"
                                },
                                {
                                    values: rand2,
                                    key: "Remdimiento de produccion",
                                    color: "#667711",
                                    strokeWidth: 3.5
                                },
                                {
                                    area: true,
                                    values: sin2,
                                    key: "Comentario",
                                    color: "#EF9CFB",
                                    fillOpacity: .1
                                }
                            ];
                        }

                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
