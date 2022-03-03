@php
    $blogContent = getContent('blog.content',true);
    $blogs = getContent('blog.element',false,4);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section pt-40 pb-80">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">{{ __($blogContent->data_values->heading) }}</h2>
            <span class="horizontal-gradient"></span>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach($blogs as $blog)
            <div class="col-xl-3 col-lg-4 col-md-6  mb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/thumb_'.$blog->data_values->image,'425x240') }}" alt="blog">
                    </div>
                    <div class="blog-content">
                        <h4 class="title"><a href="{{ route('blog.details',[slug($blog->data_values->title),$blog->id]) }}">{{ shortDescription($blog->data_values->title,45) }}</a></h4>
                        <div class="blog-post">
                            <div class="right">
                                <span>{{ $blog->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
