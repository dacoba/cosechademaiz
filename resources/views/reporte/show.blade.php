@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="pfblock-header">
            <h2 class="pfblock-title">
                <a href="{{ url('reportes')}}">
                    <i class="fa fa-chevron-circle-left"></i>
                </a>Reportes
            </h2>
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
                        <div class="col-md-4 text-center">
                            <a href="{{ url('reportes/general')}}/{{$preterreno['id']}}" class="btn btn-default">Reporte General</a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ url('reportes/estados')}}/{{$preterreno['id']}}" class="btn btn-default">Reporte de Estados</a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ url('reportes/simulacion')}}/{{$preterreno['id']}}" class="btn btn-default">Reporte de Simulacion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
