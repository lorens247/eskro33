@extends('admin.layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="login-section bg_img" data-background="{{asset('assets/admin/images/1.jpg')}}">
            <div class="left">
                <div class="left-inner">
                    <div class="text-center mb-3">
                        <h2>{{ __($pageTitle) }}</h2>
                        <p>@lang('Please check your email and enter the verification code you got in your email.')</p>
                    </div>
                    <form action="{{ route('admin.password.verify.code') }}" class="submit-form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Verification Code')</label>
                            <div class="verification-code">
                                <input type="text" name="code" id="verification-code" class="form-control custom-field overflow-hidden" required autocomplete="off">
                                <div class="boxes">
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn--primary">@lang('Verify Code')</button>
                        </div>
                        <div class="form-group text-center">
                            <a href="{{ route('admin.password.reset') }}" class="text-muted"><i class="las la-sync-alt me-1"></i>@lang('Try to send again')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/verification_code.css') }}">
@endpush
