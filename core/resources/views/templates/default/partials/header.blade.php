<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ getImage(fileManager()->logoIcon()->path.'/logo.png') }}" alt="site-logo"></a>
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                            @stack('header')

                            <div class="header-action">
                                @guest
                                <a href="{{ route('user.login') }}" class="btn--base">@lang('Sign In')</a>
                                <a href="{{ route('user.register') }}" class="btn--base">@lang('Sign Up')</a>
                                @else
                                <a href="{{ route('user.home') }}" class="btn--base">@lang('Dashboard')</a>
                                <a href="{{ route('user.logout') }}" class="btn--base">@lang('Logout')</a>
                                @endguest
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
