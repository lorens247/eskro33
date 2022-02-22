@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="table-area">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Trx')</th>
                                    <th>@lang('Transacted')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                <tr>

                                    <td data-label="@lang('Trx')">
                                        <strong>{{ $trx->trx }}</strong>
                                    </td>

                                    <td data-label="@lang('Transacted')">
                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                    </td>

                                    <td data-label="@lang('Amount')" class="budget">
                                        <span class="font-weight-bold @if($trx->trx_type == '+') text--success @else text--danger @endif">
                                            {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $general->cur_text }}
                                        </span>
                                    </td>

                                    <td data-label="@lang('Post Balance')" class="budget">
                                    {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                </td>


                                <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
