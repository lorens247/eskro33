@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 ">
                    <div class="table-area">
                        <table class="custom-table">
                            <thead>
                            <tr>
                                <th>@lang('Gateway | Trx')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('After Charge')</th>
                                <th>@lang('Rate')</th>
                                <th>@lang('Receivable')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($withdraws as $k=>$data)
                                <tr>
                                    <td data-label="@lang('Gateway | Trx')">
                                        <span class="fw-bold">{{ __(@$data->method->name) }}</span>
                                        <br>
                                        <small>{{ $data->trx }}</small>
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{showAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Charge')">
                                        <strong class="text--danger">{{showAmount($data->charge)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('After Charge')">
                                        {{showAmount($data->after_charge)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Rate')">
                                        {{showAmount($data->rate)}} {{__($data->currency)}}
                                    </td>
                                    <td data-label="@lang('Receivable')">
                                        <strong class="text--success">{{showAmount($data->final_amount)}} {{__($data->currency)}}</strong>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($data->status == 2)
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                        @elseif($data->status == 1)
                                            <span class="badge badge--success">@lang('Completed')</span>
                                            <button class="btn--info btn-rounded  badge approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                        @elseif($data->status == 3)
                                            <span class="badge badge--danger">@lang('Rejected')</span>
                                            <button class="btn--info btn-rounded badge approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                        @endif

                                    </td>
                                    <td data-label="@lang('Time')">
                                        {{showDateTime($data->created_at,'Y-m-d')}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $withdraws->links() }}
                    </div>
                </div>
            </div>

            {{-- Detail MODAL --}}
            <div id="detailModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('Details')</h5>
                            <button type="button" class="close bg--danger" data-bs-dismiss="modal">
                                <span class="text-white">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="withdraw-detail"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);

    </script>
@endpush
