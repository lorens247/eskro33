@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row justify-content-center mt-80">
        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-body p-5">
                    <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                        @csrf
                        <ul class="list-group text-center">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You have to pay '):
                                <strong>{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will get '):
                                <strong>{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</strong>
                            </li>
                        </ul>
                        <button type="button" class="btn btn--base  btn-block mt-3" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                        <script
                            src="//js.paystack.co/v1/inline.js"
                            data-key="{{ $data->key }}"
                            data-email="{{ $data->email }}"
                            data-amount="{{$data->amount}}"
                            data-currency="{{$data->currency}}"
                            data-ref="{{ $data->ref }}"
                            data-custom-button="btn-confirm"
                        >
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

