@extends('layouts.admin')
@section('css')
<link href="{{asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<style>
    .buttons, button, .btn {
      margin-bottom: 5px;
      margin-right: 5px;
    }
    .btn {
      -moz-user-select: none;
      background-image: none;
      border: 1px solid transparent;
      border-radius: 4px;
      cursor: pointer;
      display: inline-block;
      font-size: 14px;
      font-weight: 400;
      line-height: 1.42857;
      margin-bottom: 0;
      padding: 6px 12px;
      text-align: center;
      vertical-align: middle;
      white-space: nowrap;
    }
    .per_modify {
      height: 28px;
      line-height: 28px;
    }
    .buttons, button, .btn {
      margin-bottom: 5px;
      margin-right: 5px;
    }
  </style>
@endsection
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
          <h2>角色概况</h2>
          <ul class="nav navbar-right panel_toolbox">
            @permission(config('admin.permissions.basedata.add'))
            <li><a href="{{url('admin/permissions/create')}}" class="btn btn-default"><i class="fa fa-plus"></i>添加</a>
            @endpermission
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          @include('flash::message')
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>角色概况</h2>
                  <div class="clearfix"></div>
                </div>
                  @include('layouts.channelarea')
                <div class="x_content">
                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                       <tr>
                        <th>区服</th>
                        <th>总导入量（还未考虑好）</th>
                        <th>总账号数</th>
                        <th>创帐号比例</th>
                        <th>总创角数</th>
                        <th>创角比例</th>
                        <th>1英雄数</th>
                        <th>1英雄比例</th>
                       <th>2英雄数</th>
                       <th>2英雄比例</th>
                       <th>3英雄数</th>
                       <th>3英雄比例</th>
                       <th>4英雄数</th>
                       <th>4英雄比例</th>
                       <th>5英雄数</th>
                       <th>5英雄比例</th>
                       <th>6英雄数</th>
                       <th>6英雄比例</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>

                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{asset('backend/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('backend/js/basedata/roles-list.js')}}"></script>
<script>
    $(function () {
        var appid = getUrlParam('appid');
        RolesList.init(appid);
    });

    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }
</script>
@endsection