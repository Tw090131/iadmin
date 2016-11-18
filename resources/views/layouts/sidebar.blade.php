@inject('menu','App\Repositories\Presenter\MenuPresenter')
<!-- sidebar menu -->

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>随意写点什么</h3>
    <ul class="nav side-menu">
      {!!$menu->sidebarMenus($slidebarMenus)!!}
      {{--{{dd(auth()->user()->can('admin.game.manager'))}}--}}
    </ul>
  </div>

</div>
<!-- /sidebar menu -->