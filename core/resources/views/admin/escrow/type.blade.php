@extends('admin.layouts.app')
@tsknav('escrow')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($types as $type)
                                <tr>
                                    <td data-label="@lang('Name')">{{ __($type->name) }}</td>
                                    <td data-label="@lang('Status')">
                                        @if($type->status == 1)
                                        <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                        <span class="badge badge--danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <button class="btn btn-outline--primary btn-sm editBtn" data-name="{{ $type->name }}" data-status="{{ $type->status }}" data-action="{{ route('admin.escrow.type.update',$type->id) }}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="las la-pen"></i> @lang('Edit')</button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

            </div><!-- card end -->
        </div>


    </div>

        <div class="modal fade" id="addModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Escrow Type')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
              </div>
              <form action="{{ route('admin.escrow.type.store') }}" method="post">
                  @csrf
                    <div class="modal-body">
                      <div class="form-group">
                          <label>@lang('Name')</label>
                          <input type="text" name="name" class="form-control" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="editModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Escrow Type')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
              </div>
              <form action="" method="post">
                  @csrf
                    <div class="modal-body">
                      <div class="form-group">
                          <label>@lang('Name')</label>
                          <input type="text" name="name" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="fw-bold">@lang('Status') </label>
                        <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"><i class="las la-plus"></i> @lang('Add New')</button>
@endpush
@push('script')
    <script>
        (function($){
            "use strict"
            $('.editBtn').on('click',function(){
                var modal = $('#editModal');
                modal.find('[name=name]').val($(this).data('name'));
                modal.find('form').attr('action',$(this).data('action'));
                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }
            })
        })(jQuery);
    </script>
@endpush
