@extends('admin.layouts.app')
@tsknav('setting')
@section('panel')

    <div class="row">
        <div class="col-md-12">
            <div class="alert-primary p-3 mb-4 text-center">
                <h6 class="mb-3">@lang('While you are inputting a new key, you should know and make sure the below things'):</h6>
                <span class="me-3 mb-2"><i class="las la-info-circle text--primary"></i> @lang('The key is case sensitive') </span>
                <span class="me-3 mb-2"><i class="las la-info-circle text--primary"></i> @lang('The key should not contain any extra space') </span>
                <span class="me-3 mb-2"><i class="las la-info-circle text--primary"></i> @lang('The key will be added to this language only') </span>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table white-space-wrap" id="myTable">
                            <thead>
                            <tr>
                                <th>@lang('Key')
                                </th>
                                <th class="text-left">
                                    {{__($lang->name)}}
                                </th>

                                <th class="w-85">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($json as $k => $language)
                                <tr>
                                    <td data-label="@lang('key')" class="white-space-wrap">{{$k}}</td>
                                    <td data-label="@lang('Value')" class="text-start white-space-wrap">{{$language}}</td>


                                    <td data-label="@lang('Action')">
                                        <button
                                           data-bs-target="#editModal"
                                           data-bs-toggle="modal"
                                           data-title="{{$k}}"
                                           data-key="{{$k}}"
                                           data-value="{{$language}}"
                                           class="editModal btn btn-sm btn-outline--primary ml-1">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </button>

                                        <button
                                           data-key="{{$k}}"
                                           data-value="{{$language}}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#DelModal"
                                           class="btn btn-sm btn-outline--danger ml-1 deleteKey">
                                            <i class="la la-trash"></i> @lang('Remove')
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel"> @lang('Add New')</h4>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.setting.language.store.key',$lang->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="key" class="fw-bold">@lang('Key')</label>
                            <textarea class="form-control " rows="3" id="key" name="key" placeholder="@lang('Key')">{{old('key')}}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="value" class="fw-bold">@lang('Value')</label>
                            <textarea class="form-control " rows="3" id="value" name="value" placeholder="@lang('Value')">{{old('value')}}</textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block"> @lang('Submit')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">@lang('Edit')</h4>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.setting.language.update.key',$lang->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="inputName" class="fw-bold form-title"></label>
                            <textarea class="form-control " rows="3" name="value" placeholder="@lang('Value')"></textarea>
                        </div>
                        <input type="hidden" name="key">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Modal for DELETE -->
    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="DelModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="DelModalLabel"><i class='fa fa-trash'></i> @lang('Delete')!</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>@lang('Are you sure to delete?')</strong>
                </div>
                <form action="{{route('admin.setting.language.delete.key',$lang->id)}}" method="post">
                    @csrf
                    <input type="hidden" name="key">
                    <input type="hidden" name="value">
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Import Modal --}}
    <div class="modal fade" id="importModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Import Language')</h4>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center text--danger">@lang('If you import keywords, Your current keywords will be removed and replaced by imported keyword')</p>
                        <div class="form-group">
                        <label for="key" class="fw-bold">@lang('Key')</label>
                        <select class="form-control select_lang"  required>
                            <option value="">@lang('Import Keywords')</option>
                            @foreach($list_lang as $data)
                            <option value="{{$data->id}}" @if($data->id == $lang->id) class="d-none" @endif >{{__($data->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--primary btn-block import_lang"> @lang('Submit')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
<button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-outline--primary"><i class="las la-plus"></i> @lang('Add New Key') </button>
<button type="button" class="btn btn-sm btn-outline--primary box--shadow1 importBtn"><i class="la la-download"></i>@lang('Import Language')</button>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            $(document).on('click','.deleteKey',function () {
                var modal = $('#DelModal');
                modal.find('input[name=key]').val($(this).data('key'));
                modal.find('input[name=value]').val($(this).data('value'));
            });
            $(document).on('click','.editModal',function () {
                var modal = $('#editModal');
                modal.find('.form-title').text($(this).data('title'));
                modal.find('input[name=key]').val($(this).data('key'));
                modal.find('textarea[name=value]').val($(this).data('value'));
            });


            $(document).on('click','.importBtn',function () {
                $('#importModal').modal('show');
            });
            $(document).on('click','.import_lang',function(e){
                var id = $('.select_lang').val();

                if(id ==''){
                    notify('error','Invalide selection');

                    return 0;
                }else{
                    $.ajax({
                        type:"post",
                        url:"{{route('admin.setting.language.importLang')}}",
                        data:{
                            id : id,
                            toLangid : "{{$lang->id}}",
                            _token: "{{csrf_token()}}"
                        },
                        success:function(data){
                            if (data == 'success'){
                                notify('success','Import Data Successfully');
                                window.location.href = "{{url()->current()}}"
                            }
                        }
                    });
                }

            });
        })(jQuery);
    </script>
@endpush
