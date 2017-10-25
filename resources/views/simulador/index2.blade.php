@extends('layouts.app')

@section('content')
    <div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Simulador</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/simuladors2') }}">
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
                    <div id="chart0" style="height: 400px;"></div>
                    <div class="text-center">
                    </div>

                    <script>
                        var chart;
                        var data;
                        var datos = <?=$datos?>;
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
                            chart.xAxis
                                .axisLabel("Cambios)")
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
                            for (var i = 0; i < datos.length; i++) {
                                sin.push({x: i, y: datos[i][0] }); //the nulls are to show how defined works
                                sin2.push({x: i, y: datos[i][1] });
                                cos.push({x: i, y: datos[i][2] });
//                                rand.push({x:i, y: Math.random() / 10});
                                rand.push({x:i, y: datos[i][3] });
                                rand2.push({x: i, y: datos[i][4] })
                            }

                            return [
                                {
//                                    area: true,
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
//                                    area: true,
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

