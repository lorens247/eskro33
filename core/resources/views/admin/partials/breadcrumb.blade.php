
<div class="row">
    <div class="col-lg-12">
        @stack('tsknav')
    </div>
</div>

<div class="row align-items-center gy-3 mb-4 justify-content-between">
    <div class="col-xl-6 col-lg-4 col-sm-6">
        <h6 class="page-title">{{ __($pageTitle) }}</h6>
    </div>
    <div class="col-xl-6 col-lg-8 col-sm-6 text-sm-end mt-sm-0 mt-3 right-part">
        @stack('breadcrumb-plugins')
    </div>
</div>

@push('script')
<script>
    $('.breadcum-nav-open').on('click', function(){
        $(this).toggleClass('active');
        $('.breadcum-nav').toggleClass('active');
    });
    $('.breadcum-nav-close').on('click', function(){
        $('.breadcum-nav').removeClass('active');
    });
</script>
@endpush