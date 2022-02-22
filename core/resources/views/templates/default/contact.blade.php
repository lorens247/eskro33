@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $contactInfos = getContent('contact.element',false,null,true);
@endphp
<section class="contact-info-section pt-80">
    <div class="container">
        <div class="contact-info-area">
            <div class="row justify-content-center gy-4">
                @foreach($contactInfos as $info)
                <div class="col-xl-4 col-lg-4">
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            @php echo $info->data_values->icon @endphp
                        </div>
                        <div class="contact-info-content">
                            <h5 class="title">{{ __($info->data_values->title) }}</h5>
                            <span class="sub-title">{{ __($info->data_values->content) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="contact-section pt-5 pb-80 bg_img">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-7 col-lg-7 mb-30">
                <div class="contact-form-inner">
                    <div class="contact-form-area">
                        <h3 class="title mb-4">@lang('Get in Touch')</h3>
                        <form class="contact-form verify-gcaptcha" action="" method="post">
                            @csrf
                            <div class="row justify-content-center mb-10-none">
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Name')</label>
                                    <input name="name" type="text" class="form--control" value="@if(auth()->user()) {{ auth()->user()->fullname }} @else {{ old('name') }} @endif" @if(auth()->user()) readonly @endif required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Email')</label>
                                    <input name="email" type="text" class="form--control" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{old('email')}} @endif" @if(auth()->user()) readonly @endif required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Subject')</label>
                                    <input name="subject" type="text" class="form--control" value="{{old('subject')}}" required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Message')</label>
                                    <textarea class="form--control" name="message">{{ old('message') }}</textarea>
                                </div>
                                <x-captcha></x-captcha>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn--base mt-20">@lang('Send Message')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 mb-30">
                <div class="map-area">
                    <iframe src="{{ __(getContent('contact.content',true)->data_values->map_iframe) }}" style="border:0" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@if($sections->secs != null)
  @foreach(json_decode($sections->secs) as $sec)
      @include($activeTemplate.'sections.'.$sec)
  @endforeach
@endif
@endsection
