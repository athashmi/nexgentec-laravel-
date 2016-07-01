
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nexgentec</title>

   <!--  <link href="/css/app.css" rel="stylesheet" /> -->
    {{--  <link href="/css/app_inner.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}"> --}}
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{URL::asset('css/ionicons.min.css')}}">
    
	<style>
		.multiselect-clear-filter
		{
		    padding: 9px 12px;
		}
        .btn-group{
            display: block;
        }

        .dropdown-toggle .badge {
            background-color: #e02222;
            left: 22px;
            position: absolute;
            top: 4px;
        }
	</style>



    @section('styles')
    @show



    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{URL::asset('css/_all-skins.min.css')}}">

