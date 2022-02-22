@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center mt-80">
    <div class="col-xl-6">
        <div class="card custom--card">
            <div class="card card-deposit">
                <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5 class="text-center mb-3">@lang('Current Balance') :<strong>{{ showAmount(auth()->user()->balance)}}  {{ __($general->cur_text) }}</strong></h5>
                        <p class="my-3 text-center">@php echo  $data->gateway->description @endphp</p>
                        @if($withdraw->method->user_data)
                            @foreach($withdraw->method->user_data as $k => $v)
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
                            @endforeach
                        @endif
                        @if(auth()->user()->ts)
                        <div class="form-group">
                            <label>@lang('Google Authenticator Code')</label>
                            <input type="text" name="authenticator_code" class="form--control" required>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--base btn-block">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

