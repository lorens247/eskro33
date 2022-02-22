@extends('admin.layouts.app')
@tsknav('user')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--5 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Contact Info')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Member Since')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="fw-bold">{{$user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                    </span>
                                </td>

                                <td data-label="@lang('Contact Info')">
                                    {{ $user->email }}<br>+{{ $user->mobile }}
                                </td>

                                <td data-label="@lang('Country')">
                                    {{ $user->country_code }} <br> {{ @$user->address->country }}
                                </td>

                                <td data-label="@lang('Member Since')">
                                    {{ showDateTime($user->created_at) }} <br> {{ diffForHumans($user->created_at) }}
                                </td>


                                <td data-label="@lang('Balance')">
                                    <span class="fw-bold">
                                    {{ $general->cur_sym }}{{ showAmount($user->balance) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.users.detail', $user->id) }}" class="btn btn-sm btn-outline--primary">
                                        <i class="las la-desktop text--shadow"></i> @lang('Details')
                                    </a>
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
                @if($users->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($users) }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection



@push('breadcrumb-plugins')
    <form action="{{ route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group bg-white">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <button type="submit" class="input-group-text bg--primary text-white"><i class="fa fa-search"></i></button>
        </div>
    </form>

@endpush

