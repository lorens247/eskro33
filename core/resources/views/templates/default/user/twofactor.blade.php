@extends($activeTemplate.'layouts.master')
@section('content')

<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            @if(!auth()->user()->ts)
            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                        <h4 class="card-title mb-0">
                            @lang('Add Your Account')
                        </h4>
                    </div>

                    <div class="card-body">
                        <h6 class="mb-3">
                            @lang('Use the QR code or setup key on your Google Authenticator app to add your account. ')
                        </h6>

                        <div class="form-group mx-auto text-center">
                            <img class="mx-auto" src="{{$qrCodeUrl}}">
                        </div>

                        <div class="form-group">
                            <label>@lang('Setup Key')</label>
                            <div class="input-group">
                                <input type="text" name="key" value="{{$secret}}" class="form-control form--control" id="referralURL" readonly>
                                <button type="button" class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </button>
                            </div>
                        </div>

                        <label><i class="fa fa-info-circle"></i> @lang('Help')</label>
                        <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('Download')</a></p>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-6">
                @if(auth()->user()->ts)
                    <div class="card custom--card">
                        <div class="card-header">
                            <h4 class="card-title">@lang('Disable 2FA Security')</h4>
                        </div>
                        <form action="{{route('user.twofactor.disable')}}" method="POST">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="key" value="{{$secret}}">
                                <div class="form-group">
                                    <label>@lang('Google Authenticatior OTP')</label>
                                    <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter the OTP')">
                                </div>
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="card custom--card">
                        <div class="card-header">
                            <h4 class="card-title">@lang('Enable 2FA Security')</h4>
                        </div>
                        <form action="{{ route('user.twofactor.enable') }}" method="POST">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="key" value="{{$secret}}">
                                <div class="form-group">
                                    <label>@lang('Google Authenticatior OTP')</label>
                                    <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter the OTP')">
                                </div>
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


