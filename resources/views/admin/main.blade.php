<html>
	<head>
		@include('admin.head')
		
	</head>
	<body class="hold-transition skin-blue-light sidebar-mini">
		<div class="wrapper">
			@include('admin.header')
			@if((session('cust_id')!='') && (session('customer_name')!=''))
				@include('admin.nav_customer')
			@else
				@include('admin.nav')
			@endif
			

			<div class="content-wrapper">
				@section('content')
				@show
			</div>

			<footer class="main-footer">
		      
		        <strong>Copyright &copy; 2016-2017 <a href="/">Nexgentec</a>.</strong> All rights reserved.
		    </footer>

		</div>

		@include('admin.script')
		<script type="text/javascript">
			$(document).ready(function()  {
				    $.ajaxSetup({
				        headers: {
				            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        }
				});
				    

			@section('document.ready')
			@show	    

			});
			function alert_hide()
			{
				 window.setTimeout(function() {
				    $(".alert").fadeTo(1500).slideUp(200, function(){
				        $(this).hide(); 
				    });
				}, 5000);
			}
			var APP_URL = '{{url('/')}}';
    	</script>

		@section('script')
		@show
		
	</body>
</html>