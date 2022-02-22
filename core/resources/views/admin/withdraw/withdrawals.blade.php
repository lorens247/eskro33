@extends('admin.layouts.app')
@tsknav('withdraw')
@section('panel')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="card b-radius--10 overflow-hidden">
            <div class="card-body p-0">

                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Gateway | Trx')</th>
                                <th>@lang('Initiated')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Conversion')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $withdraw)
                            @php
                            $details = ($withdraw->withdraw_information != null) ? json_encode($withdraw->withdraw_information) : null;
                            @endphp
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="fw-bold">{{ $withdraw->user->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $withdraw->user_id) }}"><span>@</span>{{ $withdraw->user->username }}</a> </span>
                                </td>
                                <td data-label="@lang('Gateway | Trx')">
                                    <span class="fw-bold"><a href="{{ route('admin.withdraw.method',[$withdraw->method->id,'all']) }}"> {{ __(@$withdraw->method->name) }}</a></span>
                                    <br>
                                    <small>{{ $withdraw->trx }}</small>
                                </td>
                                <td data-label="@lang('Initiated')">
                                    {{ showDateTime($withdraw->created_at) }} <br>  {{ diffForHumans($withdraw->created_at) }}
                                </td>



                                <td data-label="@lang('Amount')">
                                   {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount ) }} - <span class="text-danger" title="@lang('charge')">{{ showAmount($withdraw->charge)}} </span>
                                    <br>
                                    <strong title="@lang('Amount after charge')">
                                    {{ showAmount($withdraw->amount-$withdraw->charge) }} {{ __($general->cur_text) }}
                                    </strong>

                                </td>

                                <td data-label="@lang('Conversion')">
                                   1 {{ __($general->cur_text) }} =  {{ showAmount($withdraw->rate) }} {{ __($withdraw->currency) }}
                                    <br>
                                    <strong>{{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }}</strong>
                                </td>



                                <td data-label="@lang('Status')">
                                    @if($withdraw->status == 2)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                    @elseif($withdraw->status == 1)
                                    <span class="badge badge--success" title="{{ diffForHumans($withdraw->updated_at) }}">@lang('Approved')</span>
                                    @elseif($withdraw->status == 3)
                                    <span class="badge badge--danger" title="{{ diffForHumans($withdraw->updated_at) }}">@lang('Rejected')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="btn btn-sm btn-outline--primary ml-1 ">
                                        <i class="la la-desktop"></i> @lang('Detail')
                                    </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table><!-- table end -->
            </div>
        </div>

        @if($withdrawals->hasPages())
        <div class="card-footer py-4">
            {{ paginateLinks($withdrawals) }}
        </div>
        @endif
    </div><!-- card end -->
</div>
</div>
@endsection

@push('breadcrumb-plugins')
    @if(!request()->routeIs('admin.users.withdrawals') && !request()->routeIs('admin.users.withdrawals.method'))
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('admin.withdraw.search', $scope ?? str_replace('admin.withdraw.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Trx/Username')" value="{{ $search ?? '' }}">
                    <button class="input-group-text bg--primary text-white" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endpush
