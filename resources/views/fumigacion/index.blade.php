@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administrar Fumigacion</h2>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Fumigaciones Planificadas</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($siembra_id))
                        @if (isset($fumigacion_id))
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Fecha</th>
                                    <th style="text-align: center">Estado</th>
                                    <th style="text-align: center">Detalle</th>
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
                                    $maleza_preparacion = $siembra['preparacionterreno']['maleza_preparacion'];
                                    $semilla = $siembra['semilla'];
                                    $erocion = $siembra['preparacionterreno']['erocion'];
                                    $fertilizacion = $siembra['fertilizacion'];

//                                    $ph_aux = 10 - (abs($ph - 7) / 0.7);
//                                    $plaga_suelo_aux = 10 - ($plaga_suelo / 10);
//                                    $drenage_aux = $drenage / 10;
//                                    $maleza_preparacion_aux = $maleza_preparacion / 10;
//                                    $semilla_aux = $semilla * 2.5;
//                                    $fertilizacion_aux = $fertilizacion;
                                    $acum_control_enfermedades = 0;
                                    $acum_preventivo_plagas = 0;
                                    $acum_control_malezas = 0;
                                    $cont_fumigacions = 0;
                                    $cont_fumigacions_total = 0;
                                }
                                ?>
                                <script>
                                    var simulador_2 = 0;
                                    var simulador_problemas_2 = 0;
                                    var simulador_altura_2 = 0;
                                    var simulador_humedad_2 = 0;
                                    var simulador_rendimiento_2 = 0;
                                </script>
                                @foreach ($planificacionfumigacions as $id => $planificacionfumigacion)
                                    @if (isset($planificacionfumigacion_done) and $planificacionfumigacion_done['id'] == $planificacionfumigacion['id'] and $planificacionfumigacion['estado'] == "Registrado")
                                        <script>
                                            var simulador_2 = 1;
                                            var simulador_problemas_2 = <?=round($planificacionfumigacion['simulador']['problemas'], 2)?>;
                                            var simulador_altura_2 = <?=round($planificacionfumigacion['simulador']['altura'], 2)?>;
                                            var simulador_humedad_2 = <?=round($planificacionfumigacion['simulador']['humedad'], 2)?>;
                                            var simulador_rendimiento_2 = <?=round($planificacionfumigacion['simulador']['rendimiento'], 2)?>;
                                        </script>
                                        <?php $numero_simulacion = $planificacionfumigacion['simulador']['numero_simulacion'];?>
                                    @endif
                                    <tr @if (isset($planificacionfumigacion_done['id']) and $planificacionfumigacion_done['id'] == $planificacionfumigacion['id']) style="background: rgba(202, 202, 224, 0.58);" @endif>
                                        <td style="text-align: center">{{ date('d/m/Y \a \l\a\s H:i', strtotime($planificacionfumigacion['fecha_planificacion'])) }}</td>
                                        <td style="text-align: center">{{$planificacionfumigacion['estado']}}</td>
                                        <td style="text-align: center">
                                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/fumigacions/create') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="planificacionfumigacion_id" value="{{$planificacionfumigacion['id']}}" >
                                                <input type="hidden" name="siembra_id" value="{{$siembra_id}}" >
                                                <button type="submit" class="btn btn-primary btn-xs" @if ($planificacionfumigacion['estado'] != 'Ejecutado' and $planificacionfumigacion['estado'] != 'Registrado') disabled @endif>
                                                    <i class="fa fa-btn fa-pencil"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <?php $ls_numero_simulacion = $planificacionfumigacion['simulador']['numero_simulacion'];?>
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
                                    if($planificacionfumigacion['estado'] == 'Registrado'){
                                        $acum_control_enfermedades += $planificacionfumigacion['control_enfermedades'];
                                        $acum_preventivo_plagas += $planificacionfumigacion['preventivo_plagas'];
                                        $acum_control_malezas += $planificacionfumigacion['control_malezas'];
                                        $cont_fumigacions += 1;
                                    }
                                    $cont_fumigacions_total += 1;
                                    ?>
                                @endforeach
                                </tbody>
                            </table>
                            @if (!isset($planificacionfumigacion_done))
                            <center>
                                <style>
                                    .button-planification{
                                        float:right;
                                    }
                                </style>
                                <button type="button" class="btn btn-primary button-planification" data-toggle="modal" data-target="#myModal" @if($planificacionfumigacions->count() >= 3) disabled @endif>
                                    Añadir Planificacion
                                </button>
                                @if (isset($fumigacion_id))
                                    <form action="{{ url('fumigacions')}}/{{$fumigacion_id}}" method="post" class="button-planification">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="PUT" >
                                        <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                                        <button class="btn btn-danger" type="submit">
                                            Finalizar Planificacion
                                        </button>
                                    </form>
                                @endif
                            </center>
                            @endif
                            @if (isset($planificacionfumigacion_done))
                            <div class="row">
                                <div class="col-lg-6 col-md-5">
                                    <center>
                                    <form class="form-horizontal" role="form" method="POST"  id="form_fumigacion" action="{{ url('/fumigacions') }}">
                                        {{ csrf_field() }}
    
                                        <div class="form-group">
                                            <label for="preventivo_plagas" class="col-md-5 control-label">Preventivo Plagas</label>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="number" min="1" max="100" id="preventivo_plagas" name="preventivo_plagas" class="form-control text-right" @if (isset($planificacionfumigacion_done['preventivo_plagas'])) value="{{ $planificacionfumigacion_done['preventivo_plagas'] }}" @endif onchange="updateBarchar()" @if (isset($planificacionfumigacion_done['estado']) and $planificacionfumigacion_done['estado'] == "Registrado") readonly @endif/>
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="control_malezas" class="col-md-5 control-label">Control de Malezas</label>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="number" min="1" max="100" id="control_malezas" name="control_malezas" class="form-control text-right" @if (isset($planificacionfumigacion_done['control_malezas'])) value="{{ $planificacionfumigacion_done['control_malezas'] }}" @endif onchange="updateBarchar()" @if (isset($planificacionfumigacion_done['estado']) and $planificacionfumigacion_done['estado'] == "Registrado") readonly @endif/>
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="control_enfermedades" class="col-md-5 control-label">Control de Enfermedades</label>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="number" min="1" max="100" id="control_enfermedades" name="control_enfermedades" class="form-control text-right" @if (isset($planificacionfumigacion_done['control_enfermedades'])) value="{{ $planificacionfumigacion_done['control_enfermedades'] }}" @endif onchange="updateBarchar()" @if (isset($planificacionfumigacion_done['estado']) and $planificacionfumigacion_done['estado'] == "Registrado") readonly @endif/>
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="form-group{{ $errors->has('comentario_fumigacion') ? ' has-error' : '' }}">
                                            <label for="comentario_fumigacion" class="col-md-5 control-label">Comentario</label>
                                            <div class="col-md-7">
                                                <textarea id="comentario_fumigacion" name="comentario_fumigacion" class="form-control" rows="3" @if (isset($planificacionfumigacion_done['estado']) and $planificacionfumigacion_done['estado'] == "Registrado") readonly @endif>{{ $planificacionfumigacion_done['comentario_fumigacion'] or old('comentario_fumigacion') }}</textarea>
                                                @if ($errors->has('comentario_fumigacion'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('comentario_fumigacion') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
    
                                        <input type="hidden" name="planificacionfumigacion_id" value="{{ $planificacionfumigacion_done['id'] }}" >
                                        <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                                        <input type="hidden" name="preparacionterreno_id" value="{{ $siembra['preparacionterreno']['id'] }}" >

                                        <input type="hidden" name="simulador_problemas" id="simulador_problemas" value="">
                                        <input type="hidden" name="simulador_altura" id="simulador_altura" value="">
                                        <input type="hidden" name="simulador_humedad" id="simulador_humedad" value="">
                                        <input type="hidden" name="simulador_rendimiento" id="simulador_rendimiento" value="">
                                        <input type="hidden" name="confirm" id="confirm" value="false">

                                        <div class="form-group">
                                            <div class="col-md-12" style="text-align:right">
                                                <button type="submit" class="btn btn-primary" @if (isset($planificacionfumigacion_done['estado']) and $planificacionfumigacion_done['estado'] == "Registrado") disabled @endif>
                                                    Guardar
                                                </button>
                                                @if ( Auth::user()->tipo == 'Tecnico')
                                                    <input type="button" name="btn" value="Guardar y Confirmar" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-success" @if (isset($planificacionfumigacion_done['estado']) and $planificacionfumigacion_done['estado'] == "Registrado") disabled @endif/>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                    <style>
                                        #confirm_data tr td{
                                            text-align:right;
                                        }
                                    </style>
                                    <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    Confirmar datos
                                                </div>
                                                <div class="modal-body">
                                                    Los siguientes datos seran almacenados para la siguiente etapa.
                                                    <table class="table" id="confirm_data">
                                                        <tr>
                                                            <th>Preventivo Plagas</th>
                                                            <td id="m_preventivo_plagas"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Control de Malezas</th>
                                                            <td id="m_control_malezas"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Control de Enfermedades</th>
                                                            <td id="m_control_enfermedades"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Observaciones</th>
                                                            <td id="m_comentario_fumigacion"></td>
                                                        </tr>
                                                    </table>
                                                    @if($not_confirm)
                                                        <div class="has-error">
                                                    <span class="help-block">
                                                        <strong>No puedes confirmar esta planificacion de fumigacion mientras existan planificacones anteriores sin confirmar.</strong>
                                                    </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    <a href="#" id="submit" class="btn btn-success success" @if($not_confirm) disabled @endif>Confirmar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#submitBtn').click(function() {
                                            $('#m_preventivo_plagas').text($('#preventivo_plagas').val() + " %");
                                            $('#m_control_malezas').text($('#control_malezas').val() + " %");
                                            $('#m_control_enfermedades').text($('#control_enfermedades').val() + " %");
                                            $('#m_comentario_fumigacion').text($('#comentario_fumigacion').val());
                                        });

                                        $('#submit').click(function(){
                                            $('#confirm').val(true);
                                            $('#form_fumigacion').submit();
                                        });
                                    </script>
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

                                            var plaga_suelo = <?=$plaga_suelo?> / 10;
                                            var drenage = <?=$drenage?> / 10;
                                            var maleza_preparacion = <?=$maleza_preparacion?> / 10;
                                            var preventivo_plagas = document.getElementById("preventivo_plagas").value / 10;
                                            var control_malezas = document.getElementById("control_malezas").value / 10;
                                            var control_enfermedades = document.getElementById("control_enfermedades").value / 10;

                                            var acum_control_enfermedades = <?=$acum_control_enfermedades?> / 10;
                                            var acum_control_malezas = <?=$acum_control_malezas?> / 10;
                                            var acum_preventivo_plagas = <?=$acum_preventivo_plagas?> / 10;
                                            var cont_fumigacions = <?=$cont_fumigacions?>;
                                            var cont_fumigacions_total = <?=$planificacionfumigacions->count()?>;
                                            var enfermedades = 7.5;

                                            if(cont_fumigacions != cont_fumigacions_total){
                                                plaga_suelo = (plaga_suelo + acum_preventivo_plagas + preventivo_plagas) / (cont_fumigacions + 2);
                                                maleza_preparacion = (maleza_preparacion + acum_control_malezas + control_malezas) / (cont_fumigacions + 2);
                                                enfermedades = (acum_control_enfermedades + control_enfermedades)/ (cont_fumigacions + 1);
                                            }else{
                                                plaga_suelo = (plaga_suelo + acum_preventivo_plagas) / (cont_fumigacions + 1);
                                                maleza_preparacion = (maleza_preparacion + acum_control_malezas) / (cont_fumigacions + 1);
                                                if(cont_fumigacions_total != 0)
                                                {
                                                    enfermedades = acum_control_enfermedades / cont_fumigacions;
                                                }
                                            }

                                            var erocion = <?=$erocion?> / 10;
                                            var semilla = <?=$semilla?> * 2.5;

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
                            @endif
                        @else
                            <center>
                                Esta siembra aun no cuenta con una planificacion de fumigacion<br>
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
    <script>
        function validar(f){
            f.enviar.disabled=true;
            return true}
    </script>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Planificacion de riego</h4>
            </div>
            <div class="modal-body">
                <p  style="text-align: center;">Fecha de la siguiente fumigacion.</p>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/planificacionfumigacions/addriego') }}" onsubmit="return validar(this)">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group">
                            <div class='col-md-10 col-md-offset-1 input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" name="fecha_planificacion"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (isset($siembra_id))
                            <input type="hidden" name="siembra_id" value="{{ $siembra_id }}" >
                            @if (isset($fumigacion_id))
                                <input type="hidden" name="fumigacion_id" value="{{ $fumigacion_id }}" >
                            @else
                                <input type="hidden" name="newriego" value="True" >
                            @endif
                        @endif
                        <div class="form-group">
                            <div class="col-md-12" style="text-align: center;">
                                <div style="text-align: center;">
                                    <button name="enviar" type="submit" class="btn btn-success">
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
