<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/fontawesome-all.min.css') }}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/bootstrap.min.css') }}">
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/swiper.min.css') }}">
    <!-- odometer css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/odometer.css') }}">
    <!-- select css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/select2.min.css') }}">
    <!-- apex-chart css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/apexcharts.css') }}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/line-awesome.min.css') }}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/animate.css') }}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/style.css') }}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php')}}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}&thirdColor={{ $general->third_color }}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style-lib')

    @include($activeTemplate.'partials.custom_css_lib')

    @stack('style')
</head>
<body>

<div class="preloader">
    <div class="wrapper-triangle">
        <div class="pen">
            <div class="line-triangle">
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
            </div>
            <div class="line-triangle">
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
            </div>
            <div class="line-triangle">
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
                <div class="triangle"></div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="scrollToTop">
    <i class="las la-dot-circle"></i>
    <span>@lang('Top')</span>
</a>

@include($activeTemplate.'partials.header')


@if(!request()->routeIs('home'))
@include($activeTemplate.'partials.breadcrumb')
@endif

@yield('content')

@include($activeTemplate.'partials.footer')

<!-- jquery -->
<script src="{{ asset($activeTemplateTrue.'js/jquery-3.5.1.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset($activeTemplateTrue.'js/bootstrap.bundle.min.js') }}"></script>
<!-- swipper js -->
<script src="{{ asset($activeTemplateTrue.'js/swiper.min.js') }}"></script>
<!-- select js file -->
<script src="{{ asset($activeTemplateTrue.'js/select2.min.js') }}"></script>
<!-- viewport js -->
<script src="{{ asset($activeTemplateTrue.'js/viewport.jquery.js') }}"></script>
<!-- odometer js -->
<script src="{{ asset($activeTemplateTrue.'js/odometer.min.js') }}"></script>
<!-- wow js file -->
<script src="{{ asset($activeTemplateTrue.'js/wow.min.js') }}"></script>
<!-- main -->
<script src="{{ asset($activeTemplateTrue.'js/main.js') }}"></script>


<script src="{{asset($activeTemplateTrue.'js/custom.js')}}"></script>

@stack('script-lib')

@include($activeTemplate.'partials.custom_js_lib')

@include('partials.notify')

@stack('script')

<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });
    })(jQuery);
</script>

</body>
</html>
