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
    <link href="{{URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/simple-line-icons.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/animate.css')}}" rel="stylesheet">

    <!-- Custom styles CSS -->
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/bootstrap-slider.css')}}" rel="stylesheet" media="screen">

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
                            <li><a href="{{ url('/preparacionterrenos/create') }}">Preparacion del Terreno</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/siembras/create') }}">Siembra</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Riego</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/planificacionriegos/siembras') }}">Planificacion</a></li>
                            <li><a href="#">Administrar Riego</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Fumigacion</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Planificacion</a></li>
                            <li><a href="#">Administrar Fumigacion</a></li>
                        </ul>
                    </li>
                    <li><a href="">Cosecha</a></li>
                    <li><a href="">Reportes</a></li>
                    @endif
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
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

</body>
</html>