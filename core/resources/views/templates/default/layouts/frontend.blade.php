@extends($activeTemplate.'layouts.app')
@section('content')

    @push('header')
    @include($activeTemplate.'partials.header_guest')
    @endpush

    @yield('content')

    @php
        $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp
    @if(($cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="cookies-card text-center hide">
        <div class="cookies-card__icon">
            <i class="las la-cookie-bite"></i>
        </div>
        <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
        <div class="cookies-card__btn mt-4">
            <a href="javascript:void(0)" class="btn btn-primary btn-block policy">@lang('Allow')</a>
        </div>
        </div>
    <!-- cookies dark version end -->
    @endif

@endsection

@push('script')

    <script>
        (function ($) {
            "use strict";
            $('.policy').on('click',function(){
                $.get('{{route('cookie.accept')}}', function(response){
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function(){
                $('.cookies-card').removeClass('hide')
            },2000);
        })(jQuery);
    </script>

@endpush


