@extends('layouts.app')

@section('content')
<div class="container pfblock"">
    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="pfblock-header">
                <h2 class="pfblock-title">Administar Cuentas de Productor</h2>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div style="text-align: right;">
                <a href="{{ url('users/productor/create')}}" class="btn btn-primary"><i class="fa fa-plus fa-padding-right"></i>Nuevo Productor</a>
                <div class="input-group search-table">
                    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Cuentas de Productor</div>
                @if (isset($mensaje))
                    <div class="alert alert-success">
                        <strong>¡Correcto! </strong>{{ $mensaje }}
                    </div>
                @endif
                <div class="panel-body">
                    @if (isset($error))
                        <div class="alert alert-danger">
                            <strong>¡Error! </strong>{{ $error }}
                        </div>
                    @endif
                    @if (isset($success))
                        <div class="alert alert-success">
                            <strong>¡Exitoso! </strong>{{ $success }}
                        </div>
                    @endif
                    <style>
                        .btn-mini-xs{
                            padding: 5px 10px;
                        }
                        .btn-mini-xs-form{
                            float: right;
                            padding-left: 4px;
                        }
                    </style>
                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr style="background-color: #f1f1f1;">
                            <th style="text-align: right">CI</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th style="text-align: center">Telefono</th>
                            <th>Direccion</th>
                            <th style="text-align: center; width: 113px;">Opcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($productors as $productor)
                            <tr>
                                <td style="text-align: right">{{$productor['ci']}}</td>
                                <td>{{$productor['nombre']}}</td>
                                <td>{{$productor['apellido']}}</td>
                                <td>{{$productor['email']}}</td>
                                <td style="text-align: center">{{$productor['telefono']}}</td>
                                <td>{{$productor['direccion']}}</td>
                                <td style="text-align: center">
                                    <a href="{{ url('users/productor')}}/{{$productor['id']}}" class="btn btn-primary btn-xs btn-mini-xs"><i class="fa fa-btn fa-file-text-o"></i></a>
                                    <a href="{{ url('users/productor')}}/{{$productor['id']}}/edit" class="btn btn-warning btn-xs btn-mini-xs"><i class="fa fa-btn fa-pencil"></i></a>
                                    <form action="{{ url('users/productor')}}/{{$productor['id']}}" method="post" class="btn-mini-xs-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE" >
                                        <button class="btn btn-danger btn-xs btn-mini-xs" type="submit">
                                            <i class="fa fa-btn fa-trash-o"></i>
                                        </button>
                                    </form>
                                </td>
                                {{--<td style="text-align: center">--}}
                                    {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/fumigacions/create') }}">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--<input type="hidden" name="planificacionfumigacion_id" value="{{$planificacionfumigacion['id']}}" >--}}
                                        {{--<input type="hidden" name="siembra_id" value="{{$siembra_id}}" >--}}
                                        {{--<button type="submit" class="btn btn-primary btn-xs" @if ($planificacionfumigacion['estado'] != 'ejecutado') disabled @endif>--}}
                                            {{--<i class="fa fa-btn fa-pencil"></i>--}}
                                        {{--</button>--}}
                                    {{--</form>--}}
                                {{--</td>--}}
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
