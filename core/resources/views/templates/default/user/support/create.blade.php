@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom--card">
                    <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data">
                    <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">@lang('Name')</label>
                                    <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form--control" placeholder="@lang('Enter your name')" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">@lang('Email address')</label>
                                    <input type="email"  name="email" value="{{@$user->email}}" class="form--control" placeholder="@lang('Enter your email')" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="website">@lang('Subject')</label>
                                    <input type="text" name="subject" value="{{old('subject')}}" class="form--control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="priority">@lang('Priority')</label>
                                    <select name="priority" class="form--control ">
                                        <option value="3">@lang('High')</option>
                                        <option value="2">@lang('Medium')</option>
                                        <option value="1">@lang('Low')</option>
                                    </select>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="inputMessage">@lang('Message')</label>
                                    <textarea name="message" id="inputMessage" rows="6" class="form--control" required>{{old('message')}}</textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 file-upload">
                                    <label for="inputAttachments">@lang('Attachments')</label>
                                    <div class="d-flex">
                                        <input type="file" name="attachments[]" id="inputAttachments" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx" class="form--control form-control mb-2" />
                                        <button type="button" class="btn btn--success btn-sm addFile h--45 ms-2">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div id="fileUploadsContainer"></div>
                                    <p class="ticket-attachments-message text-muted">
                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn--base btn-block" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .h--45{
        width: 45px;
        height: 45px;
    }

    .btn--danger{
        background-color: #ea5455;
    }
</style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx" required />
                        <button class="btn--danger input-group-text support-btn remove-btn"><i class="fas fa-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
