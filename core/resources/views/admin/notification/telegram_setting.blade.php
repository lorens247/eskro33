@extends('admin.layouts.app')
@tsknav('notification')
@section('panel')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>@lang('BOT Username')</label>
                        <div class="input-group">
                            <span class="input-group-text">http://t.me/</span>
                            <input type="text" name="name" class="form-control" value="{{ @$general->telegram_config->name }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('Bot Token')</label>
                        <input type="text" name="bot_token" class="form-control" value="{{ @$general->telegram_config->bot_token }}" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>




{{-- TEST TELEGRAM MODAL --}}
    <div id="testTelegramModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Test Telegram Setup')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.notification.telegram.test') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>@lang('Sent to') </label>
                                <input type="text" name="telegram_username" class="form-control" placeholder="@lang('Telegram Username')">
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


{{-- TEST TELEGRAM MODAL --}}
    <div id="telegramBotModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Test Telegram Setup')</h5>
                    <button type="button" class="close bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>@lang('To Do')</th>
                                    <th>@lang('Description')</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>@lang('Step 1')</td>
                                <td>@lang('Install Telegram App.')</td>
                            </tr>
                            <tr>
                                <td>@lang('Step 2')</td>
                                <td>@lang('Open App and Search for ')<code class="text-danger">@BotFather</code></td>
                            </tr>
                            <tr>
                                <td>@lang('Step 3')</td>
                                <td>@lang('Start Conversion As ')<code class="text-danger">/newbot</code></td>
                            </tr>
                            <tr>
                                <td>@lang('Step 4')</td>
                                <td>@lang('Chose a Bot Name and Press Enter.')</td>
                            </tr>
                            <tr>
                                <td>@lang('Step 5')</td>
                                <td>@lang('Choose a username for your bot. It must end in `bot`. Like this, for example: TetrisBot or tetris_bot')</td>
                            </tr>
                            <tr>
                                <td>@lang('Step 6')</td>
                                <td>@lang('Bot will give you your BOT URL and API Key. Copy This and Paste Bellow.')</td>
                            </tr>
                            <tr>
                                <td>@lang('Step 7')</td>
                                <td>@lang('Write your Bot Description using ') <code class="text--primary">/setdescription</code></td>
                            </tr>
                            <tr>
                                <td>@lang('Step 8')</td>
                                <td>@lang('Set Bot Privacy using ') <code class="text--primary">/setprivacy</code></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button type="button" data-bs-target="#telegramBotModal" data-bs-toggle="modal" class="btn btn-outline--info mb-2">@lang('How To Create Telegram Bot')</button>
    <button type="button" data-bs-target="#testTelegramModal" data-bs-toggle="modal" class="btn btn-outline--primary mb-2">@lang('Send Test Telegram')</button>
@endpush
