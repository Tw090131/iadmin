var PermissionList = function() {
      var permissionInit = function(){
          $('#datatable-responsive').DataTable({
              "processing": true,
              "serverSide": true,//开启服务模式
              "searchDelay": 800,//搜索延迟
              "search":{
                  regex:true,
              },
              "ajax": {
                  // ajax请求地址
                'url' : '/admin/game/ajaxIndex',
                // 传递额外参数
                // "data": function ( d ) {
                //   d.test = 'this is tset';  request('test','');
                // }
            },
            // 注意: 这里列的数量必须和页面th标签数据量一致，否则会报错
            // orderable： 页面列排序，默认为true
            "columns": [
            {
                "data": "id",
                "name" : "id"
              },
            {
                "data": "game_name",
                "name" : "game_name",
                "orderable" : false,
                //render : function(data){
                //    return data+'--test';
                //}
            },
            {
                "data": "game_url",
                "name": "game_url",
                "orderable" : false,
            },
            { 
              "data": "sort",
              "name": "sort",
              "orderable" : false,
            },
            {
                "data": "appid",
                "name": "appid",
                "orderable" : false,
            },
            {
                "data": "appsecret",
                "name": "appsecret",
                "orderable" : false,
            },
            { 
              "data": "created_at",
              "name": "created_at",
              "orderable" : true,
            },{ 
              "data": "updated_at",
              "name": "updated_at",
              "orderable" : true,
            },
            {
                "data": "actionButton",
                "name": "actionButton",
                "type": "html",
                "orderable" : false,
                //render: function (data) {
                //        return '<a class="btn btn-xs btn-primary tooltips" href="" data-original-title="修改" data-placement="top"><i class="fa fa-pencil"></i> </a>　<button type="button" class="btn btn-danger glyphicon glyphicon-remove"></button>';
                //}
            }],
          });
      }
    return {
        init : permissionInit
    }
}();