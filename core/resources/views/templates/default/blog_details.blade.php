@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="blog-details-section blog-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-9 col-lg-9 mb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image, '1275x720') }}" alt="blog">
                    </div>
                    <div class="blog-content">
                        <h4 class="title">{{ __($blog->data_values->title) }}</h4>
                        @php echo $blog->data_values->description @endphp
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 mb-30">
                <div class="sidebar">
                    <div class="widget-box">
                        <h5 class="widget-title">@lang('Latest Posts')</h5>
                        <div class="popular-widget-box">
                            @foreach($blogs as $blog)
                            <div class="single-popular-item d-flex flex-wrap align-items-center">
                                <div class="popular-item-thumb">
                                    <img src="{{ getImage('assets/images/frontend/blog/thumb_'.$blog->data_values->image, '425x240') }}" alt="blog">
                                </div>
                                <div class="popular-item-content">
                                    <h5 class="title"><a href="{{ route('blog.details',[slug($blog->data_values->title),$blog->id]) }}">{{ shortDescription($blog->data_values->title,50) }}</a></h5>
                                    <span class="blog-date">{{ $blog->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
