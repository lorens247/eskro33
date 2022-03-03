@extends('admin.layouts.app')
@tsknav('frontend')
@section('panel')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.frontend.sections.content', $key) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="element">
                        @if(@$data)
                            <input type="hidden" name="id" value="{{$data->id}}">
                        @endif
                        <div class="row">
                            @php
                                $imgCount = 0;
                            @endphp
                            @foreach($section->element as $k => $content)
                                @if($k == 'images')
                                    @php
                                        $imgCount = collect($content)->count();
                                    @endphp
                                    @foreach($content as $imgKey => $image)
                                            <div class="col-md-4">
                                                <input type="hidden" name="has_image[]" value="1">
                                                <div class="form-group">
                                                    <label>{{ __(inputTitle($imgKey)) }}</label>
                                                    <div class="image-upload">
                                                        <div class="thumb">
                                                            <div class="avatar-preview">
                                                                <div class="profilePicPreview" style="background-image: url({{getImage('assets/images/frontend/' . $key .'/'. @$data->data_values->$imgKey,@$section->element->images->$imgKey->size) }})">
                                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                                </div>
                                                                <label for="profilePicUpload{{ $loop->index }}" class="upload-image"><i class="las la-camera"></i></label>
                                                            </div>
                                                            <div class="avatar-edit">
                                                                <input type="file" class="profilePicUpload" name="image_input[{{ $imgKey }}]" id="profilePicUpload{{ $loop->index }}" accept=".png, .jpg, .jpeg">
                                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png')</b>.
                                                                    @if(@$section->element->images->$imgKey->size)
                                                                        | @lang('Will be resized to'):
                                                                        <b>{{@$section->element->images->$imgKey->size}}</b>
                                                                        @lang('px').
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                    <div class="@if($imgCount > 1) col-md-12 @else col-md-8 @endif">
                                        @push('divend')
                                    </div>
                                        @endpush

                                    @elseif($content == 'icon')

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __(inputTitle($k)) }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control iconPicker icon" name="{{ $k }}" value="{{ @$data->data_values->$k }}" required>
                                                    <button class="input-group-text" data-icon="{{ @$data->data_values->$k ? substr(@$data->data_values->$k,10,-6) : 'las la-home' }}" role="iconpicker"></button>
                                                </div>
                                            </div>
                                        </div>

                                @else
                                    @if($content == 'textarea')

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __(inputTitle($k)) }}</label>
                                                <textarea rows="10" class="form-control" placeholder="{{ __(inputTitle($k)) }}" name="{{$k}}" required>{{ @$data->data_values->$k}}</textarea>
                                            </div>
                                        </div>

                                    @elseif($content == 'textarea-nic')

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __(inputTitle($k)) }}</label>
                                                <textarea rows="10" class="form-control nicEdit" placeholder="{{ __(inputTitle($k)) }}" name="{{$k}}" >{{ @$data->data_values->$k}}</textarea>
                                            </div>
                                        </div>

                                    @elseif($k == 'select')
                                        @php
                                            $selectName = $content->name;
                                        @endphp
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="  fw-bold">{{__(inputTitle(@$selectName))}}</label>
                                                    <select class="form-control" name="{{ @$selectName }}">
                                                        @foreach($content->options as $selectItemKey => $selectOption)
                                                            <option value="{{ $selectItemKey }}" @if(@$data->data_values->$selectName == $selectItemKey) selected @endif>{{ __($selectOption) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                    @else

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __(inputTitle($k)) }}</label>
                                                <input type="text" class="form-control" placeholder="{{ __(inputTitle($k)) }}" name="{{$k}}" value="{{ @$data->data_values->$k }}" required/>
                                            </div>
                                        </div>

                                    @endif
                                @endif
                            @endforeach
                            @stack('divend')
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



@push('breadcrumb-plugins')
    <a href="{{route('admin.frontend.sections',$key)}}" class="btn btn-sm btn-outline--primary"><i class="las la-undo"></i> @lang('Back')</a>
@endpush

@push('style-lib')
<link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush


@push('script')
    <script>

        (function ($) {
            "use strict";
            $('.iconPicker').iconpicker().on('iconpickerSelected', function (e) {
                $('.iconPicker').val(`<i class="${e.iconpickerValue}"></i>`);
            });
        })(jQuery);
    </script>
@endpush
