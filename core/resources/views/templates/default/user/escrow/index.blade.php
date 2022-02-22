@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="table-area">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Buyer - Seller')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Charge Payer')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($escrows as $escrow)
                                    <tr>
                                        <td data-label="@lang('Title')">{{ __($escrow->title) }}</td>
                                        <td data-label="@lang('Buyer')">
                                            @lang('I\'m') @if($escrow->buyer_id == auth()->user()->id) @lang('buying from') {{ __(@$escrow->seller->username ?? $escrow->invitation_mail) }} @else @lang('selling to') {{ __(@$escrow->buyer->username ?? $escrow->invitation_mail) }} @endif
                                        </td>
                                        <td data-label="@lang('Amount')">{{ $general->cur_sym }}{{ showAmount($escrow->amount) }}</td>
                                        <td data-label="@lang('Type')">{{ $escrow->type }}</td>
                                        <td data-label="@lang('Charge')">{{ $general->cur_sym }}{{ showAmount($escrow->charge) }}</td>
                                        <td data-label="@lang('Charge Payer')">
                                            @if($escrow->charge_payer == 1)
                                                <span class="badge badge--dark">@lang('Seller')</span>
                                            @elseif($escrow->charge_payer == 2)
                                                <span class="badge badge--info">@lang('Buyer')</span>
                                            @else
                                                <span class="badge badge--success">@lang('50%-50%')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @php echo $escrow->escrowStatus @endphp
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('user.escrow.details',encrypt($escrow->id)) }}" class="btn btn--base btn-sm">@lang('Details')</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $escrows->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
