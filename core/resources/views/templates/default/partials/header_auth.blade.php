<ul class="navbar-nav main-menu ms-auto">
    <li>
        <a href="{{ route('user.home') }}">
            @lang('Dashboard')
        </a>
    </li>
    <li class="menu_has_children">
        <a href="#" class="open-icon-link">@lang('Deposit')
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="{{ route('user.deposit') }}">@lang('Deposit Now')
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.deposit.history') }}">@lang('Deposit History')
                </a>
            </li>
        </ul>
    </li>
    <li class="menu_has_children">
        <a href="#" class="open-icon-link">@lang('Escrow')
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="{{ route('user.escrow') }}">@lang('My Escrow')
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.escrow.create') }}">@lang('Create Escrow')
                </a>
            </li>
        </ul>
    </li>
    <li class="menu_has_children">
        <a href="#" class="open-icon-link">@lang('Withdrawal')
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="{{ route('user.withdraw') }}">@lang('Withdraw Now')
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.withdraw.history') }}"> @lang('Withdraw History')
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ route('user.transactions') }}">
            @lang('Transactions')
        </a>
    </li>
    <li class="menu_has_children">
        <a href="#" class="open-icon-link">@lang('Account')
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="{{ route('ticket.open') }}"> @lang('Create Ticket')
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ticket') }}">@lang('Ticket List')
                </a>
            </li>
            <li>
                <a href="{{ route('user.twofactor') }}">
                    @lang('2FA Security')
                </a>
            </li>

            <li>
                <a href="{{ route('user.profile.setting') }}">
                    @lang('Profile Settings')
                </a>
            </li>
            <li>
                <a href="{{ route('user.password.setting') }}">
                    @lang('Change Password')
                </a>
            </li>
        </ul>
    </li>

</ul>
