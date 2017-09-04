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
                                <i class="fa fa-btn fa-user"></i> Cargar Fumigaciones
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Fumigaciones Planificadas</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($siembra_id))
                        @if (isset($band))
                            <center>

                                <div class="skills">
                                    <div class="col-sm-6 col-md-3 col-md-offset-2 text-center">
                                        <span data-percent="{{ $riego }}" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                                            <span class="percent">{{ $riego }}</span>
                                        </span>
                                        <h3 class="text-center">Riego</h3>
                                        @if (isset($planificacionriegonext) and $planificacionriegonext != False)
                                            <p><strong>Fecha del siguiente riego</strong><br>{{ $planificacionriegonext[0]['fecha_planificacion'] }}</p>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-md-offset-2 text-center">
                                        <span data-percent="{{ $fumigacion }}" class="chart easyPieChart" style="barColor:black; width: 140px; height: 140px; line-height: 140px;">
                                            <span class="percent">{{ $fumigacion }}</span>
                                        </span>
                                        <h3 class="text-center">Fumigacion</h3>
                                        @if (isset($planificacionfumigacionnext) and $planificacionfumigacionnext != False)
                                            <p><strong>Fecha de la siguiente fumigacion</strong><br>{{ $planificacionfumigacionnext[0]['fecha_planificacion'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                <br><br><br><br><br>
                                <h2>Siembra</h2>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">Dato</th>
                                        <th style="text-align: center">Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center">Semilla</td>
                                            <td style="text-align: center">{{$siembra['semilla']}}</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center">Fertilizacion</td>
                                            <td style="text-align: center">{{$siembra['fertilizacion']}}</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center">Densidad de la siembra</td>
                                            <td style="text-align: center">{{$siembra['densidad_siembra']}}</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center">Comentario</td>
                                            <td style="text-align: center">{{$siembra['comentario_siembra']}}</td>
                                        </tr>
                                    </tbody>
                                </table>

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
                            <div id="chart1">
                                <svg></svg>
                            </div>
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
