@php
    $howItWorkContent = getContent('how_it_work.content',true);
    $works = getContent('how_it_work.element',false,null,true);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start How-it-works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="how-it-works-section ptb-80 section--bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __($howItWorkContent->data_values->heading) }}</h2>
                    <span class="horizontal-gradient"></span>
                </div>
            </div>
        </div>
        <div class="how-it-works-area">
            <div class="row justify-content-center mb-30-none how-it-works-area">
                @foreach($works as $work)
                <div class="col-lg-3 col-sm-6 mb-30 how-it-works-card">
                    <div class="how-it-works-item text-center">
                        <div class="how-it-works-icon">
                            @php echo $work->data_values->icon @endphp
                        </div>
                        <div class="how-it-works-content">
                            <h4 class="title">{{ __($work->data_values->title) }}</h4>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End How-it-works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
