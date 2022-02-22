@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Currency')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Limit')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($methods as $method)
                                <tr>
                                    <td data-label="@lang('Name')" class="fw-bold">{{__($method->name)}} </td>

                                    <td data-label="@lang('Currency')"
                                       >{{ __($method->currency) }}</td>
                                    <td data-label="@lang('Charge')"
                                       >{{ showAmount($method->fixed_charge)}} {{__($general->cur_text) }} {{ (0 < $method->percent_charge) ? ' + '. showAmount($method->percent_charge) .' %' : '' }} </td>
                                    <td data-label="@lang('Limit')"
                                       >{{ showAmount($method->min_limit) }}
                                        - {{ showAmount($method->max_limit) }} {{__($general->cur_text) }}</td>
                                    <td data-label="@lang('Status')">
                                        @if($method->status == 1)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <button class="btn btn-sm btn-outline--primary ml-1 editBtn" data-resource="{{ $method }}" data-action="{{ route('admin.withdrawal.method.update',$method->id) }}"><i class="las la-pen"></i> @lang('Edit')</button>
                                        @if($method->status == 1)
                                            <button class="btn btn-sm btn-outline--danger deactivateBtn  ml-1" data-id="{{ $method->id }}" data-name="{{ __($method->name) }}">
                                                <i class="la la-eye-slash"></i> @lang('Disable')
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline--success activateBtn  ml-1"
                                               data-id="{{ $method->id }}" data-name="{{ __($method->name) }}">
                                                <i class="la la-eye"></i> @lang('Enable')
                                            </button>
                                        @endif
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

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Withdrawal Method Enable Confirmation')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.withdrawal.method.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class=" method-name"></span> @lang('method')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Withdrawal Method Disable Confirmation')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.withdrawal.method.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to deactivate') <span class=" method-name"></span> @lang('method')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    {{-- ADD METHOD MODAL --}}
    <div id="withdrawGatewayModal" class="modal fade">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Withdraw Method')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.withdrawal.method.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>@lang('Method Name') </label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label>@lang('Currency') </label>
                                    <input type="text" name="currency" class="form-control border-radius-5" value="{{ old('currency') }}"/>
                               </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Rate') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">1 {{ __($general->cur_text) }} =</span>
                                        <input type="text" class="form-control" placeholder="0" name="rate" value="{{ old('rate') }}"/>
                                        <span class="input-group-text currency_symbol">$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Limit')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Minimum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" name="min_limit" placeholder="0" value="{{ old('min_limit') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Maximum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="max_limit" value="{{ old('max_limit') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Charge')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Fixed Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="fixed_charge" value="{{ old('fixed_charge') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Percent Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('%')</span>
                                        <input type="text" class="form-control" placeholder="0" name="percent_charge" value="{{ old('percent_charge') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group __nicEditorShow">
                            <label>@lang('Instruction')</label>
                            <textarea rows="8" class="form-control border-radius-5 nicEdit" name="instruction">{{ old('instruction') }}</textarea>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('User Data')</h6>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-outline--primary float-right addUserData"><i class="las la-plus"></i>@lang('Add New')</button>
                        </div>
                        <div class="row addedField">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    {{-- ADD METHOD MODAL --}}
    <div id="editWithdrawGatewayModal" class="modal fade">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Withdraw Method')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>@lang('Method Name') </label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label>@lang('Currency') </label>
                                    <input type="text" name="currency" class="form-control border-radius-5" value="{{ old('currency') }}"/>
                               </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Rate') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">1 {{ __($general->cur_text) }} =</span>
                                        <input type="text" class="form-control" placeholder="0" name="rate" value="{{ old('rate') }}"/>
                                        <span class="input-group-text currency_symbol">$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Limit')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Minimum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" name="min_limit" placeholder="0" value="{{ old('min_limit') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Maximum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="max_limit" value="{{ old('max_limit') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Charge')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Fixed Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="fixed_charge" value="{{ old('fixed_charge') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Percent Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('%')</span>
                                        <input type="text" class="form-control" placeholder="0" name="percent_charge" value="{{ old('percent_charge') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group __nicEditorShow">
                            <label>@lang('Instruction')</label>
                            <textarea rows="8" class="form-control border-radius-5 nicEdit" name="instruction">{{ old('instruction') }}</textarea>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('User Data')</h6>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-outline--primary float-right addUserData"><i class="las la-plus"></i>@lang('Add New')</button>
                        </div>
                        <div class="row addedField">
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
    <button class="btn btn-sm btn-outline--primary addBtn" data-bs-toggle="modal" data-bs-target="#withdrawGatewayModal"><i class="las la-plus"></i>@lang('Add New')</button>
@endpush


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.user-data').remove();
            });


            var modalData = $('#withdrawGatewayModal');
            modalData.find('input[name=currency]').on('input', function () {
                modalData.find('.currency_symbol').text($(this).val());
            });

            modalData.find('.addUserData').on('click', function () {
                var html = generalField();
                modalData.find('.addedField').append(html)
            });


            @if(old('currency'))
            modalData.find('input[name=currency]').trigger('input');
            @endif



            $('.editBtn').click(function(){
                var modal = $('#editWithdrawGatewayModal');
                var withdraw = $(this).data('resource');
                console.log(withdraw);
                var currency = withdraw.currency;
                modal.find('input[name=name]').val(withdraw.name);
                modal.find('input[name=currency]').val(withdraw.currency);
                modal.find('.currency_symbol').text(withdraw.currency);
                modal.find('input[name=rate]').val(parseFloat(withdraw.rate).toFixed(2));
                modal.find('input[name=min_limit]').val(parseFloat(withdraw.min_limit).toFixed(2));
                modal.find('input[name=max_limit]').val(parseFloat(withdraw.max_limit).toFixed(2));
                modal.find('input[name=fixed_charge]').val(parseFloat(withdraw.fixed_charge).toFixed(2));
                modal.find('input[name=percent_charge]').val(parseFloat(withdraw.percent_charge).toFixed(2));
                modal.find('.nicEdit-main').html(withdraw.description);
                var html = '';
                $.each(withdraw.user_data, function(index, item) {
                    html += `
                        <div class="col-md-12 user-data">
                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <input name="field_name[]" class="form-control" type="text" value="${item.field_level}" required placeholder="@lang('Field Name')">
                                </div>
                                <div class="col-xl-4 col-md-3 col-sm-4">
                                    <select name="type[]" class="form-control">
                                        <option value="text" ${item.type == 'text' ? 'selected' : ''}> @lang('Input Text') </option>
                                        <option value="textarea" ${item.type == 'textarea' ? 'selected' : ''}> @lang('Textarea') </option>
                                        <option value="file" ${item.type == 'file' ? 'selected' : ''}> @lang('File') </option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    <select name="validation[]" class="form-control">
                                        <option value="required" ${item.validation == 'required' ? 'selected' : ''}> @lang('Required') </option>
                                        <option value="nullable" ${item.validation == 'nullable' ? 'selected' : ''}>  @lang('Optional') </option>
                                    </select>
                                </div>
                                <div class="col-xl-1 col-md-2">
                                    <span class="input-group-btn">
                                        <button class="btn btn--danger btn-lg removeBtn h-100" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                modal.find('.addedField').html(html);
                modal.find('form').attr('action',$(this).data('action'));
                modal.modal('show');
                modal.find('.addUserData').on('click', function () {
                var html = generalField();
                    modal.find('.addedField').append(html)
                });
                modal.find('input[name=currency]').on('input', function () {
                    modal.find('.currency_symbol').text($(this).val());
                });

            });


            function generalField(){
                return `
                    <div class="col-md-12 user-data mt-4">
                        <div class="row gy-4 gx-3">
                            <div class="col-sm-4">
                                <input name="field_name[]" class="form-control" type="text" required placeholder="@lang('Field Name')">
                            </div>
                            <div class="col-xl-4 col-md-3 col-sm-4">
                                <select name="type[]" class="form-control">
                                    <option value="text" > @lang('Input Text') </option>
                                    <option value="textarea" > @lang('Textarea') </option>
                                    <option value="file"> @lang('File') </option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <select name="validation[]"
                                        class="form-control">
                                    <option value="required"> @lang('Required') </option>
                                    <option value="nullable">  @lang('Optional') </option>
                                </select>
                            </div>
                            <div class="col-xl-1 col-md-2">
                                <span class="input-group-btn">
                                    <button class="btn btn--danger btn-lg removeBtn h-100" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>`;

            }
        })(jQuery);
    </script>
@endpush
