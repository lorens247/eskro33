@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="custom--card">
                    <div class="card-header">
                        <div class="text-end">
                            <a href="{{ route('user.escrow.milestone',encrypt($escrow->id)) }}" class="btn btn-sm btn--dark">@lang('See Milestones') <i class="las la-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ __($escrow->details) }}</p>
                        <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Buyer - Seller')</span>
                            <span>@lang('I\'m') @if($escrow->buyer_id == auth()->user()->id) @lang('buying from') {{ __(@$escrow->seller->username ?? $escrow->invitation_mail) }} @else @lang('selling to') {{ __(@$escrow->buyer->username ?? $escrow->invitation_mail) }} @endif</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Amount')</span>
                            <span>{{ showAmount($escrow->amount) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Charge')</span>
                            <span>{{ showAmount($escrow->charge) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Charge Payer')</span>
                            <span>
                                @if($escrow->charge_payer == 1)
                                    <span class="badge badge--dark">@lang('Seller')</span>
                                @elseif($escrow->charge_payer == 2)
                                    <span class="badge badge--info">@lang('Buyer')</span>
                                @else
                                    <span class="badge badge--success">@lang('50%-50%')</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Status')</span>
                            <span>
                                @php echo $escrow->escrowStatus @endphp
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Milestone Created')</span>
                            <span>{{ showAmount($escrow->milestones->sum('amount')) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Milestone Funded')</span>
                            <span>{{ showAmount($escrow->milestones->where('payment_status',1)->sum('amount')) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Milestone Unfunded')</span>
                            <span>{{ showAmount($escrow->milestones->where('payment_status',0)->sum('amount')) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-bold">@lang('Rest Amount')</span>
                            <span>{{ showAmount($restAmo) }} {{ $general->cur_text }}</span>
                        </li>
                        @if($escrow->status == 8)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">@lang('Disputed By')</span>
                                <span>{{ $escrow->disputer->username }}</span>
                            </li>
                        @endif
                        </ul>
                        @if($escrow->status == 8)
                            <div class="mt-2">
                                <h5 class="mb-2">@lang('Disputed Reason'):</h5>
                                <p>{{ __($escrow->dispute_note) }}</p>
                            </div>
                        @endif
                        @if(($restAmo <= 0))
                            @if($escrow->status == 0)
                                <h4 class="text-center text--warning mt-3 mb-0">@lang('The full amount has been paid, but the escrow is not accepted yet. To dispatch the payment, the escrow must be accepted')</h4>
                            @endif
                        @endif
                    </div>

                    {{-- Don't show these buttons if already the payment is disputed or dispatched or cancelled --}}
                    @if(($escrow->status != 1) && ($escrow->status != 8) && ($escrow->status != 9) && ($escrow->paid_amount > 0 || $escrow->status == 0))
                        <div class="card-footer">

                            {{-- show cancel button for both and accept button for receiver user if the escrow not started yet --}}
                            @if($escrow->status == 0)
                                @if($escrow->creator_id != auth()->id())
                                    <button class="btn btn--success" data-bs-toggle="modal" data-bs-target="#acceptModal">@lang('Accept')</button>
                                @endif
                                <button class="btn btn--warning text-white" data-bs-toggle="modal" data-bs-target="#cancelModal">@lang('Cancel')</button>
                            @endif

                            {{-- show payment dispatch button for buyer if all amount is paid and the escrow is accepted --}}
                            @if(($restAmo <= 0) && ($escrow->status == 2) && ($escrow->buyer_id == auth()->user()->id))
                                <button class="btn btn--primary" data-bs-toggle="modal" data-bs-target="#dispatchModal">@lang('Dispatch Payment')</button>
                            @endif

                            {{-- payment dispute button --}}
                            @if($escrow->paid_amount > 0)
                                <button class="btn btn--danger text-white" data-bs-toggle="modal" data-bs-target="#disputeModal">@lang('Dispute Escrow')</button>
                            @endif


                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="msg-container">
                    <div class="custom--card">
                        <div class="card-header">
                            <div class="text-end">
                                <button class="btn btn--dark btn-sm reloadButton"><i class="las la-redo-alt"></i></button>
                            </div>
                        </div>
                        <div class="card-body msg_history">
                            <div class="messaging">
                                <div class="inbox_msg">
                                    <ul class="msg-list d-flex flex-column">
                                        @foreach($messages as $message)
                                        @php
                                            $classText = $message->sender_id == auth()->user()->id ? 'send' : 'receive';
                                        @endphp
                                        <li class="msg-list__item">
                                            <div class="msg-{{ $classText }}">
                                                @if(($escrow->status == 8) && ($message->sender_id !=  auth()->id()))
                                                    <p class="mb-0">{{ @$message->sender->username ?? $message->admin->username }}</p>
                                                @endif
                                                <div class="msg-{{ $classText }}__content">
                                                    <p class="msg-{{ $classText }}__text mb-0">
                                                        {{ __($message->message) }}
                                                    </p>
                                                </div>
                                                <ul class="msg-{{ $classText }}__history @if($classText == 'send') justify-content-end @endif">
                                                    <li class="msg-receive__history-item">{{ $message->created_at->format('h:i A') }}</li>
                                                    <li class="msg-receive__history-item">{{ $message->created_at->diffForHumans() }}</li>
                                                </ul>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="msg-option">
                        <form class="message-form">
                            <div class="msg-option__content rounded-pill">
                                <div class="msg-option__group ">
                                    <input type="text" class="form-control msg-option__input" name="message" autocomplete="off" placeholder="@lang('Send Message')">
                                    <button type="submit" class="btn bg--base msg-option__button rounded-pill">
                                        <i class="lab la-telegram-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="dispatchModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">@lang('Dispatch Escrow')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
                </div>
                <form action="{{ route('user.escrow.dispatch') }}" method="post">
                    @csrf
                    <input type="hidden" name="escrow_id" value="{{ $escrow->id }}">
                    <div class="modal-body">
                        <h5>@lang('Are you sure to dispatch this escrow?')</h5>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-sm bg--base text-white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
            </div>
        </div>


        <div class="modal fade" id="disputeModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">@lang('Dispatch Escrow')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
                </div>
                <form action="{{ route('user.escrow.dispute') }}" method="post">
                    @csrf
                    <input type="hidden" name="escrow_id" value="{{ $escrow->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea name="details" class="form--control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
            </div>
        </div>


        <div class="modal fade" id="cancelModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">@lang('Cancel Escrow')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
                </div>
                <form action="{{ route('user.escrow.cancel',encrypt($escrow->id)) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <h5 class="text-center">@lang('Are you sure to cancel this escrow?')</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-sm bg--base text-white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
            </div>
        </div>

        <div class="modal fade" id="acceptModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Accept Escrow')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.escrow.accept',encrypt($escrow->id)) }}" method="post">
                    @csrf
                        <div class="modal-body">
                            <h5 class="text-center">@lang('Are you sure to accept this escrow?')</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn-sm bg--base text-white">@lang('Yes')</button>
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
        (function($){
        "use strict"

            $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1);

            $('.message-form').submit(function (e) {
                e.preventDefault();
                $(this).find('button[type=submit]').removeAttr('disabled');
                var url = '{{ route('user.escrow.message.reply') }}';
                var data = {
                    _token:"{{ csrf_token() }}",
                    conversation_id:"{{ $conversation->id }}",
                    message:$(this).find('[name=message]').val()
                }
                $.post(url, data, function (response) {
                    if(response['error']){
                        response['error'].forEach(message => {
                            notify('error',message);
                        });
                        return true;
                    }

                    var html = `
                            <li class="msg-list__item">
                                <div class="msg-send">
                                    <div class="msg-send__content">
                                        <p class="msg-send__text mb-0">
                                            ${response['message']}
                                        </p>
                                    </div>
                                    <ul class="msg-send__history  justify-content-end ">
                                        <li class="msg-receive__history-item">${response['created_time']}</li>
                                        <li class="msg-receive__history-item">${response['created_diff']}</li>
                                    </ul>
                                </div>
                            </li>
                    `;

                    $('.msg-list').append(html);
                    $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1);
                });
                $(this).find('[name=message]').val('')

            });

            $('.reloadButton').click(function () {
                var url = '{{ route('user.escrow.message.get') }}';
                var data = {
                    conversation_id:"{{ $conversation->id }}"
                }
                $.get(url, data,function(response) {
                    if(response['error']){
                        response['error'].forEach(message => {
                            notify('error',message);
                        });
                        return true;
                    }
                    $('.msg-list').html(response);
                    $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1);

                });

            });
        })(jQuery);
    </script>
@endpush
