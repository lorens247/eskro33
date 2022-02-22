@php
    $overview = getContent('overview.content',true);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Overview
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="overview-section pt-80 pb-40">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="overview-content">
                    <div class="section-header left">
                        <h2 class="section-title">{{ __($overview->data_values->heading) }}</h2>
                        <span class="horizontal-gradient"></span>
                    </div>
                    <p>{{ __($overview->data_values->content) }}</p>
                    <div class="overview-btn mt-30">
                        <a href="{{ __($overview->data_values->button_url) }}" class="btn--base">{{ __($overview->data_values->button_name) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="overview-chart-area">
                    <div class="overview-chart">
                        <img src="{{ getImage('assets/images/frontend/overview/'.$overview->data_values->image,'620x410') }}" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Overview
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
