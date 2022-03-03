@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card custom--card">
                    <form action="" method="post" class="register">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>@lang('Current Password')</label>
                                <input type="password" class="form--control" name="current_password" required autocomplete="current-password">
                            </div>
                            <div class="form-group hover-input-popup">
                                <label>@lang('Password')</label>
                                <input type="password" class="form--control" name="password" required autocomplete="current-password">
                                @if($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">@lang('Confirm Password')</label>
                                <input id="password_confirmation" type="password" class="form--control" name="password_confirmation" required autocomplete="current-password">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn--base  btn-block">@lang('Change Password')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    })(jQuery);
</script>
@endpush

