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
                                <label>@lang('I am')</label>
                                <select name="me_type" class="form--control">
                                    <option value="1">@lang('Selling')</option>
                                    <option value="2">@lang('Buying')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Escrow Type')</label>
                                <select name="escrow_type" class="form--control">
                                    <option value="">@lang('Select One')</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ __($type->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Amount')</label>
                                <div class="input-group">
                                    <span class="input-group-text">@lang('For')</span>
                                    <input type="text" class="form--control form-control" name="amount">
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn--base btn-block">@lang('Next')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
