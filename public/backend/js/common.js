
//获取 参数值
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}

$(function () {
    var appid = getUrlParam('appid');
    var table = List.init(appid);
    $("#channel_kuang").on('change','#channel',function(){
        var cid = $('#channel option:selected').val();
        var area = $('#area option:selected').val();
        var world = $('#world option:selected').val();
        table.destroy();
        $('tbody').empty(); // empty in case the columns change
        table = List.init(appid,cid,area,world);
    })
    $("#area_kuang").on('change','#area',function(){
        var cid = $('#channel option:selected').val();
        var area = $('#area option:selected').val();
        var world = $('#world option:selected').val();
        table.destroy();
        $('tbody').empty(); // empty in case the columns change
        table = List.init(appid,cid,area,world);
    })
    $("#world_kuang").on('change','#world',function(){
        var cid = $('#channel option:selected').val();
        var area = $('#area option:selected').val();
        var world = $('#world option:selected').val();
        table.destroy();
        $('tbody').empty(); // empty in case the columns change
        table = List.init(appid,cid,area,world);
    })
});