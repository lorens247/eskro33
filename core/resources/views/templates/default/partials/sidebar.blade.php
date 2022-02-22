<div class="sidebar-menu">
    <div class="sidebar-menu-inner">
        <div class="logo-env">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ getImage(fileManager()->logoIcon()->path.'/logo.png') }}" width="120" alt="logo">
                </a>
            </div>
            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon">
                    <i class="las la-bars"></i>
                </a>
            </div>
            <div class="sidebar-mobile-menu">
                <a href="#" class="with-animation">
                    <i class="las la-bars"></i>
                </a>
            </div> 
        </div>
        <ul id="sidebar-main-menu" class="sidebar-main-menu">
            <li class="sidebar-single-menu nav-item {{ activeSideNav('user.home') }}">
                <a href="{{ route('user.home') }}">
                    <i class="las la-radiation-alt"></i>
                    <span class="title">@lang('Dashboard')</span>
                </a>
            </li>
            <li class="sidebar-single-menu has-sub nav-item {{ activeSideNav('user.deposit*') }}">
                <a href="#" class="open-icon-link">
                    <i class="las la-cloud-upload-alt"></i><span class="title"> @lang('Deposit')</span>
                </a>
                <ul class="sidebar-submenu">
                    <li class="nav-item {{ activeSideNav('user.deposit') }}">
                        <a href="{{ route('user.deposit') }}">
                            <i class="las la-plus-circle"></i><span class="title"> @lang('Deposit Now')</span>
                        </a>
                    </li>
                    <li class="nav-item {{ activeSideNav('user.deposit.history') }} ">
                        <a href="{{ route('user.deposit.history') }}">
                            <i class="las la-history"></i><span class="title"> @lang('Deposit History')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-single-menu has-sub nav-item {{ activeSideNav('user.escrow*') }}">
                <a href="#" class="open-icon-link">
                    <i class="las la-cloud-upload-alt"></i><span class="title"> @lang('Escrow')</span>
                </a>
                <ul class="sidebar-submenu">
                    <li class="nav-item {{ activeSideNav('user.escrow') }}">
                        <a href="{{ route('user.escrow') }}">
                            <i class="las la-plus-circle"></i><span class="title"> @lang('My Escrow')</span>
                        </a>
                    </li>
                    <li class="nav-item {{ activeSideNav('user.escrow.create') }} ">
                        <a href="{{ route('user.escrow.create') }}">
                            <i class="las la-history"></i><span class="title"> @lang('Create Escrow')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-single-menu has-sub nav-item {{ activeSideNav('user.withdraw*') }}">
                <a href="#" class="open-icon-link">
                    <i class="las la-cloud-download-alt"></i><span class="title">@lang('Withdrawal')</span>
                </a>
                <ul class="sidebar-submenu">
                    <li class="nav-item {{ activeSideNav('user.withdraw') }}">
                        <a href="{{ route('user.withdraw') }}">
                            <i class="las la-plus-circle"></i><span class="title"> @lang('Withdraw Now')</span>
                        </a>
                    </li>
                    <li class="nav-item {{ activeSideNav('user.withdraw.history') }}">
                        <a href="{{ route('user.withdraw.history') }}">
                            <i class="las la-history"></i><span class="title"> @lang('Withdraw History')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-single-menu nav-item {{ activeSideNav('user.transactions') }}">
                <a href="{{ route('user.transactions') }}">
                    <i class="las la-exchange-alt"></i>
                    <span class="title">@lang('Transactions')</span>
                </a>
            </li>
            <li class="sidebar-single-menu has-sub nav-item {{ activeSideNav('ticket*') }}">
                <a href="#" class="open-icon-link">
                    <i class="las la-cloud-download-alt"></i><span class="title">@lang('Support Ticket')</span>
                </a>
                <ul class="sidebar-submenu">
                    <li class="nav-item {{ activeSideNav('ticket.open') }}">
                        <a href="{{ route('ticket.open') }}">
                            <i class="las la-plus-circle"></i><span class="title"> @lang('Create Ticket')</span>
                        </a>
                    </li>
                    <li class="nav-item {{ activeSideNav('ticket') }}">
                        <a href="{{ route('ticket') }}">
                            <i class="las la-history"></i><span class="title"> @lang('Ticket List')</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-single-menu nav-item {{ activeSideNav('twofactor') }}">
                <a href="{{ route('user.twofactor') }}">
                    <i class="las la-lock"></i>
                    <span class="title">@lang('2FA Security')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item">
                <a href="{{ route('user.logout') }}">
                    <i class="las la-power-off"></i>
                    <span class="title">@lang('Logout')</span>
                </a>
            </li>
        </ul>
        @php
            $socials = getContent('social_icon.element',false,null,true);
        @endphp
        <div class="footer-area text-center">
            <div class="social-area">
                <ul class="footer-social">
                    @foreach($socials as $social)
                    <li><a href="{{ __($social->data_values->url) }}" target="_blank">@php echo $social->data_values->social_icon @endphp</a></li>
                    @endforeach
                </ul>
            </div>
            <p>@lang('Copyright') &copy; {{ date('Y') }}</p>
        </div>
    </div>
</div>
