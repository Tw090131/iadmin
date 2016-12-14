var PermissionList = function() {
      var permissionInit = function(){
          $('#datatable-responsive').DataTable({
              "processing": true,
              "serverSide": true,//开启服务模式  指定显示十条  就只渲染10条
              "searchDelay": 800,//搜索延迟
              "dom":"<'row'<'#id.col-sm-3'l><'col-sm-3'l><'col-sm-3'l><'col-sm-3'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
              "initComplete":function(data){
                  console.log(data);
                  $('#id').append("<button>add</button>")
              },
              "search":{
                  regex:true,
              },
              "ajax": {
                  // ajax请求地址
                'url' : '/admin/permissions/ajaxIndex',

                // 传递额外参数
                // "data": function ( d ) {
                //   d.test = 'this is tset';  request('test','');
                // }
             //  "info":'false',
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
             //   "visible":false,
                //render: function (data) {
                //        return '<a class="btn btn-xs btn-primary tooltips" href="" data-original-title="修改" data-placement="top"><i class="fa fa-pencil"></i> </a>　<button type="button" class="btn btn-danger glyphicon glyphicon-remove"></button>';
                //}
            },
             //   "columnsDefs":[{targets:6,visible:false}],
            ],
          });
      }
    return {
        init : permissionInit
    }
}();