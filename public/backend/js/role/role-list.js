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
                'url' : '/admin/roles/ajaxIndex',
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
                "data": "display_name",
                "name" : "display_name",
                "orderable" : false,
                //render : function(data){
                //    return data+'--test';
                //}
            },
            {
                "data": "name",
                "name": "name",
                "orderable" : false,
            },
            { 
              "data": "description",
              "name": "description",
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
          /*modal事件监听*/
          $(".modal").on("hidden.bs.modal", function() {
              $(this).removeData("bs.modal");
          });
          //$(".modal").on("hidden.bs.modal", function() {
          //    $(".modal-content").empty();
          //});
      }
    return {
        init : permissionInit
    }
}();