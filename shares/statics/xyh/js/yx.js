/**
 * Created by Administrator on 2016/8/30.
 */
$(function () {

    if($('main').size()){
        swiperAnimate();
    }

    if($('.sec-detail-nav').size()){
        $('.sec-detail-nav ul li a').click(function(e){
            e.preventDefault();
            var target = $(this).data('id');
            $(this).addClass('active').parent().siblings().children().removeClass('active');
            $("."+target).fadeIn().siblings().fadeOut();
        });
    }

    if($('.sec-form')){

        $('.radio label').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).find('input[type=radio]').prop({'checked':true});
            $(this).find('i').addClass('on');
            $(this).siblings().find('i').removeClass('on');
        });
        var $selectA = $('.select a');
        $selectA.click(function (e) {
            e.preventDefault();
            $(this).siblings('ul').stop().slideToggle(300,function () {
                $(this).children('li').click(function () {
                    var _this = $(this);
                    $selectA.html(_this.html()).siblings('input').val(_this.html());
                    setTimeout(function(){
                        _this.parent('ul').stop().fadeOut(300);
                    },500);
                })
            })
        })
    }
});
function swiperAnimate() {

    var mySwiper = '';

    var $swiperContainer =  $('main .swiper-container');

    var getImgWidth = function($obj) {
        var imgSrc = $obj.find("img")[0].getAttribute('src');
        var img = new  Image();
        img.src = imgSrc;
        img.onload=function () {
            var width = this.width;
            var height = this.height;
            $obj.css({height: height/width * $swiperContainer.width() });
        };
    };

    var createSwiper = function() {
        mySwiper = new Swiper('main  .swiper-container',{
            mode : 'horizontal',
            pagination: '.swiper-pagination',
            loop:true,
            grabCursor: true,
            paginationClickable: true,
            autoplayDisableOnInteraction: false,
            autoplay: 2000,
            speed:300
        });
    };

    if( $('main').size()){
        getImgWidth($swiperContainer);
        createSwiper();
    }
}