@php
    $faqContent = getContent('faq.content',true);
    $faqItems = getContent('faq.element',false,null,true);
    $whyChooseUsContent = getContent('why_choose_us.content',true);
    $whyChooseUsItems = getContent('why_choose_us.element',false,null,true);
@endphp

<section class="work-section ptb-40">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-60-none">
            <div class="col-xl-6 col-lg-6 mb-60">
                <div class="work-thumb">
                    <img src="{{ getImage('assets/images/frontend/faq/'.$faqContent->data_values->image, '630x560') }}" alt="element">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-60">
                <div class="work-content">
                    <div class="section-header left">
                        <h2 class="section-title">{{ __($faqContent->data_values->heading) }}</h2>
                        <span class="horizontal-gradient"></span>
                    </div>
                    <div class="faq-wrapper">
                        @foreach($faqItems as $faq)
                        <div class="faq-item">
                            <h3 class="faq-title"><span class="title">{{ __($faq->data_values->question) }} </span><span
                                    class="right-icon"></span></h3>
                            <div class="faq-content">
                                <p>{{ __($faq->data_values->answer) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-60">
                <div class="work-content">
                    <div class="section-header left">
                        <h2 class="section-title">{{ __($whyChooseUsContent->data_values->heading) }}</h2>
                        <span class="horizontal-gradient"></span>
                    </div>
                    <div class="work-item-wrapper">
                        @foreach($whyChooseUsItems as $choose)
                        <div class="work-item d-flex flex-wrap">
                            <div class="work-icon">
                                @php echo $choose->data_values->icon @endphp
                            </div>
                            <div class="work-details">
                                <h4 class="title">{{ __($choose->data_values->title) }}</h4>
                                <p>{{ __($choose->data_values->content) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-60">
                <div class="work-thumb">
                    <img src="{{ getImage('assets/images/frontend/why_choose_us/'.$whyChooseUsContent->data_values->image,'630x560') }}" alt="element">
                </div>
            </div>
        </div>
    </div>
</section>
