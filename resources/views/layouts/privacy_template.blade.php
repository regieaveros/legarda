<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="">
    @yield('icon')
    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- nivo slider CSS -->
    <link rel="stylesheet" href="{{ asset('lib/css/nivo-slider.css') }}"/>
    <!-- Fontawesome 4.7 -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Monserrat -->
    <link rel="stylesheet" href="{{ asset('css/montserrat.css') }}">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="{{ asset('/assets/css/core.css') }}">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="{{ asset('assets/css/shortcode/shortcodes.css') }}">
    <!-- Theme main style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <!-- Template color css -->
    <link href="{{ asset('assets/css/color/color-core.css') }}" data-style="styles" rel="stylesheet">
    <!-- User style -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- Lightgallery css -->
    <link rel="stylesheet" href="{{ asset('css/lightgallery.css') }}">

</head>
<body>
<!-- Load Facebook SDK for JavaScript Legarda -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v4.0'
    });
  };

  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="284510181919254">
</div>
    <!-- Body main wrapper start -->
    <div class="wrapper">
        @yield('header')
        @yield('content')
        @yield('footer')
    </div>

    <!-- Placed js at the end of the document so the pages load faster -->
    <!-- jquery latest version -->
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <!-- Lightbox Thumbnail js -->
    <script src="{{ asset('js/lightgallery.min.js') }}"></script>
    <!-- Bootstrap framework js -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Nivo slider js -->
    <script src="{{ asset('lib/js/jquery.nivo.slider.js') }}"></script>
    <!-- All js plugins included in this file. -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <!-- Modernizr JS -->
    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <!-- Lightgallery JS -->
    <script src="{{ asset('js/lightgallery.min.js') }}"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
     
    @yield('js')
</body>
</html>