@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.users.notification.single', $user->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Subject') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Email subject')" name="subject"  required/>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Message') </label>
                                    <textarea name="message" rows="10" class="form-control nicEdit"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('breadcrumb-plugins')
<span class="text--primary">@lang('Notification will send via ') @if($general->en) <span class="badge badge--warning">@lang('Email')</span> @endif @if($general->sn) <span class="badge badge--warning">@lang('SMS')</span> @endif @if($general->tn) <span class="badge badge--warning">@lang('Telegram')</span> @endif</span>
@endpush
