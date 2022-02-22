@extends('admin.layouts.app')
@tsknav('frontend')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(getPageSections(true) as $k => $secs)
                            @if($secs['builder'])
                                <tr>
                                    <td data-label="@lang('Name')">{{__($secs['name'])}}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.frontend.sections',$k) }}" class="btn btn-sm btn-outline--primary ml-1"><i class="la la-pen"></i> @lang('Edit')</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection