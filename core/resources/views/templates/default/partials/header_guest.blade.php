<ul class="navbar-nav main-menu ms-auto">
    <li><a href="{{ route('home') }}">@lang('Home')</a></li>
    @foreach($pages as $k => $data)
        <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
    @endforeach
    <li><a href="{{ route('blogs') }}">@lang('Blog')</a></li>
    <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
</ul>
