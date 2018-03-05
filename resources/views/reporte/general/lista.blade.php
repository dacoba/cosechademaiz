@extends('layouts.app')

@section('content')
<div class="container pfblock">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Reporte General</h2>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="hidden-sm-up" align="right">

                <div class="input-group search-table" style="float: none;">
                    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Procesos de Produccion</div>
                <div class="panel-body">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: center">Codigo</th>
                            <th style="text-align: right">Area Parcela</th>
                            <th>Productor</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($preterrenos as $preterreno)
                            <tr>
                                <td style="text-align: center">{{$preterreno['id']}}</td>
                                <td style="text-align: right">{{$preterreno['terreno']['area_parcela']}} Hec.</td>
                                <td>{{$preterreno['terreno']['productor']['nombre']}} {{$preterreno['terreno']['productor']['apellido']}}</td>
                                <td style="text-align: center">{{$preterreno['estado']}}</td>
                                <td style="text-align: center">
                                    <a href="{{ url('reportes/general')}}/{{$preterreno['id']}}" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
