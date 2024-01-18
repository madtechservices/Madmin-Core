@php
    $menus = Madtechservices\MadminCore\app\Utils\Sidebar\SidebarController::menus();   
@endphp

@isset($menus)
    @foreach ($menus as $menu)
        {{ $menu->render() }}
    @endforeach
@endisset