var RetentionList = function(appid,channel,area) {

      var retentionInit = function(appid,channel,area){
          var dt = $('#datatable-responsive').DataTable({
              "processing": true,
              "serverSide": true,//开启服务模式
              "searchDelay": 800,//搜索延迟
              "dom":"<'row'<'#id.col-sm-3'l><'col-sm-3' <'#channel_kuang'>><'col-sm-3' <'#area_kuang'>><'col-sm-3'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
              "search":{
                  regex:true,
              },
              "ajax": {
                  // ajax请求地址
                'url' : '/admin/retention/ajaxRetentionIndex?appid='+appid,
                // 传递额外参数
                  "data": function ( d ) {
                      d.channel = channel; // request('test','');
                      d.area=area;
                  }
            },
            // 注意: 这里列的数量必须和页面th标签数据量一致，否则会报错
            // orderable： 页面列排序，默认为true
            "columns": [
            {
                "data": "date",
                "name" : "date"
              },
                {
                    "data": "type",
                    "name" : "type"
                },
            {
                "data": "new_exp",
                "name" : "new_exp",
             //   "orderable" : false,
                //render : function(data){
                //    return data+'--test';
                //}
            },
            {
                "data": "new_account_num",
                "name": "new_account_num",
                "orderable" : false,
            },
            { 
              "data": "lc2",
              "name": "lc2",
              "orderable" : false,
            },
            {
                "data": "lc3",
                "name": "lc3",
                "orderable" : false,
            },
            {
                "data": "lc7",
                "name": "lc7",
                "orderable" : false,
            },
            {
                "data": "lc15",
                "name": "lc15",
                "orderable" : false,
            },
            {
                "data": "lc30",
                "name": "lc30",
                "orderable" : false,
            },
            {
                "data": "lc60",
                "name": "lc60",
                "orderable" : false,
            },
            {
                "data": "lc90",
                "name": "lc90",
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
          ],
          });
          return dt;
      }
    return {
        init : retentionInit
    }
}();