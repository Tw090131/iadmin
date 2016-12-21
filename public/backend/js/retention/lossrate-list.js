var List = function(appid,channel,area,world) {

      var Init = function(appid,channel,area,world){
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
                      d.world=world;
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
                "data": "world",
                "name" : "world"
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
                    "data": "regs_rate",
                    "name": "regs_rate",
                    "orderable" : false,
                    render : function(data){
                        return data+'%';
                    }
                },
                {
                    "data": "new_role_num",
                    "name": "new_role_num",
                    "orderable" : false,
                },
                {
                    "data": "regs_role_rate",
                    "name": "regs_role_rate",
                    "orderable" : false,
                    render : function(data){
                        return data+'%';
                    }
                },
                {
                    "data": "new_role_num",
                    "name": "new_role_num",
                    "orderable" : false,
                },
                {
                    "data": "regs_role_rate",
                    "name": "regs_role_rate",
                    "orderable" : false,
                    render : function(data){
                        return data+'%';
                    }
                },
                {
                    "data": "new_role_num",
                    "name": "new_role_num",
                    "orderable" : false,
                },
                {
                    "data": "regs_role_rate",
                    "name": "regs_role_rate",
                    "orderable" : false,
                    render : function(data){
                        return data+'%';
                    }
                },
          ],
          });
          return dt;
      }
    return {
        init : Init
    }
}();