<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\MenuRepository;
use App\Http\Requests\MenuRequest;
class MenuController extends Controller
{
    private $menu;

    public function __construct(MenuRepository $menu)
    {
       // dd($menu);
       // $this->middleware('check.permission:menu');//后面的为控制器名称就好了
        $this->menu = $menu;
    }

    public function index()
    {
        $menu = $this->menu->findByField('parent_id',0);

        $menuList = $this->menu->getMenuList();
        //dd($menuList);
        return view('admin.menu.list')->with(compact('menu','menuList'));
       // return view('admin.menu.list');
    }

    /**
     * 添加菜单  use 一下request  然后直接注入
     */
    public function store(MenuRequest $request)
    {
        $result = $this->menu->create($request->all());
        // 刷新缓存
        $this->menu->sortMenuSetCache();
        if ($result) {
            flash('添加菜单成功', 'success');
        }else{
            flash('添加菜单失败', 'error');
        }
        return redirect('admin/menus');
    }

    /**
     * 修改菜单获取数据
     */
    public function edit($id)
    {
        $menu = $this->menu->editMenu($id);
        return response()->json($menu);//用这个返回json  与 json_encode 一样吧
    }
    /**
     * 修改菜单数据
     */
    public function update(MenuRequest $request)
    {
        $this->menu->updateMenu($request);
        return redirect('admin/menus');
    }
    /**
     * 删除菜单
     */
    public function destroy($id){
        $this->menu->destroyMenu($id);
        return redirect('admin/menus');
    }
}
