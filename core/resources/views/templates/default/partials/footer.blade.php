<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@php
    $contactInfos = getContent('contact.element',false,null,true);
    $brands = getContent('brand.element',false,null,true);
    $policies = getContent('policy_pages.element',false,null,true);
    $footer = getContent('footer.content',true);
    $socials = getContent('social_icon.element',false,null,true);
@endphp

<footer class="footer-section">

    <div class="accepted-processors">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="brand-wrapper">
                        <div class="swiper-wrapper">
                            @foreach($brands as $brand)
                            <div class="swiper-slide">
                                <div class="brand-item">
                                    <img src="{{ getImage('assets/images/frontend/brand/'.$brand->data_values->image, '140x40') }}" alt="payment">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-section-top">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6 col-md-8 text-md-start text-center">
                    <h2 class="title text-white">{{ __($footer->data_values->title) }}</h2>
                </div>
                <div class="col-md-4 text-md-end text-center">
                    <a href="{{ __($footer->data_values->button_url) }}" class="btn--base">{{ __($footer->data_values->button_name) }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-section-middle">
        <div class="container">
            <div class="row justify-content-between gy-4">
                <div class="col-lg-4">
                    <div class="footer-widget">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ getImage(fileManager()->logoIcon()->path.'/logo.png') }}" alt="site-logo"></a>
                        <p class="text-white mt-4">{{ __($footer->data_values->content) }}</p>
                        <ul class="social-link-list">
                            @foreach($socials as $social)
                            <li><a href="{{ __($social->data_values->url) }}" target="_blank">@php echo $social->data_values->social_icon @endphp</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="footer-widget">
                        <h4 class="footer-widget__title">@lang('Short Links')</h4>
                        <ul class="short-link-list">
                            <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                            @foreach($pages as $k => $data)
                                <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                            @endforeach
                            <li><a href="{{ route('blogs') }}">@lang('Blog')</a></li>
                            <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="footer-widget">
                        <h4 class="footer-widget__title">@lang('Useful Links')</h4>
                        <ul class="short-link-list">
                            @foreach($policies as $policy)
                                <li><a href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}">{{ __($policy->data_values->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h4 class="footer-widget__title">@lang('Contact Information')</h4>
                        <ul class="footer-contact-list">
                            @foreach($contactInfos as $info)
                            <li>
                                <div class="icon">
                                    @php echo $info->data_values->icon @endphp
                                </div>
                                <div class="content">
                                    <h6 class="title">{{ __($info->data_values->title) }}</h6>
                                    <span class="sub-title">{{ __($info->data_values->content) }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrapper">
        <div class="container">
            <div class="copyright-area justify-content-center">
                <p>@lang('Copyright') &copy; {{ date('Y') }} <a href="{{ route('home') }}" class="text--base">{{ __($general->sitename) }}</a>. @lang('All Rights Reserved.')</p>
            </div>
        </div>
    </div>
</footer>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
