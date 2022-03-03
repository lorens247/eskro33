@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card custom--card">
                    <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p class="text-center mt-2">@lang('You have requested') <b class="text--success">{{ showAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                                        <b class="text--success">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                                    </p>
                                    <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                                    <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>
                                </div>

                                @if($method->gateway_parameter)
                                    @foreach(json_decode($method->gateway_parameter) as $k => $v)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span> @endif</label>
                                            @if($v->type == "text")
                                                <input type="text" name="{{$k}}" class="form--control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                            @elseif($v->type == "textarea")
                                                <textarea name="{{$k}}"  class="form--control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                            @elseif($v->type == "file")
                                                <input type="file" name="{{$k}}" class="form--control form-control" @if($v->validation == "required") required @endif>
                                            @endif
                                            @if ($errors->has($k))
                                                <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
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
