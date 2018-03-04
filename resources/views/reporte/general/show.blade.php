@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Reporte de Estados</h2>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Datos del Proceso de Produccion</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                @if (isset($success))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $success }}
                    </div>
                @endif
                @if (isset($error))
                    <div class="alert alert-danger">
                        <strong>¡Error! </strong>{{ $error }}
                    </div>
                @endif
                <style>
                    .card {
                        position: relative;
                        display: -webkit-box;
                        display: -webkit-flex;
                        display: -ms-flexbox;
                        display: flex;
                        -webkit-box-orient: vertical;
                        -webkit-box-direction: normal;
                        -webkit-flex-direction: column;
                        -ms-flex-direction: column;
                        flex-direction: column;
                        background-color: #fff;
                        border: 1px solid rgba(0,0,0,.125);
                        border-radius: .25rem;
                    }
                    .card-header:first-child {
                        border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
                    }

                    .card-header {
                        padding: .75rem 1.25rem;
                        margin-bottom: 0;
                        background-color: #f7f7f9;
                        border-bottom: 1px solid rgba(0,0,0,.125);
                    }
                    .card-block {
                        -webkit-box-flex: 1;
                        -webkit-flex: 1 1 auto;
                        -ms-flex: 1 1 auto;
                        flex: 1 1 auto;
                        padding: 1.25rem;
                    }
                    .mb-0 {
                        margin-bottom: 0!important;
                    }
                    .click-div {
                        display: block;
                        color: #222222;
                    }

                    .click-div:hover, .click-div:focus {
                        color: #222222;
                        text-decoration: none;
                    }
                    .no-border-bottom {
                        margin-bottom: 0px;
                    }
                </style>
                {{--<script src="{{URL::asset('assets/js/jquery-1.11.1.min.js')}}"></script>--}}
                {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
                {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
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
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <?php
                            $count_riegos = 0;
                            $count_fumigaciones = 0;
                            $text_riego = ['Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto'];
                            $text_fumigacion = ['Primera', 'Segunda', 'Tercera'];
                        ?>
                        @if($simuladors->count() % 2 == 1)
                            <script src="{{URL::asset('assets/bootstrap/js/bootstrap-collapse.js')}}"></script>
                        @endif
                        @foreach ($simuladors as $simulador)
                            <div class="card">
                                <div class="card-header" role="tab" id="heading{{$simulador['id']}}">
                                    <h5 class="mb-0">
                                        <a class="collapsed click-div" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$simulador['id']}}" aria-expanded="false" aria-controls="collapse{{$simulador['id']}}">
                                            @if($simulador['tipo'] == "Riego")
                                                {{$text_riego[$count_riegos]." ".$simulador['tipo']}}<span style="float: right;text-transform: none;">{{ date('H:i a - d/m/Y', strtotime($simulador['planificacionriego']['fecha_planificacion'])) }}</span>
                                                <?php $count_riegos++; ?>
                                            @elseif($simulador['tipo'] == "Fumigacion")
                                                {{$text_fumigacion[$count_fumigaciones]." ".$simulador['tipo']}}<span style="float: right;text-transform: none;">{{ date('H:i a - d/m/Y', strtotime($simulador['planificacionfumigacion']['fecha_planificacion'])) }}</span>
                                                <?php $count_fumigaciones++; ?>
                                            @else
                                                {{$simulador['tipo']}}<span style="float: right;">{{ date('d/m/Y', strtotime($simulador['created_at'])) }}</span>
                                            @endif
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse{{$simulador['id']}}" class="collapse collapse-chart" role="tabpanel" aria-labelledby="heading{{$simulador['id']}}" aria-expanded="false" style="height: 0px;">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <table class="table table-sm">
                                                    <thead>
                                                    <tr>
                                                        <th>Dato</th>
                                                        <th class="text-right">Valor</th>
                                                    </tr>
                                                    </thead>
                                                    @if($simulador['tipo'] == "Preparacion")
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Acidez / Alcalinidad</th>
                                                            <td class="text-right">{{$simulador['preparacionterreno']['ph']}}<strong> pH</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Plaga Suelo</th>
                                                            <td class="text-right">{{$simulador['preparacionterreno']['plaga_suelo']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Drenaje</th>
                                                            <td class="text-right">{{$simulador['preparacionterreno']['drenage']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Erocion</th>
                                                            <td class="text-right">{{$simulador['preparacionterreno']['erocion']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Maleza Preparacion</th>
                                                            <td class="text-right">{{$simulador['preparacionterreno']['maleza_preparacion']}}<strong> %</strong></td>
                                                        </tr>
                                                        </tbody>
                                                    @elseif($simulador['tipo'] == "Siembra")
                                                        <?php $semillas = ['None', 'No Certificada', 'Certificada', 'Registrada', 'Basica']?>
                                                        <?php $fertilizaciones = ['Fertiliacion no Correcta', 'Fertilizacion Correcta']?>
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Semilla</th>
                                                            <td class="text-right">{{$semillas[$simulador['siembra']['semilla']]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Fertilizacion</th>
                                                            <td class="text-right">{{$fertilizaciones[$simulador['siembra']['fertilizacion']]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Distancia surco</th>
                                                            <td class="text-right">{{$simulador['siembra']['distancia_surco']}}<strong> cm</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Distancia planta</th>
                                                            <td class="text-right">{{$simulador['siembra']['distancia_planta']}}<strong> cm</strong></td>
                                                        </tr>
                                                        </tbody>
                                                    @elseif($simulador['tipo'] == "Riego")
                                                        <?php $metodos = ['None', 'Lluvia', 'Pozo de riego']?>
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Metodos de Riego</th>
                                                            <td class="text-right">{{$metodos[$simulador['planificacionriego']['metodos_riego']]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Comportamineto de lluvia</th>
                                                            <td class="text-right">{{$simulador['planificacionriego']['comportamiento_lluvia']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Problemas de Drenaje</th>
                                                            <td class="text-right">{{$simulador['planificacionriego']['problemas_drenaje']}}<strong> %</strong></td>
                                                        </tr>
                                                        </tbody>
                                                    @elseif($simulador['tipo'] == "Fumigacion")
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Preventivo Plagas</th>
                                                            <td class="text-right">{{$simulador['planificacionfumigacion']['preventivo_plagas']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Control Malezas</th>
                                                            <td class="text-right">{{$simulador['planificacionfumigacion']['control_malezas']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Control Enfermedades</th>
                                                            <td class="text-right">{{$simulador['planificacionfumigacion']['control_enfermedades']}}<strong> %</strong></td>
                                                        </tr>
                                                        </tbody>
                                                    @elseif($simulador['tipo'] == "Cosecha")
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Problemas de produccion</th>
                                                            <td class="text-right">{{$simulador['problemas']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Altura de tallo</th>
                                                            <td class="text-right">{{$simulador['altura']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Humedad del terreno</th>
                                                            <td class="text-right">{{$simulador['humedad']}}<strong> %</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Remdimiento de produccion</th>
                                                            <td class="text-right">{{$simulador['rendimiento']}}<strong> %</strong></td>
                                                        </tr>
                                                        </tbody>
                                                    @else
                                                    @endif
                                                </table>
                                            </div>
                                            <div class="col-sm-6">
                                                <style>
                                                    text {
                                                        font: 0.81em sans-serif !important;
                                                    }
                                                    svg {
                                                        display: block;
                                                    }
                                                    html, body, svg {
                                                        margin: 0px;
                                                        padding: 0px;
                                                        height: 100%;
                                                        width: 100% !important;
                                                    }
                                                </style>
                                                <div id="chartReport{{$simulador['id']}}" style="height: 250px;">
                                                    <svg></svg>
                                                </div>
                                                <script>
                                                    function exampleData<?=$simulador['id']?>() {
                                                        return  [
                                                            {
                                                                key: "Cumulative Return",
                                                                values: [
                                                                    {
                                                                        "label" : "Problemas de produccion",
                                                                        "value" : <?=$simulador['problemas']?>
                                                                    } ,
                                                                    {
                                                                        "label" : "Altura de tallo" ,
                                                                        "value" : <?=$simulador['altura']?>
                                                                    } ,
                                                                    {
                                                                        "label" : "Humedad del terreno" ,
                                                                        "value" : <?=$simulador['humedad']?>
                                                                    } ,
                                                                    {
                                                                        "label" : "Remdimiento de produccion" ,
                                                                        "value" : <?=$simulador['rendimiento']?>
                                                                    }
                                                                ]
                                                            }
                                                        ];
                                                    }
                                                </script>
                                                <script>
                                                    historicalBarChart = [
                                                        {
                                                            key: "Cumulative Return",
                                                            values: [
                                                                {
                                                                    "label" : "Problemas de produccion",
                                                                    "value" : <?=$simulador['problemas']?>
                                                                } ,
                                                                {
                                                                    "label" : "Altura de tallo" ,
                                                                    "value" : <?=$simulador['altura']?>
                                                                } ,
                                                                {
                                                                    "label" : "Humedad del terreno" ,
                                                                    "value" : <?=$simulador['humedad']?>
                                                                } ,
                                                                {
                                                                    "label" : "Remdimiento de produccion" ,
                                                                    "value" : <?=$simulador['rendimiento']?>
                                                                }
                                                            ]
                                                        }
                                                    ];
                                                </script>
                                                <script src="{{URL::asset('assets/bootstrap/js/bootstrap-collapse.js')}}"></script>
                                                <script>
                                                    $(".collapse").on('show.bs.collapse', function () {
                                                        nv.addGraph(function() {
                                                            chartBar = nv.models.discreteBarChart()
                                                                .x(function(d) { return d.label })
                                                                .y(function(d) { return d.value })
                                                                .staggerLabels(true)
                                                                .showValues(true)
                                                                .duration(250)
                                                            ;

                                                            d3.select('#chartReport<?=$simulador['id']?> svg')
                                                                .datum(exampleData<?=$simulador['id']?>())
                                                                .call(chartBar);

                                                            nv.utils.windowResize(chartBar.update);
                                                            return chartBar;
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
