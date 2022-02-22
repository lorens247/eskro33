@extends('admin.layouts.app')
@tsknav('gateway')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th>@lang('Gateway')</th>
                                <th>@lang('Supported Currency')</th>
                                <th>@lang('Enabled Currency')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gateways->sortBy('alias') as $k=>$gateway)
                                @php
                                    $parameters = collect(json_decode($gateway->gateway_parameters));
                                @endphp
                                <tr>
                                    <td data-label="@lang('Gateway')">{{__($gateway->name)}}</td>

                                    <td data-label="@lang('Supported Currency')">
                                        {{ count(json_decode($gateway->supported_currencies,true)) }}
                                    </td>
                                    <td data-label="@lang('Enabled Currency')">
                                        {{ $gateway->currencies->count() }}
                                    </td>


                                    <td data-label="@lang('Status')">
                                        @if($gateway->status == 1)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Inactive')</span>
                                        @endif

                                    </td>
                                    <td data-label="@lang('Action')">
                                        <div class="button--group style--sm justify-content-end">
                                            <button class="btn btn-sm btn-outline--primary configBtn"
                                                data-config="{{ json_encode($gateway->extra) }}"
                                                data-global="{{ json_encode($parameters->where('global', true)) }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#configModal"
                                                data-action="{{ route('admin.gateway.automatic.configure',$gateway->id) }}"
                                                data-status="{{ $gateway->status }}">
                                                <i class="la la-cog"></i> @lang('Config')
                                            </button>
                                            <a href="{{ route('admin.gateway.automatic.currency',$gateway->id) }}" class="btn btn-sm btn-outline--info"><i class="las la-dollar-sign"></i> @lang('Currencies')</a>
                                        </div>
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
    <!-- Button trigger modal -->

    {{-- CONFIG METHOD MODAL --}}
    <div id="configModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Payment Method Configuration')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="config">
                            <div class="row">

                            </div>
                        </div>
                        <div class="globalConfig">
                            <div class="row">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
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

@push('script')
    <script>
        (function ($) {
            "use strict"

            $(document).on('click','.configBtn',function(){
                var configHtml = `<div class="col-md-12"><h6 class="mb-2">@lang('Configurations')</h6></div>`;
                var config = $(this).data('config');
                if(config){
                    for (const [key, value] of Object.entries(config)) {
                      configHtml += `
                            <div class="form-group col-lg-12">
                                <label>${value.title}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ url('/ipn') }}/${value.link}" readonly/>
                                    <span class="input-group-text copyInput" title="@lang('Copy')"><i class="fa fa-copy"></i></span>
                                </div>
                            </div>
                      `;
                    }
                    $('.config').find('.row').html(configHtml);
                }else{
                    $('.config').find('.row').html('');
                }
                var globalConfigHtml = `<div class="col-md-12"><h6 class="mb-2">@lang('Global Configurations')</h6></div>`;
                var globalConfig = $(this).data('global');
                if (globalConfig) {
                    for (const [key, value] of Object.entries(globalConfig)) {
                        globalConfigHtml += `
                            <div class="form-group col-lg-12">
                                <label>${value.title} </label>
                                <input type="text" class="form-control" name="global[${key}]" value="${value.value}" required/>
                            </div>
                        `;
                    }
                    $('.globalConfig').find('.row').html(globalConfigHtml);
                }else{
                    $('.globalConfig').find('.row').html('');
                }

                var modal = $('#configModal');

                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                modal.find('form').attr('action',$(this).data('action'));

            });

            $(document).on('click','.copyInput',function (e) {
                var copybtn = $(this);
                var input = copybtn.parents('.input-group').find('input');
                if (input && input.select) {
                    input.select();
                    try {
                        document.execCommand('SelectAll')
                        document.execCommand('Copy', false, null);
                        input.blur();
                        notify('success',`Copied: ${copybtn.closest('.input-group').find('input').val()}`);
                    } catch (err) {
                        alert('Please press Ctrl/Cmd + C to copy');
                    }
                }
            });
        })(jQuery);
    </script>
@endpush
