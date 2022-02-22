@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(($escrow->status != 1) && ($escrow->status != 8) && ($escrow->status != 9))
                <div class="text-end mb-4">
                    @if(($escrow->buyer_id == auth()->user()->id) && ($restAmo > 0))
                        <button class="btn btn--base btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">@lang('Create Milestone')</button>
                    @endif
                </div>
                @endif

                <div class="table-area">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Note')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Payment Status')</th>
                                @if(($escrow->buyer_id == auth()->user()->id) && ($restAmo > 0))
                                <th>@lang('Action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($milestones as $milestone)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($milestone->created_at,'Y-m-d') }}</td>
                                    <td data-label="@lang('Note')">{{ __($milestone->note) }}</td>
                                    <td data-label="@lang('Amount')">{{ $general->cur_sym }}{{ showAmount($milestone->amount) }}</td>
                                    <td data-label="@lang('Payment Status')">
                                        @if($milestone->payment_status == 1)
                                            <span class="badge badge--success">@lang('Funded')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Unfunded')</span>
                                        @endif
                                    </td>
                                    @if(($escrow->buyer_id == auth()->user()->id) && ($restAmo > 0))
                                    <td data-label="@lang('Action')">
                                        <button class="btn btn--primary btn-sm @if($milestone->payment_status == 1) disabled @else payBtn @endif" data-bs-toggle="modal" data-bs-target="#payModal" data-milestone_id="{{ $milestone->id }}">@lang('Pay Now')</button>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{$milestones->links()}}
            </div>
        </div>

        <div class="modal fade" id="addModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">@lang('Create Milestone')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
                </div>
                <form action="{{ route('user.escrow.milestone.create') }}" method="post">
                    @csrf
                    <input type="hidden" name="escrow_id" value="{{ $escrow->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Note')</label>
                            <input type="text" name="note" class="form--control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="text" name="amount" class="form--control form-control" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
            </div>
        </div>

        <div class="modal fade" id="payModal">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">@lang('Pay Milestone')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
                </div>
                <form action="{{ route('user.escrow.milestone.pay') }}" method="post">
                    @csrf
                    <input type="hidden" name="milestone_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Select Payment Type')</label>
                            <select name="pay_via" class="form--control">
                                <option value="1">@lang('Wallet') - {{ showAmount(auth()->user()->balance) }} {{ $general->cur_text }}</option>
                                <option value="2">@lang('Checkout')</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base btn-block">@lang('Submit')</button>
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

            $('.payBtn').on('click',function () {
                var modal = $('#payModal');
                modal.find('[name=milestone_id]').val($(this).data('milestone_id'));
            })
        })(jQuery);
    </script>
@endpush
