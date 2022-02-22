@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="account-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="account-form-wrapper style--two">
                    <div class="account-left bg_img" data-background="{{ getImage('assets/images/frontend/login/'.getContent('login.content',true)->data_values->image,'1920x1040') }}">
                        <div class="account-change">
                            <p class="text-white">@lang('Don\'t have an account?')</p>
                            <a href="{{ route('user.register') }}" class="btn--base">@lang('Register Now')</a>
                        </div>
                    </div>
                    <div class="account-right">
                        <div class="account-form-area">
                            <div class="account-header">
                                <h3 class="title">@lang('Login Information')</h3>
                            </div>
                            <form class="account-form verify-gcaptcha" method="POST" action="{{ route('user.login')}}">
                                @csrf
                                <div class="row ml-b-20">
                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Username or Email')</label>
                                        <input type="text" name="username" value="{{ old('username') }}" class="form--control form--control" name="text">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label>@lang('Password')</label>
                                        <input type="password" name="password" value="{{ old('password') }}" class="form--control form--control" name="password">
                                    </div>
                                    <x-captcha></x-captcha>
                                    <div class="col-lg-12 form-group">
                                        <div class="custom-check-group">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="level-1">
                                            <label for="level-1">@lang('Remember me')</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="btn--base w-100">@lang('Login Now')</button>
                                    </div>
                                    <div class="col-lg-12">
                                        <p class="text-center">@lang('Forgot your password?')</span> <a href="{{route('user.password.request')}}" class="text--base">@lang('Reset now')</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
