@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard-area ptb-80">
    <div class="container">
        <div class="row gy-4">
            <div class="@if($latestTransactions->count() > 0) col-xl-8 col-lg-7 pe-xl-4 @else col-md-12 @endif">
                <div class="row gy-4">
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.transactions') }}" class="dash-btn">@lang('Transactions')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-wallet"></i>
                                </div>
                                <h5 class="title">@lang('Balance')</h5>
                                <h4 class="num mb-0">{{ showAmount($user->deposit_wallet) }} {{ $general->cur_text }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.deposit.history') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-piggy-bank"></i>
                                </div>
                                <h5 class="title">@lang('Deposited')</h5>
                                <h4 class="num mb-0">{{ showAmount($user->deposits->where('status',1)->sum('amount')) }} {{ $general->cur_text }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.withdraw.history') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-university"></i>
                                </div>
                                <h5 class="title">@lang('Withdrawn')</h5>
                                <h4 class="num mb-0">{{ showAmount($user->withdrawals->where('status',1)->sum('amount')) }} {{ $general->cur_text }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.deposit.history','pending') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-piggy-bank"></i>
                                </div>
                                <h5 class="title">@lang('Pending') <span class="text--base">@lang('Deposit')</span></h5>
                                <h4 class="num mb-0">{{ showAmount($user->deposits->where('status',2)->sum('amount')) }} {{ $general->cur_text }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.withdraw.history','pending') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-university"></i>
                                </div>
                                <h5 class="title">@lang('Pending') <span class="text--base">@lang('Withdrawals')</span></h5>
                                <h4 class="num mb-0">{{ showAmount($user->withdrawals->where('status',2)->sum('amount')) }} {{ $general->cur_text }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.escrow') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-university"></i>
                                </div>
                                <h5 class="title">@lang('Total Milestone Funded')</h5>
                                <h4 class="num mb-0">{{ showAmount($user->milestones->where('payment_status',1)->sum('amount')) }} {{ $general->cur_text }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.escrow') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-hand-holding-usd"></i>
                                </div>
                                <h5 class="title">@lang('Your Escrow')</h5>
                                <h4 class="num mb-0">{{ $totalEscrow }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.escrow','accepted') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-check-circle"></i>
                                </div>
                                <h5 class="title">@lang('Running Escrow')</h5>
                                <h4 class="num mb-0">{{ $accepted }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.escrow','not-accepted') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-ban"></i>
                                </div>
                                <h5 class="title">@lang('Escrow Awaiting For Accept')</h5>
                                <h4 class="num mb-0">{{ $notAccepted }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.escrow','completed') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-check-double"></i>
                                </div>
                                <h5 class="title">@lang('Completed Escrow')</h5>
                                <h4 class="num mb-0">{{ $completed }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.escrow','disputed') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-spinner"></i>
                                </div>
                                <h5 class="title">@lang('Disputed Escrow')</h5>
                                <h4 class="num mb-0">{{ $disputed }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="dashboard-item">
                            <a href="{{ route('user.escrow','cancelled') }}" class="dash-btn">@lang('View all')</a>
                            <div class="dashboard-content">
                                <div class="dashboard-icon">
                                    <i class="las la-times-circle"></i>
                                </div>
                                <h5 class="title">@lang('Cancelled Escrow')</h5>
                                <h4 class="num mb-0">{{ $cancelled }}</h4>
                            </div>
                        </div>
                    </div>
                </div><!-- row end -->
            </div>
            @if($latestTransactions->count() > 0)
            <div class="col-xl-4 col-lg-5">
                <div class="dashboard-right-sidebar">
                    <div class="dashboard-right-sidebar-header mb-3">
                        <h5 class="dashboard-right-title">@lang('Recent Transactions')</h5>
                        <div class="dashboard-right-btn">
                            <a href="{{ route('user.transactions') }}">@lang('View All')</a>
                        </div>
                    </div>
                    <div class="recent-trans-list">

                        @foreach ($latestTransactions as $transaction)
                            <div class="recent-single-trans amount--plus">
                                <div class="content">
                                    <h6 class="title">{{ $transaction->trx }}</h6>
                                    <span>{{ __($transaction->details) }}</span>
                                </div>
                                <div class="amount">{{ showAmount($transaction->post_balance) }} {{ __($general->cur_text) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div><!-- row end -->
    </div>
</div>
@endsection
