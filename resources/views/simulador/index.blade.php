@extends('layouts.app')

@section('content')
    <div class="container pfblock">
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
                        <div class="row">
                            <div class="col-lg-6 col-md-5">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/siembras') }}">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <h2 class="text-center">Preparacion del terreno</h2>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ph" class="col-md-6 control-label">PH</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="drenage" class="col-md-6 control-label">Drenage</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="plaga_suelo" class="col-md-6 control-label">Plaga Suelo</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="maleza_preparacion" class="col-md-6 control-label">Maleza Preparacion</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="semilla" class="col-md-6 control-label">Semilla</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fertilizacion" class="col-md-6 control-label">Fertilizacion</label>
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
                                        <div class="col-md-12">
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

                                    {{--<div class="form-group">--}}
                                        {{--<div class="text-center">--}}
                                            {{--<button type="submit" class="btn btn-lg">--}}
                                                {{--<i class="fa fa-btn fa-bomb"></i> Simular--}}
                                            {{--</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </form>
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
                                </style>
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
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection