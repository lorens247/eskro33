@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card custom--card">
                    <form class="register prevent-double-click" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="col-form-label">@lang('Username')</label>
                                    <input type="text" class="form--control" value="{{$user->username}}" readonly>
                                </div>

                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="InputFirstname" class="col-form-label">@lang('First Name')</label>
                                    <input type="text" class="form--control" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" minlength="3">
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="lastname" class="col-form-label">@lang('Last Name')</label>
                                    <input type="text" class="form--control" id="lastname" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}" required>
                                </div>

                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="email" class="col-form-label">@lang('E-mail Address')</label>
                                    <input class="form--control" id="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                                    <input class="form--control" id="phone" value="{{$user->mobile}}" readonly>
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="telegram_username" class="col-form-label">@lang('Telegram Username') @if($general->tn) <a href="http://t.me/{{ $general->telegram_config->name }}" class="text--base" target="_blank">@lang('Get Notification')</a> @endif</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input class="form--control form-control" name="telegram_username" id="telegram_username" value="{{$user->telegram_username}}">
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="col-form-label">@lang('Country')</label>
                                    <input class="form--control" value="{{@$user->address->country}}" disabled>
                                </div>

                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="state" class="col-form-label">@lang('State')</label>
                                    <input type="text" class="form--control" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}">
                                </div>

                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="zip" class="col-form-label">@lang('Zip Code')</label>
                                    <input type="text" class="form--control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}">
                                </div>

                                <div class="form-group col-lg-4 col-md-6">
                                    <label for="city" class="col-form-label">@lang('City')</label>
                                    <input type="text" class="form--control" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}">
                                </div>



                                <div class="form-group col-lg-8 col-md-12">
                                    <label for="address" class="col-form-label">@lang('Address')</label>
                                    <input type="text" class="form--control" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}">
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn--base  btn-block">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
