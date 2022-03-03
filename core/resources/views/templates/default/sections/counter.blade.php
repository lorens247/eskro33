@php
    $counterContent = getContent('counter.content',true);
    $counters = getContent('counter.element',false,null,true);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Statistics
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="statistics-section pt-80 pb-60 section--bg">
    <div class="container">
        <div class="row justify-content-center mb-50-none">
            @foreach($counters as $counter)
            <div class="col-lg-3 col-sm-6 mb-50">
                <div class="statistics-item text-center">
                    <div class="statistics-icon">
                        @php echo $counter->data_values->icon @endphp
                    </div>
                    <div class="statistics-content">
                        <div class="odo-area">
                            <h3 class="odo-title">{{ __($counter->data_values->number) }}</h3>
                        </div>
                    </div>
                    <p>{{ __($counter->data_values->title) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Statistics
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

