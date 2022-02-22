@extends($activeTemplate.'layouts.master')
@section('content')
<section class="account-section ptb-80">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper">
                <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                    @csrf
                    <p class="verification-text">@lang('A 6 digit verification code sent to your email address') :  {{ showEmailAddress($email) }}</p>
                    <input type="hidden" name="email" value="{{ $email }}">
                    @include($activeTemplate.'partials.verification_code')
                    <div class="form-group">
                        <button type="submit" class="btn btn--base btn-block">@lang('Verify Code') <i class="las la-sign-in-alt"></i></button>
                    </div>
                    <div class="form-group justify-content-between align-items-center">
                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                        <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
