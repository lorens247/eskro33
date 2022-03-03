@extends('admin.layouts.app')
@tsknav('escrow')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <form action="{{ route('admin.escrow.charge.global') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>@lang('Charge Cap') <small class="text--primary">(@lang('Keep 0 for no charge cap'))</small></label>
                                <div class="input-group">
                                    <input type="text" name="charge_cap" class="form-control" value="{{ getAmount($general->charge_cap) }}" required>
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Fixed Charge') <small class="text--primary">(@lang('If the amount doesn\'t match any range'))</small></label>
                                <div class="input-group">
                                    <input type="text" name="fixed_charge" class="form-control" value="{{ getAmount($general->fixed_charge) }}" required>
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Percent Charge') <small class="text--primary">(@lang('If the amount doesn\'t match any range'))</small></label>
                                <div class="input-group">
                                    <input type="text" name="percent_charge" value="{{ getAmount($general->percent_charge) }}" class="form-control" required>
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Minimum')</th>
                                    <th>@lang('Maximum')</th>
                                    <th>@lang('Fixed Charge')</th>
                                    <th>@lang('Percent Charge')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($charges as $charge)
                                <tr>
                                    <td data-label="@lang('SL')">{{ $loop->iteration }}</td>
                                    <td data-label="@lang('Minimum')">{{ showAmount($charge->minimum) }} {{ $general->cur_text }}</td>
                                    <td data-label="@lang('Maximum')">{{ showAmount($charge->maximum) }} {{ $general->cur_text }}</td>
                                    <td data-label="@lang('Fixed Charge')">{{ showAmount($charge->fixed_charge) }} {{ $general->cur_text }}</td>
                                    <td data-label="@lang('Percent Charge')">{{ showAmount($charge->percent_charge) }} {{ $general->cur_text }}</td>
                                    <td data-label="@lang('Action')">
                                        <button class="btn btn-outline--primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-minimum="{{ getAmount($charge->minimum) }}"
                                        data-maximum="{{ getAmount($charge->maximum) }}"
                                        data-fixed_charge="{{ getAmount($charge->fixed_charge) }}"
                                        data-percent_charge="{{ getAmount($charge->percent_charge) }}"
                                        data-action="{{ route('admin.escrow.charge.update',$charge->id) }}"
                                        ><i class="las la-pen"></i> @lang('Edit')</button>
                                        <button class="btn btn-outline--danger btn-sm removeBtn" data-bs-toggle="modal" data-bs-target="#removeModal" data-action="{{ route('admin.escrow.charge.remove',$charge->id) }}"><i class="las la-trash"></i> @lang('Delete')</button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
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
                <h5 class="modal-title">@lang('Add New Charge Range')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
              </div>
              <form action="{{ route('admin.escrow.charge.store') }}" method="post">
                  @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Minimum Amount')</label>
                            <div class="input-group">
                                <input type="text" name="minimum" class="form-control" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Maximum Amount')</label>
                            <div class="input-group">
                                <input type="text" name="maximum" class="form-control" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Fixed Charge')</label>
                            <div class="input-group">
                                <input type="text" name="fixed_charge" class="form-control" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Percent Charge')</label>
                            <div class="input-group">
                                <input type="text" name="percent_charge" class="form-control" required>
                                <span class="input-group-text">%</span>
                            </div>
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
                <h5 class="modal-title">@lang('Edit Charge Range')</h5>
                <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
              </div>
              <form action="" method="post">
                  @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Minimum Amount')</label>
                            <div class="input-group">
                                <input type="text" name="minimum" class="form-control" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Maximum Amount')</label>
                            <div class="input-group">
                                <input type="text" name="maximum" class="form-control" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Fixed Charge')</label>
                            <div class="input-group">
                                <input type="text" name="fixed_charge" class="form-control" required>
                                <span class="input-group-text">{{ $general->cur_text }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Percent Charge')</label>
                            <div class="input-group">
                                <input type="text" name="percent_charge" class="form-control" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
          </div>
        </div>


            <div class="modal fade" id="removeModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">@lang('Remove Charge Range')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                  </div>
                  <form action="" method="post">
                      @csrf
                        <div class="modal-body">
                          <h6 class="text-center">@lang('Are you sure to remove this charge?')</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--dark">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
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
            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                modal.find('[name=minimum]').val($(this).data('minimum'))
                modal.find('[name=maximum]').val($(this).data('maximum'))
                modal.find('[name=fixed_charge]').val($(this).data('fixed_charge'))
                modal.find('[name=percent_charge]').val($(this).data('percent_charge'))
                modal.find('form').attr('action',$(this).data('action'))
            });

            $('.removeBtn').on('click', function () {
                var modal = $('#removeModal');
                modal.find('form').attr('action',$(this).data('action'))
            });
        })(jQuery);
    </script>
@endpush
