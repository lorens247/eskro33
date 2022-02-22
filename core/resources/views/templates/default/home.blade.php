@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $banner = getContent('banner.content',true);
@endphp

<section class="banner-section bg_img" data-background="{{ getImage('assets/images/frontend/banner/'.$banner->data_values->image,'1920x1040') }}">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-7 col-lg-6 mb-30">
                <div class="banner-content text-lg-start text-center">
                    <h1 class="title">{{ __($banner->data_values->heading) }}</h1>
                    <span class="sub-title">{{ __($banner->data_values->sub_heading) }}</span>
                    <div class="banner-btn">
                        <a href="{{ __($banner->data_values->button_url) }}" class="btn--base">{{ __($banner->data_values->button_name) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 mb-30">
                <div class="banner-widget-area">
                    <div class="banner-widget">
                        <div class="banner-widget-header text-center">
                            <span class="sub-title text--base">{{ __($banner->data_values->form_heading) }}</span>
                            <h3 class="title">{{ __($banner->data_values->form_title) }}</h3>
                        </div>
                        <form class="banner-widget-form" action="{{ route('user.escrow.create') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>@lang('I am')</label>
                                <select name="me_type" class="form--control">
                                    <option value="1">@lang('Selling')</option>
                                    <option value="2">@lang('Buying')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@lang('Escrow Type')</label>
                                <select name="escrow_type" class="form--control">
                                    <option value="">@lang('Select One')</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ __($type->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label>@lang('Amount')</label>
                                <div class="input-group">
                                    <span class="input-group-text">@lang('For')</span>
                                    <input type="text" class="form--control form-control" name="amount">
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn w-100">@lang('Continue')</button>
                        </form>
                    </div>
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
