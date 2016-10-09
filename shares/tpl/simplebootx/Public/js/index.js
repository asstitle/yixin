/**
 * Created by Administrator on 2016/6/21.
 */

$(function(){



  /**
   * 焦点图轮播特效
   */
  var $pages=$('.banner a');
  $($pages.get(0)).addClass('active');
  //var $lis =$('.button li');
  var flag=true;//用于判断状态
  window.setInterval(function(){
    if(flag){
      changePage();
    }
  },3000);

  /**
   * 正常轮播功能函数
   */
  function changePage() {
    //1.获取当前正在显示的图片，移除active，并隐藏
    //2.获取下一个图片，添加active,并显示
    var $curr = $pages.filter('.active');//获取当前显示元素
    //var $currChosen = $lis.filter('.chosen');//获取当前显示元素对应的li
    $curr.removeClass('active').stop().fadeOut('1000');//隐藏当前显示元素
    //$currChosen.removeClass('chosen');//移除当前显示元素对应li被选中状态
    var $next=$curr.next();//获取当前显示元素的下一个元素
    //var $nextChosen=$currChosen.next();//获取当前显示元素的下一个元素对应的li
    if($next.size() == 0){//判断下一个轮播元素是否存在
      $next = $pages.eq(0);
     // $nextChosen = $lis.eq(0);
    }
    $next.addClass('active').stop().fadeIn('1000');//显示下一个元素
   // $nextChosen.addClass('chosen');//显示下一个元素对应的li
  }

  /**
   * 往前翻页
   */
  $('.prev').click(function() {
    flag=false;
    var $curr = $pages.filter('.active');
    //var $currChosen = $lis.filter('.chosen');//获取当前显示元素对应的li
    $curr.removeClass('active').stop().fadeOut('1000');
    //$currChosen.removeClass('chosen');
    var $prev = $curr.prev();
    //var $prevChosen=$lis.eq($curr.prev().index());
    if($prev.size() == 0){
      $prev = $pages.eq($pages.length-1);
      //$prevChosen=$lis.eq($lis.length-1);
    }
    $prev.addClass('active').stop().fadeIn('1000');
    //$prevChosen.addClass('chosen');
  }).mouseleave(function() {
    flag=true;
  });

  /**
   * 往后翻页
   */
  $('.next').click(function() {
    flag=false;
    var $curr = $pages.filter('.active');
    //var $currChosen = $lis.filter('.chosen');//获取当前显示元素对应的li
    $curr.removeClass('active').stop().fadeOut('1000');
    //$currChosen.removeClass('chosen');
    var $next = $curr.next();
    //var $nextChosen = $lis.eq($curr.next().index());
    if($next.size() == 0){
      $next = $pages.eq(0);
      //$nextChosen = $lis.eq(0);
    }
    $next.addClass('active').stop().fadeIn('1000');
    //$nextChosen.addClass('chosen');
  }).mouseleave(function() {
    flag=true;
  });

  /**
   *  小图标悬停效果切图效果
   */
 /* $lis.hover(function(){
    flag=false;
    var $curr = $pages.filter('.active');
    var $currChosen = $lis.filter('.chosen');
    $curr.removeClass('active').fadeOut('1000');
    $currChosen.removeClass('chosen');
    $pages.eq($(this).index()).addClass('active').fadeIn('1000');
    $(this).addClass('chosen');
  },function(){
    flag=true;
  });*/

  /**
   * 六大系统tab切换
   */
  var $con_a= $('.con a');
  $($con_a.get(0)).addClass('active');
  $con_a.hover(function(){
    $(this).addClass("active").siblings().removeClass('active');
    for(var i=0;i<$con_a.length;i++){
      if($con_a.get(i) === this){
        var _class='.intro'+(i+1);
        // $(_class).fadeIn('fast').siblings().fadeOut('fast');
        $(".sec_sys "+_class).css({display:'block'}).siblings().css({display:'none'});
        break;
      }
    }
  });
  /**
   * 走进财富宝tab切换
   *
   */
  var $ent_ul_li= $('.sec_ent ul li');
  $('.sec_ent .intro1').css({display:'block'});
  $($ent_ul_li.get(0)).addClass('active');
  $ent_ul_li.hover(function(){
    console.log(this);
    $(this).addClass("active").siblings().removeClass('active');
    for(var i=0;i<$ent_ul_li.length;i++){
      if($ent_ul_li.get(i) === this){
        var _class='.intro'+(i+1);
        // $(_class).fadeIn('fast').siblings().fadeOut('fast');
        $(".sec_ent "+_class).css({display:'block'}).siblings().css({display:'none'});
        break;
      }
    }
  });
});