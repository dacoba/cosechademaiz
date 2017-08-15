<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Clean - One Page Personal Portfolio</title>

    <!-- CSS -->
    <link href="{{URL::asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/simple-line-icons.css')}}" rel="stylesheet" media="screen">
    <link href="{{URL::asset('assets/css/animate.css')}}" rel="stylesheet">

    <!-- Custom styles CSS -->
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" media="screen">

    <script src="{{URL::asset('assets/js/modernizr.custom.js')}}"></script>

</head>
<body>

<div id="preloader">
    <div id="status"></div>
</div>

@yield('content')

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