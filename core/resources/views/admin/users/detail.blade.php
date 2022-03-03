@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-4">

        <div class="col-xl-12">
            <div class="row gy-4">
                <div class="col-xxl-3 col-xl-6 col-lg-12 col-sm-6">
                    <div class="dashboard-w1 style--two bg--1 b-radius--10 box-shadow d-flex flex-wrap align-items-center has--link">
                        <a href="{{route('admin.users.deposits',$user->id)}}" class="item--link"></a>
                        <i class="la la-credit-card dw1-icon"></i>
                        <div class="left d-flex flex-wrap align-items-center">
                            <i class="la la-credit-card text-white"></i>
                            <div class="content">
                                <h3 class="amount text-white fw-medium">{{__($general->cur_sym)}}{{showAmount($totalDeposit)}}</h3>
                                <span class="text--small text-white">@lang('Deposited')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-xl-6 col-lg-12 col-sm-6">
                    <div class="dashboard-w1 style--two bg--2 b-radius--10 box-shadow d-flex flex-wrap align-items-center has--link">
                        <a href="{{route('admin.users.withdrawals',$user->id)}}" class="item--link"></a>
                        <i class="la la-university dw1-icon"></i>
                        <div class="left d-flex flex-wrap align-items-center">
                            <i class="la la-university text-white"></i>
                            <div class="content">
                                <h3 class="amount text-white fw-medium">{{__($general->cur_sym)}}{{showAmount($totalWithdraw)}}</h3>
                                <span class="text--small text-white">@lang('Withdrawn')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-xl-6 col-lg-12 col-sm-6">
                    <div class="dashboard-w1 style--two bg--18 b-radius--10 box-shadow d-flex flex-wrap align-items-center has--link">
                        <a href="{{route('admin.users.transactions',$user->id)}}" class="item--link"></a>
                        <i class="la la-exchange-alt dw1-icon"></i>
                        <div class="left d-flex flex-wrap align-items-center">
                            <i class="la la-exchange-alt text-white"></i>
                            <div class="content">
                                <h3 class="amount text-white fw-medium">{{$totalTransaction}}</h3>
                                <span class="text--small text-white">@lang('Transactions')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-xl-6 col-lg-12 col-sm-6">
                    <div class="dashboard-w1 style--two bg--10 b-radius--10 box-shadow d-flex flex-wrap align-items-center has--link">
                        <a href="{{route('admin.users.transactions',$user->id)}}" class="item--link"></a>
                        <i class="la la-money dw1-icon"></i>
                        <div class="left d-flex flex-wrap align-items-center">
                            <i class="la la-money text-white"></i>
                            <div class="content">
                                <h3 class="amount text-white fw-medium">{{__($general->cur_sym)}}{{showAmount($user->balance)}}</h3>
                                <span class="text--small text-white">@lang('Current Balance')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
            </div>

            <div class="row gy-4 mt-1 justify-content-center">
                <div class="col-lg-4 col-xl-2">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow btn-block btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="col-lg-4 col-xl-2">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger btn--shadow btn-block btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="col-lg-4 col-xl-2">
                    <a href="{{ route('admin.users.login.history.single', $user->id) }}"
                        class="btn btn--primary btn--shadow btn-block btn-lg">
                            <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>
                <div class="col-lg-4 col-xl-2">
                    <a href="{{route('admin.users.notification.single',$user->id)}}"
                        class="btn btn--dark btn--shadow btn-block btn-lg">
                            <i class="las la-envelope"></i> @lang('Send Notification')
                    </a>
                </div>
                <div class="col-lg-4 col-xl-2">
                    <a href="{{route('admin.users.notification.log',$user->id)}}" class="btn btn--secondary btn--shadow btn-block btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>
                <div class="col-lg-4 col-xl-2">
                    <a href="{{route('admin.users.login',$user->id)}}" target="_blank" class="btn btn--primary btn--gradi btn--shadow btn-block btn-lg">
                        <i class="las la-sign-in-alt"></i>@lang('Login as User')
                    </a>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">@lang('User Profile')</h5>

                    <form action="{{route('admin.users.update',[$user->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Username')</label>
                                    <input class="form-control" type="text" name="username" value="{{$user->username}}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="fw-bold">@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" value="{{$user->firstname}}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class=" fw-bold">@lang('Last Name') </label>
                                    <input class="form-control" type="text" name="lastname" value="{{$user->lastname}}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Email') </label>
                                    <input class="form-control" type="email" name="email" value="{{$user->email}}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Telegram Username')</label>
                                    <input class="form-control" name="telegram_username" value="{{$user->telegram_username}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Mobile Number') </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold required">@lang('Country')</label>
                                    <select name="country" class="form-control" id="country" required>
                                        @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('City') </label>
                                    <input class="form-control" type="text" name="city" value="{{@$user->address->city}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="fw-bold">@lang('State') </label>
                                    <input class="form-control" type="text" name="state" value="{{@$user->address->state}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="fw-bold">@lang('Zip/Postal Code') </label>
                                    <input class="form-control" type="text" name="zip" value="{{@$user->address->zip}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Address') </label>
                                    <input class="form-control" type="text" name="address" value="{{@$user->address->address}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Status') </label>
                                    <input type="checkbox" data-onstyle="-success" data-offstyle="-danger"
                                           data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Banned')" data-width="100%" data-height="50"
                                           name="status"
                                           @if($user->status) checked @endif>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Email Verification') </label>
                                    <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                       @if($user->ev) checked @endif>
                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('SMS Verification') </label>
                                    <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                       @if($user->sv) checked @endif>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('2FA Verification') </label>
                                    <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="ts"
                                       @if($user->ts) checked @endif>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.users.add.sub.balance', $user->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="text" name="amount" class="form-control" placeholder="@lang('Please provide positive amount')">
                                <div class="input-group-text">{{ __($general->cur_text) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
<script>
    $('.bal-btn').click(function(){
        var act = $(this).data('act');
        $('#addSubModal').find('input[name=act]').val(act);
        if (act == 'add') {
            $('.type').text('Add');
        }else{
            $('.type').text('Subtract');
        }
    });


    let mobileElement = $('.mobile-code');
    $('select[name=country]').change(function(){
        mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
    });


    $('select[name=country]').val('{{@$user->country_code}}');
    let dialCode        = $('select[name=country] :selected').data('mobile_code');
    let mobileNumber    = `{{ $user->mobile }}`;
    mobileNumber        = mobileNumber.replace(dialCode,'');
    $('input[name=mobile]').val(mobileNumber);
    mobileElement.text(`+${dialCode}`);
</script>
@endpush
