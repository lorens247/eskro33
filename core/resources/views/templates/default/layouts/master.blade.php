@extends($activeTemplate.'layouts.app')
@section('content')

    @push('header')
        @include($activeTemplate.'partials.header_auth')
    @endpush

    @yield('content')

@endsection
