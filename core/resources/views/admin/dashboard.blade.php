@extends('admin.layouts.app')

@section('panel')

    @if($general->sys_version)
    <div class="row">
        <div class="col-md-12">
            @if(@$general->sys_version->body->notice)
            @foreach ($general->sys_version->body->notice as $notice)
            <div class="alert alert-warning p-3">@php echo $notice @endphp</div>
            @endforeach
            @endif
            @if($general->sys_version->body->version->number > systemDetails()['version'])
                @if(@$general->sys_version->body->version->details)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="float-start mb-0">V-{{ $general->sys_version->body->version->number }} @lang('is available now')</h5>
                            <div class="float-end">
                                <a href="{{ $general->sys_version->body->version->url }}" target="_blank" class="btn btn-outline--primary btn-sm"><i class="las la-download"></i>@lang('Download now')</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @php echo $general->sys_version->body->version->details @endphp
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    @endif

    <div class="row gy-4 row-info-badge-area">
        <span class="row-info-badge">@lang('User')</span>
        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--info b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-users dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-users text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Total Users')</span>
                        <h3 class="amount text-white fw-medium">{{$widget['total_users']}}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{route('admin.users.all')}}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-users dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-users text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Total Active Users')</span>
                        <h3 class="amount text-white fw-medium">{{$widget['active_users']}}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{route('admin.users.active')}}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--5 b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-envelope dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-envelope text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Total Email Unverified Users')</span>
                        <h3 class="amount text-white fw-medium">{{$widget['email_unverified_users']}}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{route('admin.users.email.unverified')}}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--danger b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-shopping-cart dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-shopping-cart text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Total SMS Unverified Users')</span>
                        <h3 class="amount text-white fw-medium">{{$widget['sms_unverified_users']}}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{route('admin.users.sms.unverified')}}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row mt-4 gy-4 row-info-badge-area">
        <span class="row-info-badge">@lang('Deposit')</span>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Total Deposits')</p>
                    <h3 class="numbers">{{showAmount($payment['total_deposit_amount'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text--teal text--shadow">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Pending Deposits')</p>
                    <h3 class="numbers">{{showAmount($payment['total_deposit_pending'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text-color--19 text--shadow">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Rejected Deposits')</p>
                    <h3 class="numbers">{{showAmount($payment['total_deposit_rejected'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text--danger text--shadow">
                    <i class="fas fa-ban"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Total Deposit Charge')</p>
                    <h3 class="numbers">{{showAmount($payment['total_deposit_charge'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text--primary text--shadow">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
    </div><!-- row end -->

    <div class="row mt-4 gy-4 row-info-badge-area">
        <span class="row-info-badge">@lang('Withdraw')</span>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Total Withdraw')</p>
                    <h3 class="numbers">{{showAmount($paymentWithdraw['total_withdraw_amount'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text-color--7 text--shadow">
                    <i class="far fa-credit-card"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Pending Withdraw')</p>
                    <h3 class="numbers">{{showAmount($paymentWithdraw['total_withdraw_pending'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text-color--18 text--shadow">
                    <i class="fas fa-sync"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Rejected Withdraw')</p>
                    <h3 class="numbers">{{showAmount($paymentWithdraw['total_withdraw_rejected'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text--danger text--shadow">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="widget-four box--shadow2 b-radius--5 bg-white">
                <div class="widget-four__content">
                    <p class="text--small">@lang('Total Withdraw Charge')</p>
                    <h3 class="numbers">{{showAmount($paymentWithdraw['total_withdraw_charge'])}} {{$general->cur_text}}</h3>
                </div>
                <div class="widget-four__icon text--light-blue text--shadow">
                    <i class="fas fa-percent"></i>
                </div>
            </div>
        </div>
    </div><!-- row end -->

    <div class="row mt-4 gy-4 row-info-badge-area">
        <span class="row-info-badge">@lang('Escrow')</span>
        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-hand-holding-usd dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-hand-holding-usd text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Total Escrow')</span>
                        <h3 class="amount text-white fw-medium">{{ showAmount($totalEscrows) }} {{ $general->cur_text }}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('admin.escrow.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--indigo b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-file-invoice-dollar dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-file-invoice-dollar text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Escrow Fund')</span>
                        <h3 class="amount text-white fw-medium">{{ showAmount($escrowFund) }} {{ $general->cur_text }}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('admin.escrow.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--14 b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-times-circle dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-times-circle text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Cancelled Escrow')</span>
                        <h3 class="amount text-white fw-medium">{{ showAmount($cancelledEscrows) }} {{ $general->cur_text }}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('admin.escrow.cancelled') }}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-sm-6">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow d-flex flex-wrap align-items-center">
                <i class="fa fa-spinner dw1-icon"></i>
                <div class="left d-flex flex-wrap align-items-center">
                    <i class="fa fa-spinner text-white"></i>
                    <div class="content">
                        <span class="text--small text-white">@lang('Disputed Escrow')</span>
                        <h3 class="amount text-white fw-medium">{{ showAmount($disputedEscrows) }} {{ $general->cur_text }}</h3>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('admin.escrow.disputed') }}" class="btn btn-sm text--small bg--white text--black box--shadow3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div>

    <div class="row mt-4 gy-4">
        <div class="col-xl-4 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser')</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS')</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country')</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/chart.js.2.8.0.js')}}"></script>

    <script>

        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });



        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_os_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_os_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });


        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });

    </script>
@endpush
