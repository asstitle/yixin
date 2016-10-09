/**
 * Created by Administrator on 2016/6/27.
 */

$(function(){
  /*首页激活*/
  $($('.m_nav li').get(0)).addClass('active');

  $($('.m_nav li a').get(0)).html("首&nbsp;&nbsp;&nbsp;&nbsp;页");

  /**
   * 主导航激活效果
   */
    var href=window.location.href;
    var $m_a = $('.main_nav ul li a');
    for(var i=1;i<$m_a.length;i++){
      if(href.indexOf($($m_a.get(i)).attr('href')) !=-1){
        $($m_a.get(i)).parent().addClass('active').siblings().removeClass('active');
        break;
      }
    }

  /**
   * 主导航悬停效果
   */
  
  /**
   * 移除后台程序产生的子菜单
   */

  var $s_nav=$('.main_nav ul li .s_nav');
  for(var i=0;i<$s_nav.length;i++){
    if(!$($s_nav.get(i)).children().get(0)){
       $($s_nav.get(i)).remove();
     }
  }

  $($('.main_nav .m_nav > li .s_nav').get(1)).addClass('p2')


  /**
   * 分页添加不同效果
   */
  if($(".page")){
    var $page_a=$(".page a");
    for(var i=0;i<$page_a.length;i++){
      if($($page_a.get(i)).html()=='首页' || $($page_a.get(i)).html()=='上一页' || $($page_a.get(i)).html()=='下一页' || $($page_a.get(i)).html()=='尾页'){
        $($page_a.get(i)).addClass('other');
      }
    }
  }

 /*
  if($('.main')){
    changeMainHeight()
  }
  function changeMainHeight() {
    var width = $(window).width();
    $('.main').css({height:width*.25+'px'});
    $('.main img').css({'max-width':'100',height:width*.25+'px'});
  }*/

});