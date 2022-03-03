@extends('admin.layouts.app')
@tsknav('frontend')
@section('panel')
@if($pdata->is_default == 0)
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.frontend.manage.pages.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pdata->id }}">
                    <div class="row gy-3 align-items-end">
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label>@lang('Page Name')</label>
                                <input type="text" class="form-control " placeholder="@lang('Page Name')" name="name" value="{{ $pdata->name }}"
                                required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label>@lang('Page Slug') </label>
                                <input type="text" class="form-control " placeholder="@lang('Page Slug')" name="slug" value="{{ $pdata->slug }}"
                                required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif


<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__($pdata->name)}} @lang('Page')</h3>
                <small class="text--primary">@lang('If you face any issue with removing sections, Please click the update button and then remove unnecessary sections and click the update button again.')</small>
            </div>

            <div class="card-body">
                <form action="{{route('admin.frontend.manage.section.update',$pdata->id)}}" method="post">
                    @csrf
                    <ol class="simple_with_drop vertical section-list section-listed">
                        @if($pdata->secs != null)
                        @foreach(json_decode($pdata->secs) as $sec)
                        <li class="highlight icon-move item">
                            <i class="las la-exchange-alt first-icon"></i>
                            <span class="d-inline-block section-list-title"> {{ __(@$sections[$sec]['name']) }}</span>
                            <i class="d-inline-block remove-icon fa fa-times"></i>
                            <input type="hidden" name="secs[]" value="{{$sec}}">
                        </li>
                        @endforeach
                        @endif
                    </ol>
                    <button type="submit" class="btn btn--primary btn-block btn-lg ">@lang('Update Now')</button>
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-5 mt-md-0 mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Sections')</h3>
                <small class="text--primary">@lang('Drag the section to the left side you want to show on the page.')</small>
            </div>
            <div class="card-body">
                <ol class="simple_with_no_drop vertical section-list">
                    @foreach($sections as $k => $secs)
                    @if(!@$secs['no_selection'])
                    <li class="highlight icon-move">
                            <i class="las la-arrows-alt first-icon"></i>
                            <span class="d-inline-block section-list-title"> {{__($secs['name'])}}</span>
                            <i class="ms-auto d-inline-block remove-icon fa fa-times"></i>
                            <input type="hidden" name="secs[]" value="{{$k}}">
                            @if($secs['builder'])
                                <div class="manage-content">
                                    <a href="{{ route('admin.frontend.sections',$k) }}" target="_blank" class="cog-btn"  data-toggle="tooltip" data-original-title="@lang('Manage Content')">
                                        <i class="fa fa-cog p-0 m-0"></i>
                                    </a>
                                </div>
                            @endif
                    </li>
                    @endif
                    @endforeach
                </ol>
            </div>
        </div>

    </div>
</div>
@stop

@push('script-lib')
<script src="{{asset('assets/admin/js/jquery-sortable.js')}}"></script>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";
        $("ol.simple_with_drop").sortable({
            group: 'no-drop',
            handle: '.icon-move',
            onDragStart: function ($item, container, _super) {
                    // Duplicate items of the no drop area
                    if(!container.options.drop){
                        $item.clone().insertAfter($item);
                    }
                    _super($item, container);
                }
            });
        $("ol.simple_with_no_drop").sortable({
            group: 'no-drop',
            drop: false
        });
        $("ol.simple_with_no_drag").sortable({
            group: 'no-drop',
            drag: false
        });
        $(".remove-icon").on('click',function(){
            $(this).parent('.highlight').remove();
        });

    })(jQuery);
</script>
@endpush


@push('breadcrumb-plugins')
<a href="{{route('admin.frontend.manage.pages')}}"  class="btn btn-sm btn-outline--primary"><i class="la la-undo"></i> @lang('Back') </a>
@endpush
