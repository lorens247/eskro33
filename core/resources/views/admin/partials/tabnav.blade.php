@php
    $tabLinksFile = file_get_contents(resource_path('views/admin/partials/tabnav.json'));
    $tabLinks = json_decode($tabLinksFile);
    $tabLinks = $tabLinks->$tabKey;
@endphp
<ul class="breadcum-nav">
    <button class="breadcum-nav-close"><i class="las la-times"></i></button>
    @foreach($tabLinks as $tabLink)

    <li class="{{menuActive([$tabLink->route])}} @if(@in_array(request()->route()->getName(),@$tabLink->extra_route ?? [])) active @endif">
        <a href="{{route($tabLink->route,@$tabLink->param)}}">
            <i class="{{ $tabLink->icon }}"></i>
            <span class="menu-title">{{ __($tabLink->name) }}</span>
            @if(@$tabLink->action_key && @$actionRequire[$tabLink->action_key] > 0)
                <span class="menu-badge pill bg--primary ml-auto">{{$actionRequire[$tabLink->action_key]}}</span>
            @endif
        </a>
    </li>
    @endforeach
</ul>
