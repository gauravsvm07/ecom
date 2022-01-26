<!doctype html>
<html>
@include('includes.admin.head')
<body>
<div class="main-wrapper">
@include('includes.admin.header')
@include('includes.admin.sidebar')
@yield('content')
</div>
@include('includes.admin.extra')
</body>
</html>