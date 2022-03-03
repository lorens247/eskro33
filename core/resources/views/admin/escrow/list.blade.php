@extends('admin.layouts.app')
@tsknav('escrow')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Buyer')</th>
                                <th>@lang('Seller')</th>
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
                                        @if($escrow->buyer)
                                            <span class="fw-bold">{{ __($escrow->buyer->fullname) }}</span>
                                            <br>
                                            <span class="small">
                                            <a href="{{ route('admin.users.detail',$escrow->buyer->id) }}"><span>@</span>{{ __($escrow->buyer->username) }}</a>
                                            </span>
                                        @else
                                            {{ $escrow->invitation_mail }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('Seller')">
                                        @if($escrow->seller)
                                            <span class="fw-bold">{{ __($escrow->seller->fullname) }}</span>
                                            <br>
                                            <span class="small">
                                            <a href="{{ route('admin.users.detail',$escrow->seller->id) }}"><span>@</span>{{ __($escrow->seller->username) }}</a>
                                            </span>
                                        @else
                                            {{ $escrow->invitation_mail }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('Amount')">{{ $general->cur_sym }}{{ showAmount($escrow->amount) }}</td>
                                    <td data-label="@lang('Type')">{{ $escrow->type }}</td>
                                    <td data-label="@lang('Charge')">{{ $general->cur_sym }}{{ showAmount($escrow->charge) }}</td>
                                    <td data-label="@lang('Charge Payer')">
                                        @if($escrow->charge_payer == 1)
                                            <span class="badge badge--primary">@lang('Seller')</span>
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
                                        <a href="{{ route('admin.escrow.details',$escrow->id) }}" class="btn btn-outline--primary btn-sm"><i class="las la-desktop"></i> @lang('Details')</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if($escrows->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($escrows) }}
                </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection
