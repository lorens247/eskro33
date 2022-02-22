@php
    $sideLinksFile = file_get_contents(resource_path('views/admin/partials/sidenav.json'));
    $sideBarLinks = json_decode($sideLinksFile);
@endphp

<div class="sidebar">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(fileManager()->logoIcon()->path .'/logo.png')}}" alt="@lang('image')"></a>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">

                @foreach($sideBarLinks as $key => $link)
                <li class="sidebar-menu-item {{menuActive($link->active_key)}}">
                    <a href="{{route($link->route)}}" class="nav-link ">
                        <i class="menu-icon {{ $link->icon }}"></i>
                        <span class="menu-title">{{ __($link->name) }}</span>
                        @if(@$link->action_key)
                            @php
                                $actionCount = 0;
                            @endphp
                            @foreach($link->action_key as $action_key)
                                @php $actionCount += $actionRequire[$action_key] @endphp
                            @endforeach
                            @if($actionCount > 0)
                            <span class="menu-badge pill bg--primary ms-auto">
                                {{ $actionCount }}
                            </span>
                            @endif
                        @endif
                    </a>
                </li>
                @endforeach

            </ul>
        </div>
    </div>
</div>
<!-- sidebar end -->
