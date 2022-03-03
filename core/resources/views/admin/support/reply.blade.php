@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title  mb-4">
                        <div class="row">
                            <div class="col-sm-8 col-md-6">
                                @if($ticket->status == 0)
                                    <span class="badge badge--success py-1 px-2">@lang('Open')</span>
                                @elseif($ticket->status == 1)
                                    <span class="badge badge--primary py-1 px-2">@lang('Answered')</span>
                                @elseif($ticket->status == 2)
                                    <span class="badge badge--warning py-1 px-2">@lang('Customer Reply')</span>
                                @elseif($ticket->status == 3)
                                    <span class="badge badge--dark py-1 px-2">@lang('Closed')</span>
                                @endif
                                [@lang('Ticket#'){{ $ticket->ticket }}] {{ $ticket->subject }}
                            </div>
                            <div class="col-sm-4  col-md-6 text-sm-end mt-sm-0 mt-3">
                                @if($ticket->status != 3)
                                <button class="btn btn--danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#DelModal">
                                    <i class="fa fa-lg fa-times-circle"></i> @lang('Close Ticket')
                                </button>
                                @endif
                            </div>
                        </div>
                    </h6>
                    <form action="{{ route('admin.ticket.reply', $ticket->id) }}" enctype="multipart/form-data" method="post" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ticket-reply-inbox">
                                    <textarea class="form-control" name="message" rows="3" id="inputMessage" placeholder="@lang('Your Message')"></textarea>
                                    <button type="button" class="ticket-reply-attachment"><i class="fas fa-paperclip"></i> Add attachment</button>
                                    <button class="btn btn--primary ticket-reply-btn" type="submit" name="replayTicket" value="1"> @lang('Reply') <i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="attachment-area">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="inputAttachments">@lang('Attachments')</label>
                                </div>
                                <div class="col-md-11 col-9">
                                    <div class="file-upload-wrapper" data-text="@lang('Select your file!')">
                                        <input type="file" name="attachments[]" id="inputAttachments"
                                        class="file-upload-field"/>
                                    </div>
                                    <div id="fileUploadsContainer"></div>
                                </div>
                                <div class="col-md-1 col-3">
                                    <button type="button" class="btn btn-block btn--dark extraTicketAttachment"><i class="fa fa-plus"></i></button>
                                </div>
                                <div class="col-md-12 ticket-attachments-message text-muted mt-2">
                                    <small>@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->

            <div class="card mt-5">
                <div class="card-body">
                    @foreach($messages as $message)
                        @if($message->admin_id == 0)
                            <div class="ticket-reply-single">
                                <div class="reply-box">
                                    <div class="top">
                                        <div class="left">
                                            <p>
                                                <span class="me-2">
                                                    <span class="name">{{ $ticket->name }}</span>
                                                    @if($ticket->user_id != null)
                                                        <a href="{{route('admin.users.detail', $ticket->user_id)}}" > &nbsp; @<span>{{ $ticket->user->username }}</span> </a>
                                                    @else
                                                        <p>&nbsp; @<span>({{$ticket->name}})</span></p>
                                                    @endif
                                                </span>
                                                <i>@lang('Posted on') {{ showDateTime($message->created_at) }} ({{ diffForHumans($message->created_at) }})</i>
                                            </p>
                                        </div>
                                        <div class="right">
                                            <button data-id="{{$message->id}}" type="button" data-bs-toggle="modal" data-bs-target="#DelMessage" class="btn btn-outline--danger btn-sm delete-message"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>

                                    <p>@php echo nl2br($message->message) @endphp</p>
                                    @if($message->attachments->count() > 0)
                                        <div class="mt-3">
                                            @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="me-3"><i class="fa fa-file"></i>@lang('Attachment') {{++$k}}</a>
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
                                                    <span class="name">{{ @$message->admin->name }}</span>
                                                    (@lang('Staff'))
                                                </span>
                                                <i>@lang('Posted on') {{showDateTime($message->created_at) }} ({{ diffForHumans($message->created_at) }})</i>
                                            </p>
                                        </div>
                                        <div class="right">
                                            <button data-id="{{$message->id}}" type="button" data-bs-toggle="modal" data-bs-target="#DelMessage" class="btn btn-outline--danger btn-sm delete-message"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                    <p>@php echo nl2br($message->message) @endphp</p>
                                    @if($message->attachments->count() > 0)
                                        <div class="mt-3">
                                            @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="ticket-attach-file me-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
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




    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Close Support Ticket!')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to close this support ticket?')</p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.ticket.reply', $ticket->id) }}">
                        @csrf

                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close') </button>
                        <button type="submit" class="btn btn--success" name="replayTicket" value="2"> @lang('Close Ticket') </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="DelMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Reply!')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"><i class="las la-times text-white"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>@lang('Are you sure to delete this?')</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.ticket.delete')}}">
                        @csrf
                        <input type="hidden" name="message_id" class="message_id">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No') </button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-trash"></i> @lang('Delete') </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection




@push('breadcrumb-plugins')
    <a href="{{ route('admin.ticket') }}" class="btn btn-sm btn-outline--primary box--shadow1 text--small"><i class="las la-undo"></i> @lang('Back') </a>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            })
            $('.extraTicketAttachment').on('click',function(){
                $("#fileUploadsContainer").append(`
                <div class="file-upload-wrapper" data-text="@lang('Select your file!')"><input type="file" name="attachments[]" id="inputAttachments" class="file-upload-field"/></div>`)
            });

            $('.ticket-reply-attachment').on('click', function(){
                $('.attachment-area').slideDown();
            });
        })(jQuery);
    </script>
@endpush
