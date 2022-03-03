@extends($activeTemplate.'layouts.master')
@section('content')
<section class="account-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="custom--card">
                    <form method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group hover-input-popup">
                                <label>@lang('Password')</label>
                                <input id="password" type="password" class="form--control @error('password') is-invalid @enderror" name="password" required>
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
                                <label>@lang('Confirm Password')</label>
                                <input id="password-confirm" type="password" class="form--control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn--base btn-block">@lang('Reset Password')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
