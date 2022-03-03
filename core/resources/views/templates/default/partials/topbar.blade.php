<div class="body-header-area d-flex flex-wrap align-items-center justify-content-between mb-10-none">
    <div class="body-header-left">
        <h3 class="title">{{ __($pageTitle) }}</h3>
    </div>
    <div class="body-header-right dropdown">
        <button type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true"
            aria-expanded="false">
            <div class="header-user-area">
                <div class="header-user-thumb">
                    <a href="#0"><i class="las la-user"></i></a>
                </div>
            </div>
        </button>
        <div class="dropdown-menu dropdown-menu--sm p-0 border-0 dropdown-menu-right">
            <a href="{{ route('user.profile.setting') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-user-circle"></i>
                <span class="dropdown-menu__caption">@lang('Profile Settings')</span>
            </a>
            <a href="{{ route('user.password.setting') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-key"></i>
                <span class="dropdown-menu__caption">@lang('Change Password')</span>
            </a>
            <a href="{{ route('user.logout') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-power-off"></i>
                <span class="dropdown-menu__caption">@lang('Logout')</span>
            </a>
        </div>
    </div>
</div>
