<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
   	@include('partials.head')
</head>
<body>
	
	@include('partials.header')
	@section('main')
	@show
	
	@include('partials.footerscript')

</body>
@stack('scripts')
</html>