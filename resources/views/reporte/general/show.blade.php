@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Reporte de Simulacion</h2>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Datos del Proceso de Produccion</div>

                <div class="panel-body">
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
                    <div class="row">
                        <?php $datos = [];?>
                        <?php
                        if(isset($simuladors)){
                            $numero_simulacion = $simuladors->count();
                            if($numero_simulacion != 0){
                                $count_riegos = 0;
                                $count_fumigaciones = 0;
                                $text_riego = ['Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto'];
                                $text_fumigacion = ['Primera', 'Segunda', 'Tercera'];
                                for($i=0;$i<=$numero_simulacion-1;$i++){
                                    if($simuladors[$i]['tipo']=="Riego"){
                                        $datos[$i][0] = $text_riego[$count_riegos]." ".$simuladors[$i]['tipo'];
                                        $count_riegos++;
                                    }elseif($simuladors[$i]['tipo']=="Fumigacion"){
                                        $datos[$i][0] = $text_fumigacion[$count_fumigaciones]." ".$simuladors[$i]['tipo'];
                                        $count_fumigaciones++;
                                    }else{
                                        $datos[$i][0] = $simuladors[$i]['tipo'];
                                    }
                                    $datos[$i][1] = $simuladors[$i]['problemas'];
                                    $datos[$i][2] = $simuladors[$i]['altura'];
                                    $datos[$i][3] = $simuladors[$i]['humedad'];
                                    $datos[$i][4] = $simuladors[$i]['rendimiento'];
                                }
                            }
                        }
                        ?>
                        <?php $datos = json_encode($datos);?>
                        <style>
                            text {
                                font: 0.61em sans-serif !important;
                            }
                            svg {
                                display: block;
                            }
                            html, body, #chart0, svg {
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
                            nv.addGraph(function() {
                                chart = nv.models.lineChart()
                                    .options({
                                        duration: 300,
                                        useInteractiveGuideline: true
                                    })
                                ;
                                chart.xAxis
                                    .axisLabel("ETAPAS DE LA PRODUCION")
                                    .axisLabelDistance(10)
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
                                    .axisLabel('VALOR (porcentaje)')
                                    .axisLabelDistance(-15)
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
                                var problemas = [],
                                    altura = [],
                                    humedad = [],
                                    rendimiento = []
                                ;
                                for (var i = 0; i < datos.length; i++) {
                                    problemas.push({x: i, y: datos[i][1] });
                                    altura.push({x: i, y: datos[i][2] });
                                    humedad.push({x:i, y: datos[i][3] });
                                    rendimiento.push({x: i, y: datos[i][4] });
                                }
                                return [
                                    {
                                        values: problemas,
                                        key: "Problemas de produccion",
                                        color: "#ff7f0e",
                                        strokeWidth: 4,
                                        classed: 'dashed'
                                    },
                                    {
                                        values: altura,
                                        key: "Altura de tallo",
                                        color: "#2ca02c"
                                    },
                                    {
                                        values: humedad,
                                        key: "Humedad del terreno",
                                        color: "#2222ff"
                                    },
                                    {
                                        values: rendimiento,
                                        key: "Remdimiento de produccion",
                                        color: "#667711",
                                        strokeWidth: 3.5
                                    },
                                ];
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
