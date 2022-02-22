@php
    $sidenavData = file_get_contents(resource_path('views/admin/partials/sidenav.json'));
    $sidenavs = [];
    foreach(json_decode($sidenavData) as $sidenav){
        $sidebar['name'] = $sidenav->name;
        $sidebar['url'] = route($sidenav->route);
        $sidebar['icon'] = $sidenav->icon;
        $sidenavs[] = $sidebar;
    }
    $tabnavData = file_get_contents(resource_path('views/admin/partials/tabnav.json'));
    $tabnavs = [];
    foreach(json_decode($tabnavData) as $key => $tabnav){
        foreach($tabnav as $tabItem){
            $tabBar['name'] = ucfirst($key).' - '.$tabItem->name;
            $tabBar['url'] = route($tabItem->route);
            $tabBar['icon'] = $tabItem->icon;
            $tabnavs[] = $tabBar;
        }
    }
@endphp

<script>
    (function($){
        "use strict"
        var sidenav = @json($sidenavs);
        var tabnav =  @json($tabnavs);
        $('.nav__item').hide();
        $('.test-search').on('input', function () {
            var search = $(this).val().toLowerCase();
            if(!search){
                $('.nav__item').hide();
                return false;
            }
            var html = '';
            sidenav.forEach(item => {
                var name = item.name.toLowerCase();
                if(name.indexOf(search) >= 0){
                    html += `<li><a href="${item.url}">${item.name}</a></li>`;
                }
            });
            tabnav.forEach(item => {
                var name = item.name.toLowerCase();
                if(name.indexOf(search) >= 0){
                    html += `<li><a href="${item.url}">${item.name}</a></li>`;
                }
            });
            if(html != ''){
                $('.nav__item').show();
                $('.nav__item').html(html);
            }else{
                $('.nav__item').hide();
            }
        });
    })(jQuery);
</script>
