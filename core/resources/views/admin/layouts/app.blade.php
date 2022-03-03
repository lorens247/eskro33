@extends('admin.layouts.master')

@section('content')
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">
        @include('admin.partials.sidenav')
        @include('admin.partials.topnav')

        <div class="body-wrapper">
            <div class="bodywrapper__inner wrapping-padding">

                @include('admin.partials.breadcrumb')

                @yield('panel')

            </div><!-- bodywrapper__inner end -->
            <div class="panel-footer">
                <div class="d-flex flex-wrap justify-content-between">
                    <p class="text-white">@lang('Develop with') <i class="lar la-heart text--success"></i> @lang('By') <a class="text--success" href="https://thesoftking.com/" target="_blank">@lang('THESOFTKING')</a></p>
                    <p class="text-white">{{__(systemDetails()['name'])}} <span class="text--success">@lang('V'){{systemDetails()['version']}} </span> @lang('Build') <span class="text--success">@lang('V'){{systemDetails()['tsk_version']}} </span> </p>
                </div>
            </div>
        </div><!-- body-wrapper end -->
    </div>



@endsection
