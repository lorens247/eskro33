@php
    $testimonialContent = getContent('testimonial.content',true);
    $testimonials = getContent('testimonial.element',false,null,true);
@endphp

<div class="client-section pt-80 pb-40">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">{{ __($testimonialContent->data_values->heading) }}</h2>
            <span class="horizontal-gradient"></span>
        </div>
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12">
                <div class="client-slider-inner">
                    <div class="client-slider">
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="client-item d-flex flex-wrap">
                                    <div class="client-thumb-area">
                                        <div class="client-thumb">
                                            <img src="{{ getImage('assets/images/frontend/testimonial/'.$testimonial->data_values->image,'120x120') }}" alt="client">
                                        </div>
                                        <div class="content">
                                            <h4 class="title">{{ __($testimonial->data_values->name) }}</h4>
                                            <span class="sub-title">{{ __($testimonial->data_values->designation) }}</span>
                                        </div>
                                    </div>
                                    <div class="client-content">
                                        <div class="client-quote">
                                            <i class="las la-quote-right"></i>
                                        </div>
                                        <p>{{ __($testimonial->data_values->comment) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

