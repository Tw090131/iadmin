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
          <h2>添加角色</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <form action="{{url('admin/roles')}}" method="post" class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">角色<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="first-name" name="name" class="form-control col-md-7 col-xs-12" placeholder="英文名称">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">角色名称<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="last-name" name="display_name" class="form-control col-md-7 col-xs-12" placeholder="中文名称">
              </div>
            </div>
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">描述</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="description"cols="30" rows="10" class="form-control col-md-7 col-xs-12"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">权限</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="table-scrollable">
                  <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th class="col-md-1 text-center">{{trans('labels.roles.module')}}</th>
                      <th class="col-md-10 text-center">{{trans('labels.roles.permission')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($permissions)
                      @foreach($permissions as $permission)
                        @foreach($permission as $k => $v)
                          <tr>
                            <td class="text-center" style="vertical-align: middle;"> {{$k}} </td>
                            <td>
                              @if(isDoubleArray($v))
                                @foreach($v as $val)
                                  <div class="col-md-4">
                                    <div class="md-checkbox">
                                      <input type="checkbox" name="permission[]" id="{{$val['key']}}" value="{{$val['id']}}" class="md-check">
                                      <label for="{{$val['key']}}" class="tooltips" data-placement="top" data-original-title="{{$val['desc']}}">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{$val['display_name']}} </label>
                                    </div>
                                  </div>
                                @endforeach
                              @else
                                <div class="col-md-4">
                                  <div class="md-checkbox">
                                    <input type="checkbox" name="permission[]" id="{{$v['key']}}" value="{{$v['id']}}" class="md-check">
                                    <label for="{{$v['key']}}" class="tooltips" data-placement="top" data-original-title="{{$v['desc']}}">
                                      <span></span>
                                      <span class="check"></span>
                                      <span class="box"></span> {{$v['display_name']}} </label>
                                  </div>
                                </div>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                      @endforeach
                    @endif
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href="{{url()->previous()}}" class="btn btn-primary">Cancel</a>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection