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
    <div class="form-group d-block">
        <label>@lang('Captcha')</label>
        <div class="mb-4">
            @php echo $customCaptcha @endphp
        </div>
        <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control form--control" required>
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
