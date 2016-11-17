<?php
namespace App\Http\Middleware;
use Closure;
use Route;
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$model)
    {
        $routeName = Route::currentRouteName();//获取当前路由名称
        $permission = '';
        //dd($routeName);
        switch ($routeName) {
            case 'admin.'.$model.'.index':
            case 'admin.'.$model.'.ajaxIndex':
                $permission = config('admin.permissions.'.$model.'.list','');  //种子文件  有menus 命名不规范
                break;
            case 'admin.'.$model.'.create':
            case 'admin.'.$model.'.store':
                $permission = config('admin.permissions.'.$model.'.add','');
                break;
            case 'admin.'.$model.'.edit':
            case 'admin.'.$model.'.update':
                $permission = config('admin.permissions.'.$model.'.edit','');
                break;

            default:
                $permission = config('admin.permissions.'.$model,'');
                break;
        }
        if (!$request->user()->can($permission)) {
            abort(503,trans('你没有权限次操作'));
        }
        return $next($request);
    }
}
