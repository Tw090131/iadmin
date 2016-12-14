var RolesList = function(appid) {
      var rolesInit = function(appid){
          $('#datatable-responsive').DataTable({
              "processing": true,
              "serverSide": true,//开启服务模式
              "searchDelay": 800,//搜索延迟
              "search":{
                  regex:true,
              },
              "ajax": {
                  // ajax请求地址
                'url' : '/admin/basedata/ajaxBasedataRoles?appid='+appid,
                // 传递额外参数
                // "data": function ( d ) {
                //   d.test = 'this is tset';  request('test','');
                // }
            },
            // 注意: 这里列的数量必须和页面th标签数据量一致，否则会报错
            // orderable： 页面列排序，默认为true
            "columns": [
            {
                "data": "area_id",
                "name" : "area_id"
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
                "data": "account_num",
                "name": "account_num",
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
                "data": "role_num",
                "name": "role_num",
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
                "data": "hero_one",
                "name": "hero_one",
                "orderable" : false,
            },
            {
                "data": "hero_one_rate",
                "name": "hero_one_rate",
                "orderable" : false,
                render : function(data){
                    return data+'%';
                }
            },
            {
                "data": "hero_two",
                "name": "hero_two",
                "orderable" : false,
            },
            {
                "data": "hero_two_rate",
                "name": "hero_two_rate",
                "orderable" : false,
                render : function(data){
                    return data+'%';
                }
            },
            {
                "data": "hero_three",
                "name": "hero_three",
                "orderable" : false,
            },
            {
                "data": "hero_three_rate",
                "name": "hero_three_rate",
                "orderable" : false,
                render : function(data){
                    return data+'%';
                }
            },
            {
                "data": "hero_four",
                "name": "hero_four",
                "orderable" : false,
            },
            {
                "data": "hero_four_rate",
                "name": "hero_four_rate",
                "orderable" : false,
                render : function(data){
                    return data+'%';
                }
            },
            {
                "data": "hero_five",
                "name": "hero_four",
                "orderable" : false,
            },
            {
                "data": "hero_five_rate",
                "name": "hero_five_rate",
                "orderable" : false,
                render : function(data){
                    return data+'%';
                }
            },
                {
                    "data": "hero_six",
                    "name": "hero_six",
                    "orderable" : false,
                },
                {
                    "data": "hero_six_rate",
                    "name": "hero_six_rate",
                    "orderable" : false,
                    render : function(data){
                        return data+'%';
                    }
                },


          ],
          });
      }
    return {
        init : rolesInit
    }
}();