var AllList = function(appid,channel,area) {
      var allInit = function(appid,channel,area){
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
                'url' : '/admin/basedata/ajaxBasedataAll?appid='+appid,
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
                //"orderable" : false,
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
              "data": "new_role_num",
              "name": "new_role_num",
              "orderable" : false,
            },
            {
                "data": "active_account_num",
                "name": "active_account_num",
                "orderable" : false,
            },
            {
                "data": "active_pay_num",
                "name": "active_pay_num",
                "orderable" : false,
            },
            {
                "data": "active_pay_rate",
                "name": "active_pay_rate",
                "orderable" : false,
            },
            {
                "data": "active_pay_money",
                "name": "lc30",
                "orderable" : false,
            },
            {
                "data": "new_pay_num",
                "name": "new_pay_num",
                "orderable" : false,
            },
            {
                "data": "new_pay_rate",
                "name": "new_pay_rate",
                "orderable" : false,
            },
            {
                "data": "new_pay_money",
                "name": "new_pay_money",
                "orderable" : false,
            },
            {
                "data": "income",
                "name": "income",
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
        init : allInit,
    }
}();

