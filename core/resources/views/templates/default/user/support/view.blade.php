@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8 col-md-6 mb-3">
                                @if($my_ticket->status == 0)
                                    <span class="badge bg--success">@lang('Open')</span>
                                @elseif($my_ticket->status == 1)
                                    <span class="badge bg--primary">@lang('Answered')</span>
                                @elseif($my_ticket->status == 2)
                                    <span class="badge bg--warning">@lang('Replied')</span>
                                @elseif($my_ticket->status == 3)
                                    <span class="badge bg--dark">@lang('Closed')</span>
                                @endif
                                [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ __($my_ticket->subject) }}
                            </div>
                            @if($my_ticket->status != 3)
                            <div class="col-sm-4  col-md-6 text-sm-end mt-sm-0 mt-3 mb-3">
                                <button class="btn btn--danger btn-sm d-inline-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#DelModal">
                                    <i class="fa fa-times-circle me-1"></i> @lang('Close Ticket')
                                </button>
                            </div>
                            @endif
                        </div>
                        <form action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data" method="post" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="replayTicket" value="1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ticket-reply-inbox">
                                        <textarea class="form-control" name="message" rows="3" id="inputMessage" placeholder="@lang('Your Message')" required></textarea>
                                        <button type="button" class="ticket-reply-attachment"><i class="fas fa-paperclip"></i> @lang('Add attachment')</button>
                                        <button class="btn btn--base ticket-reply-btn" type="submit"> @lang('Reply') <i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="attachment-area">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label for="inputAttachments">@lang('Attachments')</label>
                                    </div>
                                    <div class="col-md-11 col-9">
                                        <div class="file-upload-wrapper" data-text="Select your file!">
                                            <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx" class="form-control">
                                        </div>
                                        <div id="fileUploadsContainer"></div>
                                    </div>
                                    <div class="col-md-1 col-3">
                                        <button type="button" class="btn w-100 btn--dark addFile py-2"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="col-md-12 ticket-attachments-message text-muted mt-2">
                                        <small>@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- card end -->

                <div class="card custom--card mt-5">
                    <div class="card-body">
                        @foreach($messages as $message)
                        @if($message->admin_id == 0)
                        <div class="ticket-reply-single">
                            <div class="reply-box">
                                <div class="top">
                                    <div class="left">
                                        <p>
                                            <span class="me-2">
                                                <span class="name">{{ __($message->ticket->name) }}</span>
                                            </span>
                                            <i>@lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }} ({{ $message->created_at->diffForHumans() }})</i>
                                        </p>
                                    </div>
                                </div>
                                <p>@php echo nl2br($message->message) @endphp</p>
                                @if($message->attachments->count() > 0)
                                <div class="mt-3">
                                    @foreach($message->attachments as $k=> $image)
                                        <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="ticket-reply-single admin-reply">
                            <div class="reply-box">
                                <div class="top">
                                    <div class="left">
                                        <p>
                                            <span class="me-2">
                                                <span class="name">{{ $message->admin->name }}</span>
                                            </span>
                                            <i>@lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }} ({{ $message->created_at->diffForHumans() }})</i>
                                        </p>
                                    </div>
                                </div>

                                <p>@php echo nl2br($message->message) @endphp</p>
                                @if($message->attachments->count() > 0)
                                <div class="mt-3">
                                    @foreach($message->attachments as $k=> $image)
                                        <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div><!-- card end -->

                </div>
            </div>
        </div>

        <div class="modal fade" id="DelModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
                </div>
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-body">
                        <strong>@lang('Are you sure you want to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal"> @lang('No') </button>
                        <button type="submit" class="btn btn--success btn-sm"> @lang('Yes') </button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`<div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form--control form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx" required />
                        <button class="input-group-text btn btn--danger support-btn remove-btn"><i class="fas fa-times"></i></button>
                    </div>`
                )
            });

            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });

            $('.ticket-reply-attachment').on('click', function(){
                $('.attachment-area').slideDown();
            });
        })(jQuery);

    </script>
@endpush
