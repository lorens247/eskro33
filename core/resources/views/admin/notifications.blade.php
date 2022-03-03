@extends('admin.layouts.app')
@section('panel')
<div class="card">
    <div class="card-body">
        <div class="notify__area">
        	@forelse($notifications as $notification)
            <a class="notify__item @if($notification->read_status == 0) unread--notification @endif" href="{{ route('admin.notification.read',$notification->id) }}">
                <div class="notify__content">
                    <h6 class="title">{{ __($notification->title) }}</h6>
                    <span class="date"><i class="las la-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
                </div>
            </a>
            @empty
            <a class="notify__item" href="javascript:void(0)">
                <div class="notify__content">
                    <h6 class="title">@lang('Notification not found')</h6>
                </div>
            </a>
            @endforelse
        </div>
    </div>
    @if($notifications->hasPages())
    <div class="card-footer">
        {{ paginateLinks($notifications) }}
    </div>
    @endif
</div>
@endsection
@push('breadcrumb-plugins')
<a href="{{ route('admin.notifications.readAll') }}" class="btn btn-outline--primary">@lang('Mark all as read')</a>
@endpush
