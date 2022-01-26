<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
		<!-- Favicon -->
          <link rel="shortcut icon" href="{{URL::asset('front/images/favicon.png')}}" rel="shortcut icon">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{URL::asset('admin/css/bootstrap.min.css')}}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{URL::asset('admin/css/font-awesome.min.css')}}">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="{{URL::asset('admin/css/feathericon.min.css')}}">
		
		<link rel="stylesheet" href="{{URL::asset('admin/plugins/morris/morris.css')}}">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{URL::asset('admin/css/style.css')}}">
		<input type="hidden" name="csrf_token" value="{{ csrf_token() }}" />
		 <script src="{{URL::asset('admin/js/jquery-3.2.1.min.js')}}"></script>
		<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
		
    </head>