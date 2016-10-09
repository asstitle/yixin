/**
 * Created by Administrator on 2016/6/16 0016.
 */

$(function() {

    //表单ajax提交方法


    $(".submit_post").click(function() {
        var _form = $(this).parents("form");
        /*var _para = _form.serialize();
         var _action = _form.attr("action") ? _form.attr("action") : location.href;
         var _url = _action;
         _url += _action.indexOf("?") > -1 ? "&" : "?";
         _url += _para;
         //var _refer = _form.attr("refer") != undefined ? ("location.href = '"+_form.attr("refer")+"'") : "window.location.reload();";
         */
        if (!Validator.Validate(document.forms[_form.attr("name")],2)) {
            return false;
        }

        $.post(_form.attr("action"), _form.serialize(), function(data){
                if (data.error) {
                    layer.msg(data.error);
                    return false;
                }
                if (data.success) {
                    layer.alert(data.success);
                }
                if (data.url) {
                    window.setTimeout("location.href = '" + data.url + "'", 1000);
                }
                //清空表单下的所有输入框的值
                var isclear = _form.data("isclear");
                if (isclear != 'undefined') {
                    _form.find('input[type=text], textarea').val('');
                }

            },
            "json");
    });

    
    /**
   * 加入收藏功能
   */
  $($('.sub_nav ul li a').get(1)).click(function(){
    addFavorite('http://www.baidu.com','创富宝官网');
  });
  function addFavorite(sURL, sTitle) {
    sURL = encodeURI(sURL);
    try{
      window.external.addFavorite(sURL, sTitle);
    }catch(e) {
      try{
        window.sidebar.addPanel(sTitle, sURL, "");
      }catch (e) {
        alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.");
      }
    }
  }

})

//收藏
function addFavorite2() {
    var url = window.location;
    var title = document.title;
    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf("360se") > -1) {
        alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
    }
    else if (ua.indexOf("msie 8") > -1) {
        window.external.AddToFavoritesBar(url, title); //IE8
    }
    else if (document.all) {
        try{
           window.external.addFavorite(url, title);
        }catch(e){
           alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
           }
    }
    else if (window.sidebar) {
        window.sidebar.addPanel(title, url, "");
    }
    else {
        alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
    }
}
