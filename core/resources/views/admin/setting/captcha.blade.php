@extends('admin.layouts.app')
@tsknav('setting')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="post">
                    @csrf
                    <div class="card-body">
                      <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>@lang('Google Re-captcha Site Key')</label>
                              <input type="text" name="recaptcha_site_key" class="form-control" value="{{ @$gc->shortcode->sitekey->value }}" required>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>@lang('Google Re-captcha Secret Key')</label>
                              <input type="text" name="recaptcha_secret_key" class="form-control" value="{{ @$gc->shortcode->secretkey->value }}" required>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group mt-4">
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="g_captcha_status" @if($gc->status) checked @endif>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <label>@lang('Custom Captcha')</label>
                              <input type="text" name="custom_captcha" class="form-control" value="{{ $cc->shortcode->random_key->value }}" required>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group mt-4">
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="c_captcha_status" @if($cc->status) checked @endif>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
