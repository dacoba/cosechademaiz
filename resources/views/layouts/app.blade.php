<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cosecha</title>

    <!-- CSS -->
    <link href="{{URL::asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">
    {{--<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">--}}
    <link href="{{URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/simple-line-icons.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/animate.css')}}" rel="stylesheet">

    <!-- Custom styles CSS -->
    <link href="{{URL::asset('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/bootstrap-slider.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/nvd/nv.d3.css')}}" rel="stylesheet" media="screen">

    <script src="{{URL::asset('assets/js/modernizr.custom.js')}}"></script>

</head>
<body>

<div id="preloader">
    <div id="status"></div>
</div>

<header class="header">

    <nav class="navbar navbar-custom" role="navigation">

        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/home') }}">Cosecha</a>
            </div>

            <div class="collapse navbar-collapse" id="custom-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if (!Auth::guest())
                        @if ( Auth::user()->tipo == 'Administrador')
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios</a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/users/tecnico') }}">Tecnico</a></li>
                                    <li><a href="{{ url('/users/productor') }}">Productor</a></li>
                                </ul>
                            </li>
                        @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Terreno</a>
                        <ul class="dropdown-menu">
                            @if ( Auth::user()->tipo == 'Administrador')
                                <li><a href="{{ url('/terrenos/create') }}">Administar Terreno</a></li>
                            @endif
                            <li><a href="{{ url('/preparacionterrenos') }}">Preparacion del Terreno</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/siembras/create') }}">Siembra</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Riego</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/planificacionriegos/siembras') }}">Planificacion</a></li>
                            <li><a href="{{ url('/riegos') }}">Administrar Riego</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Fumigacion</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/planificacionfumigacions/siembras') }}">Planificacion</a></li>
                            <li><a href="{{ url('/fumigacions') }}">Administrar Fumigacion</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/cosechas') }}">Cosecha</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/reportes/siembras') }}">Reporte de Siembras</a></li>
                        </ul>
                    </li>
                    @endif
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Iniciar Sesion</a></li>
{{--                        <li><a href="{{ url('/register') }}">Register</a></li>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->nombre }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Cerrar Sesion</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>

        </div><!-- .container -->

    </nav>

</header>

@yield('content')

<!-- Contact end -->

<!-- Footer start -->

<footer id="footer">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">

                <ul class="social-links">
                    <li><a href="index.html#" class="wow fadeInUp"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="index.html#" class="wow fadeInUp" data-wow-delay=".1s"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="index.html#" class="wow fadeInUp" data-wow-delay=".2s"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="index.html#" class="wow fadeInUp" data-wow-delay=".4s"><i class="fa fa-pinterest"></i></a></li>
                    <li><a href="index.html#" class="wow fadeInUp" data-wow-delay=".5s"><i class="fa fa-envelope"></i></a></li>
                </ul>

                <p class="copyright">
                    © 2017 Proyecto de tesis
                </p>

            </div>

        </div><!-- .row -->
    </div><!-- .container -->
</footer>

<!-- Footer end -->

<!-- Scroll to top -->

<div class="scroll-up">
    <a href="#home"><i class="fa fa-angle-up"></i></a>
</div>

<!-- Scroll to top end-->

<!-- Javascript files -->

<script src="{{URL::asset('assets/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{URL::asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.parallax-1.1.3.js')}}"></script>
<script src="{{URL::asset('assets/js/imagesloaded.pkgd.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.sticky.js')}}"></script>
<script src="{{URL::asset('assets/js/smoothscroll.js')}}"></script>
<script src="{{URL::asset('assets/js/wow.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.easypiechart.js')}}"></script>
<script src="{{URL::asset('assets/js/waypoints.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.cbpQTRotator.js')}}"></script>
<script src="{{URL::asset('assets/js/custom.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-2.1.1.min.js')}}"></script>
<script src="{{URL::asset('assets/js/moment-with-locales.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('assets/nvd/d3.min.js')}}"></script>
<script src="{{URL::asset('assets/nvd/nv.d3.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
//            format: 'DD/MM/YYYY HH:mm',
            format: 'YYYY-MM-DD HH:mm:ss',
        });
    });

    nv.addGraph(function() {
        var chart = nv.models.discreteBarChart()
            .x(function(d) { return d.label })
            .y(function(d) { return d.value })
            .staggerLabels(true)
            //.staggerLabels(historicalBarChart[0].values.length > 8)
            .showValues(true)
            .duration(250)
        ;

        d3.select('#chart1 svg')
            .datum(historicalBarChart)
            .call(chart);

        nv.utils.windowResize(chart.update);
        return chart;
    });

</script>

</body>
</html>