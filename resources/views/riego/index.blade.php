@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Riego</h2>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Riegos Planificados</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($siembra_id))
                        @if (isset($riego_id))
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Fecha</th>
                                    <th style="text-align: center">Estado</th>
                                    <th style="text-align: center">Opcion</th>
                                    <th style="text-align: center">Problemas</th>
                                    <th style="text-align: center">Altura</th>
                                    <th style="text-align: center">Humedad</th>
                                    <th style="text-align: center">Rendimiento</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($siembra)){
                                    $ph = $siembra['preparacionterreno']['ph'];
                                    $plaga_suelo = $siembra['preparacionterreno']['plaga_suelo'];
                                    $drenage = $siembra['preparacionterreno']['drenage'];
                                    $erocion = $siembra['preparacionterreno']['erocion'];
                                    $maleza_preparacion = $siembra['preparacionterreno']['maleza_preparacion'];
                                    $semilla = $siembra['semilla'];
                                    $fertilizacion = $siembra['fertilizacion'];

                                    $acum_comportamiento_lluvia = 0;
                                    $acum_problemas_drenaje = 0;
                                    $cont_riegos = 0;
                                    $cont_riegos_total = 0;
                                }
                                ?>
                                <script>
                                    var simulador_2 = 0;
                                    var simulador_problemas_2 = 0;
                                    var simulador_altura_2 = 0;
                                    var simulador_humedad_2 = 0;
                                    var simulador_rendimiento_2 = 0;
                                </script>
                                <?php $numero_simulacion = 0;?>
                                @foreach ($planificacionriegos as $id => $planificacionriego)
                                    @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['id'] == $planificacionriego['id'] and $planificacionriego['estado'] == "Registrado")
                                        <script>
                                            var simulador_2 = 1;
                                            var simulador_problemas_2 = <?=round($planificacionriego['simulador']['problemas'], 2)?>;
                                            var simulador_altura_2 = <?=round($planificacionriego['simulador']['altura'], 2)?>;
                                            var simulador_humedad_2 = <?=round($planificacionriego['simulador']['humedad'], 2)?>;
                                            var simulador_rendimiento_2 = <?=round($planificacionriego['simulador']['rendimiento'], 2)?>;
                                        </script>
                                        <?php $numero_simulacion = $planificacionriego['simulador']['numero_simulacion'];?>
                                    @endif
                                    <tr @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['id'] == $planificacionriego['id']) style="background: rgba(202, 202, 224, 0.58);" @endif>
                                        <td style="text-align: center">{{$planificacionriego['fecha_planificacion']}}</td>
                                        <td style="text-align: center">{{$planificacionriego['estado']}}</td>
                                        <td style="text-align: center">
                                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/riegos/create') }}">
                                            {{ csrf_field() }}
                                                <input type="hidden" name="planificacionriego_id" value="{{$planificacionriego['id']}}" >
                                                <input type="hidden" name="siembra_id" value="{{$siembra_id}}" >
                                                <button type="submit" class="btn btn-primary btn-xs" @if ($planificacionriego['estado'] != 'Ejecutado' and $planificacionriego['estado'] != 'Registrado') disabled @endif>
                                                    <i class="fa fa-btn fa-pencil"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <?php $ls_numero_simulacion = $planificacionriego['simulador']['numero_simulacion'];?>
                                        @foreach ($simulador as $simulacion)
                                            @if ($simulacion['numero_simulacion'] == ($ls_numero_simulacion - 1))
                                                <td style="text-align: center"><?=round($simulacion['problemas'], 2)?> %</td>
                                                <td style="text-align: center"><?=round($simulacion['altura'], 2)?> %</td>
                                                <td style="text-align: center"><?=round($simulacion['humedad'], 2)?> %</td>
                                                <td style="text-align: center"><?=round($simulacion['rendimiento'], 2)?> %</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <?php
                                        if($planificacionriego['estado'] == 'Registrado'){
                                            $acum_comportamiento_lluvia += $planificacionriego['comportamiento_lluvia'];
                                            $acum_problemas_drenaje += $planificacionriego['problemas_drenaje'];
                                            $cont_riegos += 1;
                                        }
                                        $cont_riegos_total += 1;
                                    ?>
                                @endforeach
                                </tbody>
                            </table>
                            @if (!isset($planificacionriego_done))
                            <center>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" @if($planificacionriegos->count() >= 5) disabled @endif>
                                    <i class="fa fa-btn fa-user"></i> Añadir Planificacion
                                </button>
                            </center>
                            @endif
                            @if (isset($planificacionriego_done))
                            <div class="row">
                                <div class="col-lg-6 col-md-5">
                                    <center>
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/riegos') }}">
                                        {{ csrf_field() }}
    
                                        <div class="form-group">
                                            <label for="metodos_riego" class="col-md-4 control-label">Metodos de riego</label>
                                            <div class="col-md-6">
                                                <select id="metodos_riego" name="metodos_riego" class="form-control">
                                                    <option value="1" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '1') selected @endif >Lluvia</option>
                                                    <option value="2" @if (isset($planificacionriego_done['metodos_riego']) and $planificacionriego_done['metodos_riego'] == '2') selected @endif >Pozo de riego</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="comportamiento_lluvia" class="col-md-4 control-label">Comportamiento de lluvia (%)</label>
                                            <div class="col-md-6">
                                                <input type="number" min="1" max="100" step="0.01" id="comportamiento_lluvia" name="comportamiento_lluvia" class="form-control" @if (isset($planificacionriego_done['comportamiento_lluvia'])) value="{{ $planificacionriego_done['comportamiento_lluvia'] or '0.00' }}" @endif style="text-align:right" onchange="updateBarchar()"/>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="problemas_drenaje" class="col-md-4 control-label">Drenaje (%)</label>
                                            <div class="col-md-6">
                                                <input type="number" min="1" max="100" step="0.01" id="problemas_drenaje" name="problemas_drenaje" class="form-control" @if (isset($planificacionriego_done['problemas_drenaje'])) value="{{ $planificacionriego_done['problemas_drenaje'] or '0.00' }}" @endif style="text-align:right" onchange="updateBarchar()"/>
                                            </div>
                                        </div>
    
                                        <div class="form-group{{ $errors->has('comentario_riego') ? ' has-error' : '' }}">
                                            <label for="comentario_riego" class="col-md-4 control-label">Observacion</label>
                                            <div class="col-md-6">
                                                <input id="comentario_riego" type="text" class="form-control" name="comentario_riego" value="{{ $planificacionriego_done['comentario_riego'] or old('comentario_riego') }}">
                                                @if ($errors->has('comentario_riego'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('comentario_riego') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
    
                                        <input type="hidden" name="planificacionriego_id" value="{{ $planificacionriego_done['id'] }}" >
                                        <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                                        <input type="hidden" name="preparacionterreno_id" value="{{ $siembra['preparacionterreno']['id'] }}" >

                                        <input type="hidden" name="simulador_problemas" id="simulador_problemas" value="">
                                        <input type="hidden" name="simulador_altura" id="simulador_altura" value="">
                                        <input type="hidden" name="simulador_humedad" id="simulador_humedad" value="">
                                        <input type="hidden" name="simulador_rendimiento" id="simulador_rendimiento" value="">
    
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-user"></i> Registrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </center>
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
                                        .preterreno{
                                            text-align: center;
                                            font-weight: bold;
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

                                            var ph_ini = <?=$ph?>;
                                            var fertilizacion = <?=$fertilizacion?>;
                                            var ph_aux = ((7 - ph_ini) * fertilizacion) + ph_ini
                                            var ph = 10 - (Math.abs(ph_aux - 7) / 0.7);

                                            var drenage = <?=$drenage?> / 10;
                                            var comportamiento_lluvia = document.getElementById("comportamiento_lluvia").value / 10;
                                            var problemas_drenaje = document.getElementById("problemas_drenaje").value / 10;

                                            var acum_comportamiento_lluvia = <?=$acum_comportamiento_lluvia?> / 10;
                                            var acum_problemas_drenaje = <?=$acum_problemas_drenaje?> / 10;
                                            var cont_riegos = <?=$cont_riegos?>;
                                            var $cont_riegos_total = <?=$cont_riegos_total?>;

                                            if(cont_riegos != $cont_riegos_total){
                                                drenage = (drenage + acum_comportamiento_lluvia + acum_problemas_drenaje + comportamiento_lluvia + problemas_drenaje) / ((cont_riegos * 2) + 3);
                                            }else{
                                                drenage = (drenage + acum_comportamiento_lluvia + acum_problemas_drenaje) / ((cont_riegos * 2) + 1);
                                            }

                                            var plaga_suelo = 10 - (<?=$plaga_suelo?> / 10);
                                            var maleza_preparacion = 10 - (<?=$maleza_preparacion?> / 10);
                                            var erocion = <?=$erocion?> / 10;

                                            var semilla = <?=$semilla?> * 2.5;
                                            var enfermedades = 7.5;

                                            var simulador_problemas = 100 - (100/475) * (((100/10)*ph)+((50/10)*drenage)+((100/10)*plaga_suelo)+((65/10)*maleza_preparacion)+((100/10)*enfermedades)+((60/10)*erocion));
                                            var simulador_altura = (100/290) * (((90/10)*ph)+((60/10)*drenage)+((20/10)*enfermedades)+((30/10)*erocion)+((90/10)*semilla));
                                            var simulador_humedad = (100/145) * (((100/10)*drenage)+((45/10)*maleza_preparacion));
                                            var simulador_rendimiento = (100/535) * (((100/10)*ph)+((75/10)*drenage)+((100/10)*enfermedades)+((100/10)*plaga_suelo)+((30/10)*maleza_preparacion)+((50/10)*semilla)+((80/10)*erocion));

                                            if (simulador_2 == 1){
                                                simulador_problemas = simulador_problemas_2;
                                                simulador_altura = simulador_altura_2;
                                                simulador_humedad = simulador_humedad_2;
                                                simulador_rendimiento = simulador_rendimiento_2;
                                            }
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
                                <div class="row">
                                    <?php $datos = [];?>
                                    <?php
                                        if(isset($simulador)){
                                            if($numero_simulacion != 0){
                                                for($i=0;$i<=$numero_simulacion-1;$i++){
                                                    $datos[$i][0] = $simulador[$i]['tipo'];
                                                    $datos[$i][1] = $simulador[$i]['problemas'];
                                                    $datos[$i][2] = $simulador[$i]['altura'];
                                                    $datos[$i][3] = $simulador[$i]['humedad'];
                                                    $datos[$i][4] = $simulador[$i]['rendimiento'];
                                                }
                                            }
                                        }
                                    ?>
                                    <?php $datos = json_encode($datos);?>
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
                                                .axisLabel("Etapas en la Cosecha")
                                                .tickFormat(d3.format(',.1f'))
                                                .staggerLabels(true)
                                                .tickValues(['Label 1','Label 2','Label 3','Label 4','Label 5','Label 6','Label 7','Label 8'])
                                            ;

                                            var tipo = [];
                                            for (var i = 0; i < datos.length; i++) {
                                                tipo.push(datos[i][0]);
                                            }

                                            chart.xAxis.tickValues([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15])
                                                .tickFormat(function(d){
                                                    return tipo[d]
                                                });

                                            chart.yAxis
                                                .axisLabel('Medida (Porcentaje)')
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
                                                sin.push({x: i, y: datos[i][1] });
                                                cos.push({x: i, y: datos[i][2] });
                                                rand.push({x:i, y: datos[i][3] });
                                                rand2.push({x: i, y: datos[i][4] });
                                            }
                                            return [
                                                {
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
                                            ];
                                        }
                                    </script>
                                </div>
                            @endif
                        @else
                            <center>
                                Esta siembra aun no cuenta con una planificacion de riegos<br>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-btn fa-user"></i> Iniciar Planificacion
                                </button>
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
<div class="modal fade" id="myModal" role="dialog" style="margin-top: 100px">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Planificacion de riego</h4>
            </div>
            <div class="modal-body">
                <p  style="text-align: center;">Fecha del siguiente riego.</p>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/planificacionriegos/addriego') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group">
                            <div class='col-md-10 col-md-offset-1 input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" name="fecha_planificacion" required/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (isset($siembra_id))
                            <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                            @if (isset($riego_id))
                                <input type="hidden" name="riego_id" value="{{ $riego_id }}" >
                            @else
                                <input type="hidden" name="newriego" value="True" >
                            @endif
                        @endif
                        <div class="form-group">
                            <div class="col-md-12" style="text-align: center;">
                                <div style="text-align: center;">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-btn fa-user"></i>Registar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
