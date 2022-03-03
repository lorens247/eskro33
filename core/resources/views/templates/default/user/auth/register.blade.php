@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $policies = getContent('policy_pages.element',false,null,true);
@endphp
<section class="account-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="account-form-wrapper">
                    <div class="account-left bg_img" data-background="{{ getImage('assets/images/frontend/register/'.getContent('register.content',true)->data_values->image,'1920x1040') }}">
                        <div class="account-change">
                            <p class="text-white">@lang('Already have an account?')</p>
                            <a href="{{ route('user.login') }}" class="btn--base">@lang('Login Now')</a>
                        </div>
                    </div>
                    <div class="account-right">
                        <div class="account-form-area">
                            <div class="account-header">
                                <h3 class="title">@lang('Account Information')</h3>
                            </div>
                            <form class="account-form verify-gcaptcha" method="post" action="{{ route('user.register') }}">
                                @csrf
                                <div class="row ml-b-20">
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('First Name')</label>
                                        <input type="text" name="firstname" value="{{ old('firstname') }}" class="form--control" name="text">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Last Name')</label>
                                        <input type="text" name="lastname" value="{{ old('lastname') }}" class="form--control" name="text">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Country')</label>
                                        <select name="country" id="country" class="form--control">
                                            @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Mobile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text mobile-code"></span>
                                            <input type="text" name="mobile" autocomplete="off" class="form--control form-control checkUser" required>
                                        </div>
                                        <small class="text-danger mobileExist"></small>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Email')</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form--control checkUser" name="email">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Username')</label>
                                        <input type="text" name="username" value="{{ old('username') }}" class="form--control checkUser" name="text">
                                        <small class="text-danger usernameExist"></small>
                                    </div>
                                    <div class="col-lg-6 form-group hover-input-popup">
                                        <label>@lang('Password')</label>
                                        <input type="password" name="password" class="form--control" name="password">
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
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Confirm Password')</label>
                                        <input type="password" name="password_confirmation" class="form--control" name="password">
                                    </div>
                                    <x-captcha></x-captcha>
                                    @if($general->agree)
                                    <div class="col-lg-12 form-group">
                                        <div class="form-group custom-check-group">
                                            <input type="checkbox" name="agree" id="level-1">
                                            <label for="level-1">@lang('I agree with')  @foreach($policies as $policy) <a href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}" class="text--base">{{ __($policy->data_values->title) }}</a> @if(!$loop->last) , @endif @endforeach</label>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn--base w-100">@lang('Register Now')</button>
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

{{-- Exists Modal --}}
<div id="existModalCenter" class="custom--modal modal fade">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Email Exists Alert')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('You already have an account please login')</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('user.login') }}" class="btn btn-block btn--base">@lang('Login')</a>
            </div>
        </div>
    </div>
</div>

@endsection
@push('style')
<style>
    .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function ($) {
            "use strict";

            @if($mobile_code)
            $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif



            let mobileElement = $('.mobile-code');
            $('select[name=country]').change(function(){
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            mobileElement.text(`+ ${$('select[name=country] :selected').data('mobile_code')}`);
            $('.checkUser').on('focusout',function(e){
                let url = '{{ route('user.checkUser') }}';
                let value = $(this).val();
                let column = $(this).attr('name');
                let data = {_token:'{{ csrf_token() }}'}
                if(column == 'mobile') {
                    value = `${mobileElement.text().substr(1)}${value}`;
                }
                data.value = value;
                data.column = column;
                if(value && column){
                    $.post(url,data,function(response) {
                        console.log(response);
                        if(response.status == 'exists'){
                            if(column == 'email') {
                                $('#existModalCenter').modal('show');
                            }else{
                                $(`.${column}Exist`).text(response.message);
                            }
                        }
                    });
                }
            });

            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });
            @endif

        })(jQuery);

    </script>
@endpush
