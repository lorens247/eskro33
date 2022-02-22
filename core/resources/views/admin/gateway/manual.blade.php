@extends('admin.layouts.app')
@tsknav('gateway')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th>@lang('Gateway')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gateways as $gateway)
                                <tr>
                                    <td data-label="@lang('Gateway')">{{__($gateway->name)}}</td>

                                    <td data-label="@lang('Status')">
                                        @if($gateway->status == 1)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <button class="btn btn-sm btn-outline--primary editGatewayBtn" data-resource="{{ $gateway }}" data-currency="{{ $gateway->currencies->first() }}" data-action="{{ route('admin.gateway.manual.update', $gateway->code) }}">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </button>

                                        @if($gateway->status == 0)
                                            <button data-bs-toggle="modal" data-bs-target="#activateModal" class="btn btn-sm btn-outline--success ml-1 activateBtn" data-code="{{$gateway->code}}" data-name="{{__($gateway->name)}}">
                                                <i class="la la-eye"></i> @lang('Enable')
                                            </button>
                                        @else
                                            <button data-bs-toggle="modal" data-bs-target="#deactivateModal" class="btn btn-sm btn-outline--danger ml-1 deactivateBtn" data-code="{{$gateway->code}}" data-name="{{__($gateway->name)}}">
                                                <i class="la la-eye-slash"></i> @lang('Disable')
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



    {{-- ADD METHOD MODAL --}}
    <div id="manualGatewayModal" class="modal fade">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Manual Gateway')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.gateway.manual.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                <label class="fw-bold">@lang('Gateway Name') </label>
                                <input type="text" class="form-control " placeholder="@lang('Method Name')" name="name" value="{{ old('name') }}" required/>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Currency') </label>
                                    <input type="text" name="currency" placeholder="@lang('Currency')" class="form-control border-radius-5" value="{{ old('currency') }}" required />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                <label class="fw-bold">@lang('Rate') </label>
                                <div class="input-group">
                                    <span class="input-group-text">1 {{ __($general->cur_text )}} =</span>
                                    <input type="text" class="form-control" placeholder="0" name="rate" value="{{ old('rate') }}" required />
                                    <span class="input-group-text currency_symbol">$</span>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Limit')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Minimum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" name="min_limit" required placeholder="0" value="{{ old('min_limit') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Maximum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" required name="max_limit" value="{{ old('max_limit') }}"/>
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
                                    <label class="fw-bold">@lang('Fixed Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" required name="fixed_charge" value="{{ old('fixed_charge') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Percent Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('%')</span>
                                        <input type="text" class="form-control" placeholder="0" required name="percent_charge" value="{{ old('percent_charge') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group __nicEditorShow">
                            <label class="fw-bold">@lang('Instruction')</label>
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


    {{-- EDIT METHOD MODAL --}}
    <div id="editManualGatewayModal" class="modal fade">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Gateway')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.gateway.manual.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                <label class="fw-bold">@lang('Gateway Name') </label>
                                <input type="text" class="form-control " required placeholder="@lang('Method Name')" name="name" value="{{ old('name') }}"/>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Currency') </label>
                                    <input type="text" name="currency" required placeholder="@lang('Currency')" class="form-control border-radius-5"/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                <label class="fw-bold">@lang('Rate') </label>
                                <div class="input-group">
                                    <span class="input-group-text">1 {{ __($general->cur_text )}} =</span>
                                    <input type="text" class="form-control" required placeholder="0" name="rate" value="{{ old('rate') }}"/>
                                    <span class="input-group-text currency_symbol"></span>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Limit')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Minimum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" required name="min_limit" placeholder="0" value="{{ old('min_limit') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Maximum Amount') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" required name="max_limit" value="{{ old('max_limit') }}"/>
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
                                    <label class="fw-bold">@lang('Fixed Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" required name="fixed_charge" value="{{ old('fixed_charge') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Percent Charge') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('%')</span>
                                        <input type="text" class="form-control" placeholder="0" required name="percent_charge" value="{{ old('percent_charge') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group __nicEditorShow">
                            <label class="fw-bold">@lang('Instruction')</label>
                            <textarea rows="8" class="form-control border-radius-5 nicEdit" name="instruction">{{ old('instruction') }}</textarea>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('User Data')</h6>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-outline--primary float-right addUserData"><i class="las la-plus"></i>@lang('Add New')</button>
                        </div>
                        <div class="row addedField ">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Payment Method Activation Confirmation')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.gateway.manual.activate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class="fw-bold method-name"></span> @lang('method')?</p>
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
                    <h5 class="modal-title">@lang('Payment Method Disable Confirmation')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.gateway.manual.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to deactivate') <span class="fw-bold method-name"></span> @lang('method')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary addBtn" data-bs-toggle="modal" data-bs-target="#manualGatewayModal"><i class="las la-plus"></i>@lang('Add New')</button>
@endpush
@push('script')
    <script>

        (function ($) {
            "use strict";

            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });
            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });


                var modalData = $('#manualGatewayModal');
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


                $('.editGatewayBtn').click(function(){
                    var modal = $('#editManualGatewayModal');
                    var gateway = $(this).data('resource');
                    var currency = $(this).data('currency');
                    modal.find('input[name=name]').val(gateway.name);
                    modal.find('input[name=currency]').val(currency.currency);
                    modal.find('.currency_symbol').text(currency.currency);
                    modal.find('input[name=rate]').val(parseFloat(currency.rate).toFixed(2));
                    modal.find('input[name=min_limit]').val(parseFloat(currency.min_amount).toFixed(2));
                    modal.find('input[name=max_limit]').val(parseFloat(currency.max_amount).toFixed(2));
                    modal.find('input[name=fixed_charge]').val(parseFloat(currency.fixed_charge).toFixed(2));
                    modal.find('input[name=percent_charge]').val(parseFloat(currency.percent_charge).toFixed(2));
                    modal.find('.nicEdit-main').html(gateway.description);
                    var html = '';
                    $.each(gateway.input_form, function(index, item) {
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
                                            <button class="btn btn--danger removeBtn btn-block h-100" type="button">
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

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.user-data').remove();
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
                                        <button class="btn btn--danger removeBtn btn-block h-100" type="button">
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
