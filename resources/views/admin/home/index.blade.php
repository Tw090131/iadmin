@extends('layouts.admin')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Plain Page</h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Plain Page</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Settings 1</a>
                </li>
                <li><a href="#">Settings 2</a>
                </li>
              </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            这是后台首页<br/><br/>
        一、<br/>
          1 添加权限<br/>
          2 添加菜单<br/>
          3 配置角色权限<br/>
          4 menupresenter 中有自动配置函数  要在permissions.php 中配置 需要补充appid 的控制器
          5 添加控制器和方法以及模版<br/>
          6 添加路由<br/>
          7 在控制器中加入验证appid  和 权限的 中间件<br/><br/><br/>


          二、 修改视图datatables 的显示过程、<br/>
          1复制创建模版  和 js<br/>
          2修改模版  和js<br/>
          3控制器新增方法<br/>
          4路由<br/><br/><br/>

          三、 菜单高亮显示  顶级菜单 url 和 heightlight  admin/模块*<br/>

          四、待完成:<br/><br/>

          用户名管理 修改   基础数据<br/><br/>

          角色 统计    //后期改成 每次查询  写一次缓存 后面的就读缓存<br/><br/>

          新增导入量测试<br/><br/>

          加一张表   id gid area_id   exp_num(导入量)   然后封装进 account_role 仓库的方法中<br/><br/>

          进入游戏次数统计接口，更新<br/><br/>

          全部重新测试一边<br/><br/>

          <div style="color:red">该成 cid  和 areaid 要加入  dailydata中</div>

          5datatables的使用
          1 定义table  表头  和 tbody
          2<!--第三步：初始化Datatables-->
          $(document).ready( function () {
          $('#table_id_example').DataTable();
          } );
        </div>
      </div>
    </div>
  </div>
</div>
@endsection