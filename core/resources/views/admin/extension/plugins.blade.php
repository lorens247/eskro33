@extends('admin.layouts.app')
@tsknav('extension')
@section('panel')
<div class="row">
    @if($plugins->type == 'error')
        @php echo $plugins->message @endphp
    @endif
	@if($plugins->body)
    @foreach($plugins->body as $plugin)
    @php $installed = $myPlugins->where('file_key',$plugin->item_key)->first(); @endphp
	<div class="col-md-6 col-xl-4">
        <div class="card mb-4 @if($installed && ($installed->version < $plugin->version)) update-available @endif">
            <div class="card-header bg--primary d-flex justify-content-between position-relative">
            	<h4 class="card-title text-white mb-0"> {{ __($plugin->name) }} </h4>
                @if($installed)
                    <button class="btn btn-sm btn--info"><i class="las la-check-double"></i>@lang('Installed')</button>
                @else
            	<a href="{{ $plugin->buy_url }}" target="_blank" class="btn btn-sm btn--success"><i class="las la-shopping-cart"></i>@lang('Purchase Now')</a>
                @endif
            </div>
            @if($installed && ($installed->version < $plugin->version))
            <div class="text-center card--overlay-btns">
                <h3 class="text-white mb-3">
                    V - {{ $plugin->version }} @lang('is available')
                </h3>
                <button class="btn btn--warning versionText" data-content="{{ $plugin->version_text }}"><i class="las la-eye"></i> @lang('What\'s New')</button>
                <a href="{{ $plugin->version_url }}" target="_blank" class="btn btn--primary"><i class="las la-download"></i> @lang('Download')</a>
            </div>
            @endif
            <div class="card-body p-0">
                <img src="{{ $plugin->image_url }}" alt="Thumbnail" class="w-100">
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
<div class="modal fade" id="versionNote">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Version Update Note')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="version-text"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    (function($){
        $('.versionText').click(function(){
            var modal = $('#versionNote');
            modal.find('.version-text').html($(this).data('content'));
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush

