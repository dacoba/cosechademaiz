@extends('layouts.appini')

@section('content')
<section id="home" class="pfblock-image screen-height">
    <div class="home-overlay"></div>
    <div class="intro">
        <div class="start">Proyeto de grado</div>
        <h1>sistema web responsive de gestión del proceso de produccion y simulación de
            crecimiento de maíz</h1>
        <div class="start">Gualberto Rocha Escobar</div>
    </div>
    @if (Auth::guest())
        <a href="{{ url('/login') }}">
    @else
        <a href="{{ url('/home') }}">
    @endif
        <div class="scroll-down">
        <span>
            <i class="fa fa-angle-down fa-2x"></i>
        </span>
        </div>
    </a>

</section>
@endsection
