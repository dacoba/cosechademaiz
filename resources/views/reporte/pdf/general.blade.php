<title>Reporte General</title>
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
    .img-thumbnail {
        padding: .25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        max-width: 100%;
        height: auto;
    }
    .mb-img{
        margin-bottom: 25px !important;
    }
    .w-25{
        width: 25%;
    }
    .w-80{
        width: 80%;
    }
    .page-break {
        page-break-after: always;
    }
</style>
<h1 class="text-center">REPORTE GENERAL</h1>
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
<h3>RIEGOS Y FUMAGACIONES</h3>
<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th class="text-center">Nº</th>
        <th class="text-center">Planificacion</th>
        <th class="text-center">Fecha de Planificacion</th>
        <th class="text-center">Hora de Planificacion</th>
        <th class="text-center">Estado</th>
    </tr>
    </thead>
    <tbody>
    @php($cont = 1)
    @foreach ($tablas['planificaciones'] as $planificacion)
        <tr>
            <td class="text-center">{{$cont}}</td>
            <td class="text-center">{{$planificacion['table_name']}}</td>
            <td class="text-center">{{$planificacion['fecha_planificacion']->format('d F Y')}}</td>
            <td class="text-center">{{$planificacion['fecha_planificacion']->format('H:i a')}}</td>
            <td class="text-center">{{$planificacion['estado']}}</td>
        </tr>
        @php($cont++)
    @endforeach
    </tbody>
</table>
<div class="page-break"></div>
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
<h3>COSECHA</h3>
<center>
<img src="{{ base_path() }}/public/{{ $files['cosecha'] }}" class="img-thumbnail mb-img w-80"/>
</center>
<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th>Comentario</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$tablas['cosecha']['comentario_cosecha']}}</td>
    </tr>
    </tbody>
</table>
<div class="page-break"></div>
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
<h3>ESTIMACION DE PRODUCCION</h3>
<center>
    <img src="{{ base_path() }}/public/img/corn{{$tablas['estimacion']['rendimiento_produccion']}}.png" class="img-thumbnail mb-img w-25"/>
</center>
<table class="table table-bordered table-sm">
    <tr>
        <th>Camtidad de Maiz por Planta</th>
        <td class="text-right">{{$tablas['estimacion']['rendimiento_produccion']}} Unidades</td>
    </tr>
    <tr>
        <th>Rendimiento de la Produccion</th>
        <td class="text-right">{{$tablas['estimacion']['rendimiento']}} %</td>
    </tr>
    <tr>
        <th>Produccion por Hectaria</th>
        <td class="text-right">{{$tablas['estimacion']['produccion_por_hectaria']}} Toneladas</td>
    </tr>
    <tr>
        <th>Produccion Total</th>
        <td class="text-right">{{$tablas['estimacion']['produccion_total']}} Toneladas</td>
    </tr>
</table>
<div class="page-break"></div>
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
<h3>CONTROL DE CALIDAD</h3>
<center>
    <img src="{{ base_path() }}/public/{{ $files['calidad'] }}" class="img-thumbnail mb-img w-80"/>
</center>
<table class="table table-bordered table-sm">
    <tr>
        <th>Media</th>
        <td class="text-right">{{$tablas['calidad']['estadistico']['media']}}</td>
    </tr>
    <tr>
        <th>Varianza</th>
        <td class="text-right">{{$tablas['calidad']['estadistico']['varianza']}}</td>
    </tr>
    <tr>
        <th>Desviación Estándar</th>
        <td class="text-right">{{$tablas['calidad']['estadistico']['desviacion_estandar']}}</td>
    </tr>
</table>
</body>
