<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\PermissionRepository;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private $role;
    private $permission;

    function __construct(RoleRepository $role,PermissionRepository $permission)
    {
       // $this->middleware('check.permission:role');//后面的为控制器名称就好了
        $this->role = $role;
        $this->permission=$permission;
    }

    public function index()
    {
        return view('admin/role/list');
    }

    public function ajaxIndex()
    {
        $result = $this->role->ajaxIndex();
        // return   json_encode($result);
        return response()->json($result);
    }

    public function create()
    {
        $permissions = $this->permission->findPermissionWithArray();
        //dd($permissions);
        return view('admin.role.create')->with(compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        //dd(request()->all());
        $this->role->store($request);
       // $this->role->createRole($request->all());
        return redirect('admin/roles');
    }

    /**
     * 查看角色权限
     */
    public function show($id)
    {
        $permissions = $this->role->show($id);

       // dd($permissions);

     //   return response()->json($permissions);
       // dd($permissions);
        return view('admin.role.show',compact('permissions'));
    }

    /**
     * 修改角色视图

     */
    public function edit($id)
    {
        $role = $this->role->edit($id);
       // dd($role);
        $permissions = $this->permission->findPermissionWithArray();
       //dd($permissions);

//        $results = DB::select('select permission_id from iadmin_permission_role where role_id = :id', ['id' => $id]);
//       //dd($results);
//        $arr=[];
//        foreach($results as $k => $v){
//            $arr[] = $v->permission_id;
//        }
       // dd($arr_result);
        return view('admin.role.edit')->with(compact(['role','permissions']));
    }

    /**
     * 删除角色
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->role->destroy($id);
        return redirect('admin/roles');
    }

    public function update(RoleRequest $request,$id)
    {
        $this->role ->updateRole($request,$id);
        return redirect('admin/roles');
    }
}
