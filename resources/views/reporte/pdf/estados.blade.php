<title>Reporte de Estados</title>
<style>
    body {
        margin: 0;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        font-size: .8rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-bordered thead th {
        border-bottom-width: 2px;
    }

    .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6;
    }

    table {
        border-collapse: collapse;
    }
    thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }
    .table td, .table th {
        padding: .75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table-sm td, .table-sm th {
        padding: .3rem;
    }

    th {
        text-align: inherit;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    .text-center{
        text-align: center !important;
    }
    .text-right{
        text-align: right !important;
    }
    .text-left{
        text-align: left !important;
    }
</style>
<h1 class="text-center">Reporte de Estados</h1>
<body>
<table class="table table-bordered table-sm">
    <thead>
    <tr>
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
    <tr>
        <th>Tecnico Responsable</th>
        <th class="text-right">Codigo del Proceso</th>
        <th class="text-right">Fecha de inicio</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$preterreno['tecnico']['nombre']}} {{$preterreno['tecnico']['apellido']}}</td>
        <td class="text-right">{{$preterreno['id']}}</td>
        <td class="text-right">{{ $preterreno['created_at']->format('d \d\e F \d\e\l Y') }}</td>
    </tr>
    </tbody>
</table>
<?php
$count_riegos = 0;
$count_fumigaciones = 0;
$text_riego = ['Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Septimo', 'Octavo'];
$text_fumigacion = ['Primera', 'Segunda', 'Tercera', 'Cuarta', 'Quinta', 'Sexta', 'Septima', 'Octaba'];
?>
<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th>Estado</th>
        <th>Datos</th>
        <th class="text-right">Fecha</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($simuladors as $simulador)
        @if($simulador['tipo'] == "Riego")
            <tr>
                <td>{{$text_riego[$count_riegos]." ".$simulador['tipo']}}</td>
                <td>
                    <?php $metodos = ['None', 'Lluvia', 'Pozo de riego']?>
                    <strong>Metodos de Riego:</strong> {{$metodos[$simulador['planificacionriego']['metodos_riego']]}}<br>
                    <strong>Comportamineto de lluvia:</strong> {{$simulador['planificacionriego']['comportamiento_lluvia']}} %<br>
                    <strong>Problemas de Drenaje:</strong> {{$simulador['planificacionriego']['problemas_drenaje']}} %
                </td>
                <td class="text-right">
                    {{ $simulador['planificacionriego']['fecha_planificacion']->format('H:i a') }}<br>
                    {{ $simulador['planificacionriego']['fecha_planificacion']->format('d \d\e F \d\e\l Y') }}
                </td>
                <?php $count_riegos++; ?>
            </tr>
        @elseif($simulador['tipo'] == "Fumigacion")
            <tr>
                <td>{{$text_fumigacion[$count_fumigaciones]." ".$simulador['tipo']}}</td>
                <td>
                    <strong>Preventivo Plagas:</strong> {{$simulador['planificacionfumigacion']['preventivo_plagas']}} %<br>
                    <strong>Control Malezas:</strong> {{$simulador['planificacionfumigacion']['control_malezas']}} %<br>
                    <strong>Control Enfermedades:</strong> {{$simulador['planificacionfumigacion']['control_enfermedades']}} %
                </td>
                <td class="text-right">
                    {{ $simulador['planificacionfumigacion']['fecha_planificacion']->format('H:i a') }}<br>
                    {{ $simulador['planificacionfumigacion']['fecha_planificacion']->format('d \d\e F \d\e\l Y') }}
                </td>
                <?php $count_fumigaciones++; ?>
            </tr>
        @else
            <tr>
                <td>{{$simulador['tipo']}}</td>
                @if($simulador['tipo'] == "Preparacion")
                    <td>
                        <strong>Acidez / Alcalinidad:</strong> {{$simulador['preparacionterreno']['ph']}} pH<br>
                        <strong>Plaga Suelo:</strong> {{$simulador['preparacionterreno']['plaga_suelo']}} %<br>
                        <strong>Drenaje:</strong> {{$simulador['preparacionterreno']['drenage']}} %<br>
                        <strong>Erocion:</strong> {{$simulador['preparacionterreno']['erocion']}} %<br>
                        <strong>Maleza Preparacion:</strong> {{$simulador['preparacionterreno']['maleza_preparacion']}} %
                    </td>
                @elseif($simulador['tipo'] == "Siembra")
                    <?php $semillas = ['None', 'No Certificada', 'Certificada', 'Registrada', 'Basica']?>
                    <?php $fertilizaciones = ['Fertiliacion no Correcta', 'Fertilizacion Correcta']?>
                    <td>
                        <strong>Semilla:</strong> {{$semillas[$simulador['siembra']['semilla']]}}<br>
                        <strong>Fertilizacion:</strong> {{$fertilizaciones[$simulador['siembra']['fertilizacion']]}}<br>
                        <strong>Distancia surco:</strong> {{$simulador['siembra']['distancia_surco']}} cm<br>
                        <strong>Distancia planta:</strong> {{$simulador['siembra']['distancia_planta']}} cm
                    </td>
                @elseif($simulador['tipo'] == "Cosecha")
                    <td>
                        <strong>Problemas de produccion:</strong> {{$simulador['problemas']}} %<br>
                        <strong>Altura de tallo:</strong> {{$simulador['altura']}} %<br>
                        <strong>Humedad del terreno:</strong> {{$simulador['humedad']}} %<br>
                        <strong>Remdimiento de produccion:</strong> {{$simulador['rendimiento']}} %
                    </td>
                @else
                    <td></td>
                @endif
                <td class="text-right">{{ $simulador['created_at']->format('d \d\e F \d\e\l Y') }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>

</body>
