@php
	$customCaptcha = loadCustomCaptcha();
    $googleCaptcha = loadReCaptcha()
@endphp
@if($googleCaptcha)
    <div class="mb-3">
        @php echo $googleCaptcha @endphp
    </div>
@endif
@if($customCaptcha)
    <div class="form-group">
        <div class="mb-4">
            @php echo $customCaptcha @endphp
        </div>
        <div class="custom-field-box">
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control custom-field" required>
            <i class="las la-fingerprint input-icon"></i>
        </div>
    </div>
@endif

@push('script')
    <script>
    (function($){
        "use strict"
        $('.verify-gcaptcha').on('submit',function(){
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        });
    })(jQuery);
    </script>
@endpush
@push('style')
    <style>
        .g-recaptcha{
            display: flex;
            justify-content: center;
        }
        #g-recaptcha-error{
            text-align: center;
        }
    </style>
@endpush
