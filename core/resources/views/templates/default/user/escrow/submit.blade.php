@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card custom--card">
                    <form action="" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>@if($escrowInfo['me_type'] == 1) @lang('Buyer Email') @else @lang('Seller email') @endif</label>
                                <input type="text" class="form--control" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Title')</label>
                                <input type="text" class="form--control" name="title" value="{{ old('title') }}" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Charge')</label>
                                <div class="input-group">
                                    <input type="text" class="form--control form-control" value="{{ getAmount($escrowInfo['charge']) }}" readonly>
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('Charge will pay')</label>
                                <select name="charge_payer" class="form--control" required>
                                    <option value="1">@lang('Seller')</option>
                                    <option value="2">@lang('Buyer')</option>
                                    <option value="3">@lang('50%-50%')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Details')</label>
                                <textarea name="details" class="form--control" required>{{ old('details') }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn--base btn-block">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
