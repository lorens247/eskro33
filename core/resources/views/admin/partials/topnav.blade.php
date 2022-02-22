<!-- navbar-wrapper start -->
<nav class="navbar-wrapper">
    <div class="navbar__left">
        <div class="sidebar__in d-xl-none me-2">
            <i class="las la-bars"></i>
        </div>

        <div class="navbar-search-area">
            <input type="text" class="test-search navbar-search-field" placeholder="Search here...">
            <ul class="navbar-search-list nav__item">

            </ul>
        </div>
    </div>
    <div class="navbar__right">
        <ul class="navbar__action-list">
            <li class="dropdown">
                <a href="{{ route('admin.notify') }}" class="notification-btn bg--primary">
                    <i class="las la-bell text-white @if($adminNotifications > 0) icon-shake @endif"></i>
                    @if($adminNotifications)
                    <span class="notification-badge">{{$adminNotifications}}</span>
                    @endif
                </a>
            </li>


            <li class="dropdown">
                <a href="{{ route('admin.profile') }}">
                  <span class="navbar-user">
                    <span class="navbar-user__thumb"><img src="{{ getImage(fileManager()->profile()->admin->path.'/'.auth()->guard('admin')->user()->image) }}" alt="image"></span>
                    <span class="navbar-user__info">
                      <span class="navbar-user__name">{{auth()->guard('admin')->user()->username}}</span>
                    </span>
                    <span class="icon"><i class="las la-cog"></i></span>
                  </span>
                </a>
            </li>
        </ul>
    </div>

    <button type="button" class="breadcum-nav-open d-none">
        <i class="las la-sliders-h"></i>
    </button>

</nav>
<!-- navbar-wrapper end -->
@push('script')
<script>
    $('.sidebar__in').on('click', function(){
        $('.sidebar').addClass('open')
    })
</script>
@endpush
