@php
    $service = getContent('service.content',true);
    $services = getContent('service.element',false,null,true);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="services-section pt-40 pb-80">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">{{ __($service->data_values->heading) }}</h2>
            <span class="horizontal-gradient"></span>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach($services as $service)
            <div class="col-xl-4 col-md-6 col-sm-6 mb-30">
                <div class="service-item">
                    <div class="service-item-header">
                        <h4 class="title">{{ __($service->data_values->title) }}</h4>
                        <div class="service-icon">
                            @php echo $service->data_values->icon @endphp
                        </div>
                    </div> 
                    <div class="service-content">
                        <p>{{ __($service->data_values->content) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
