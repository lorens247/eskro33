@extends($activeTemplate.'layouts.master')
@section('content')
<section class="account-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="custom--card">

                    <form method="POST" action="{{ route('user.password.email') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>@lang('Select One')</label>
                                <select class="form--control" name="type">
                                    <option value="email">@lang('E-Mail Address')</option>
                                    <option value="username">@lang('Username')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="my_value"></label>
                                <input type="text" class="form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn--base btn-block">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>

    (function($){
        "use strict";

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush
