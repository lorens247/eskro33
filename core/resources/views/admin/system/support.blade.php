@extends('admin.layouts.app')
@tsknav('system')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card b-radius--10 ">
              <div class="card-body text-center">
                <h3>@lang('Facing any technical difficulties with our products? Do you need any customization or improvement in your current system? Just create a support ticket. We put special emphasis on customer support. Our dedicated support team is waiting to assist you. We always try our level best to do so.')</h3>
              </div>
              <div class="card-footer">
                <a href="https://thesoftking.com/getsupport" target="_blank" class="btn btn--primary btn-block h--50">@lang('Get Support')</a>
              </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
<style>
  td{
      
    font-size: 22px !important;
  }
  .table td {
      white-space: nowrap;
  }
</style>
@endpush
