@extends('admin.layouts.app')
@tsknav('system')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card b-radius--10 ">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table--light style--two">
                    <tbody>
                      <tr>
                          <td><i class="las la-hand-point-right text--success"></i> @lang('Compiled views will be cleared')</td>
                      <tr>
                          <td><i class="las la-hand-point-right text--success"></i> @lang('Application cache will be cleared')</td>
                      </tr>
                      <tr>
                          <td><i class="las la-hand-point-right text--success"></i> @lang('Route cache will be cleared')</td>
                      </tr>
                      <tr>
                          <td><i class="las la-hand-point-right text--success"></i> @lang('Configuration cache will be cleared')</td>
                      </tr>
                      <tr>
                          <td><i class="las la-hand-point-right text--success"></i> @lang('Compiled services and packages files will be removed')</td>
                      </tr>
                      <tr>
                          <td><i class="las la-hand-point-right text--success"></i> @lang('Caches will be cleared')</td>
                      </tr>
                    </tbody>
                  </table><!-- table end -->
                </div>
              </div>
              <div class="card-footer">
				    <a href="{{ route('admin.system.optimize.clear') }}" class="btn btn--primary btn-block h--50">@lang('Click to clear')</a>
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
