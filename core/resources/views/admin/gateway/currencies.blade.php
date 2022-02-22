@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th>@lang('Currency')</th>
                                <th>@lang('Limit')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Total Deposit')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($currencies as $currency)
                                <tr>
                                    <td>
                                        {{ $currency->name }} - <span class="fw-bold">{{ $currency->currency }}</span>
                                    </td>
                                    <td>
                                        @lang('Minimum'): <span class="fw-bold text--primary">{{ showAmount($currency->min_amount) }} {{ $general->cur_text }}</span><br>
                                        @lang('Maximum'): <span class="fw-bold text--primary">{{ showAmount($currency->max_amount) }} {{ $general->cur_text }}</span>
                                    </td>
                                    <td>
                                        @lang('Fixed'): <span class="fw-bold text--primary">{{ showAmount($currency->fixed_charge) }} {{ $general->cur_text }}</span><br>
                                        @lang('Percent'): <span class="fw-bold text--primary">{{ showAmount($currency->percent_charge) }}%</span>
                                    </td>
                                    <td>
                                        @lang('Amount'): <span class="fw-bold text--primary">{{ showAmount($currency->method->deposits->where('method_currency',$currency->currency)->sum('amount')) }} {{ $general->cur_text }}</span><br>
                                        @lang('Charge'): <span class="fw-bold text--primary">{{ showAmount($currency->method->deposits->where('method_currency',$currency->currency)->sum('charge')) }} {{ $general->cur_text }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline--primary editBtn"
                                        data-resource="{{ $currency }}"
                                        data-action="{{ route('admin.gateway.automatic.currency.update',$currency->id) }}"
                                        data-configs="{{ $currency->gateway_parameter }}"><i class="las la-pen"></i> @lang('Edit')</button>

                                        <button class="btn btn-sm btn-outline--danger removeBtn"
                                        data-resource="{{ $currency }}"
                                        data-action="{{ route('admin.gateway.automatic.currency.remove',$currency->id) }}"
                                        data-configs="{{ $currency->gateway_parameter }}"><i class="las la-trash"></i> @lang('Delete')</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('Currency not added yet')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ADD CURRENCY MODAL --}}
    <div id="currencyModal" class="modal fade">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Currency')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.gateway.automatic.currency.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="gateway_id" value="{{ $gateway->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Currency')</label>
                            <select class="form-control" name="currency">
                                <option value="">@lang('Select currency')</option>
                                @forelse($supportedCurrencies as $currency => $symbol)
                                    <option value="{{$currency}}" data-symbol="{{ $symbol }}">{{ __($currency) }} </option>
                                @empty
                                    <option value="">@lang('No more currency available')</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Limit')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Minimum')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="minimum" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Maximum')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="maximum" required/>
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
                                    <label>@lang('Fixed Charge')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="0" name="fixed_charge" required/>
                                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Percent Charge')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="0" name="percent_charge" required/>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Currency')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Currency')</label>
                                    <input type="text" class="form-control currency" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Symbol')</label>
                                    <input type="text" class="form-control" name="symbol" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Rate')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">1 {{ __($general->cur_text) }} = </span>
                                        <input type="text" class="form-control" placeholder="0" name="rate" required/>
                                        <span class="input-group-text currency_symbol"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($parameters->where('global', false)->count()  != 0 )
                        <h6>@lang('Configuration')</h6>
                        <div class="row">
                            @foreach($parameters->where('global', false) as $key => $param)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __($param->title) }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="{{ $key }}" required/>
                                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- EDIT CURRENCY MODAL --}}
    <div id="currencyEditModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Currency')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Limit')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Minimum')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="minimum" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Maximum')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ __($general->cur_sym) }}</span>
                                        <input type="text" class="form-control" placeholder="0" name="maximum" required/>
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
                                    <label>@lang('Fixed Charge')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="0" name="fixed_charge" required/>
                                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Percent Charge')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="0" name="percent_charge" required/>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-line-area mt-4">
                            <h6 class="border-line-title">@lang('Currency')</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Currency')</label>
                                    <input type="text" name="currency" class="form-control currency" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Symbol')</label>
                                    <input type="text" class="form-control" name="symbol" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Rate')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">1 {{ __($general->cur_text) }} = </span>
                                        <input type="text" class="form-control" placeholder="0" name="rate" required/>
                                        <span class="input-group-text currency_symbol"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($parameters->where('global', false)->count()  != 0 )
                        <h6>@lang('Configuration')</h6>
                        <div class="row">
                            @foreach($parameters->where('global', false) as $key => $param)
                            <div class="form-group col-md-12">
                                <label>{{ __($param->title) }}</label>
                                <input type="text" class="form-control {{ $key }}" name="param[{{ $key }}]" required/>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- REMOVE METHOD MODAL --}}
    <div id="currencyRemoveModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Currency')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h4 class="text-center">@lang('Are you sure to delete this?')</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary currencyBtn" data-bs-toggle="modal" data-bs-target="#currencyModal" ><i class="las la-plus"></i> @lang('Add Currency')</button>
@endpush

@push('script')
<script>
    $('input[name=symbol]').on('input',function(){
        $('.currency_symbol').text($(this).val());
    });

    $('select[name=currency]').change(function(){
        $('.currency').val($(this).val())
    });

    $('.currencyBtn').click(function(){
        var modal = $('#currencyModal');
        modal.find('form').trigger("reset");
        $('.currency_symbol').text('');
    })

    $('.editBtn').click(function(){
        var modal = $('#currencyEditModal');
        var currency = $(this).data('resource');
        var float = 2;
        modal.find('input[name=name]').val(currency.name);
        modal.find('.currency').val(currency.currency);
        modal.find('input[name=fixed_charge]').val(parseFloat(currency.fixed_charge).toFixed(float));
        modal.find('input[name=percent_charge]').val(parseFloat(currency.percent_charge).toFixed(float));
        modal.find('input[name=rate]').val(parseFloat(currency.rate).toFixed(float));
        modal.find('input[name=symbol]').val(currency.symbol);
        modal.find('input[name=minimum]').val(parseFloat(currency.min_amount).toFixed(float));
        modal.find('input[name=maximum]').val(parseFloat(currency.max_amount).toFixed(float));
        modal.find('.currency_symbol').text(currency.currency);
        modal.find('form').attr('action',$(this).data('action'));
        var configs = $(this).data('configs');
        if (configs) {
            for (const [key, value] of Object.entries(configs)) {
                modal.find(`.${key}`).val(value);
            }
        }
        modal.modal('show');
    });

    $('.removeBtn').click(function(){
        var modal = $('#currencyRemoveModal');
        modal.find('form').attr('action',$(this).data('action'));
        modal.modal('show');
    });
</script>
@endpush