$(function(){
	var l = $(".nav").find("a").width(),
		cur = $(".nav").find("em"),
		cur_l,ind;

	$(".nav").find("a").each(function(i){                  
		if($(this).hasClass("cur")){
			cur_l = l*(i) + 27;                           
			ind = i;        							   
			cur.css({
				"margin-left": cur_l +"px",
				"display":"block"
			});
			return false;
		}else{
			cur_l = null;                                 
			cur.css("display","none");
		}
	})
	$(".nav").find("a").hover(function(){                  
		cur.stop(true);                                    
		$(".nav").find("a").stop(true);
		/*if($(this).index() == ind+1){
			return false;
		};*/
		var off_l = l * ($(this).index() - 1) + 27,
			_ts   = $(this);                               

		_ts.siblings("a").removeClass("cur");              

		cur.css("display","block");                        
		cur.animate({                                      
			"margin-left": off_l +"px"
		},200,function(){
			_ts.addClass("cur");                           
		});

	},function(){
		//判断
		$(this).removeClass("cur");

		var _ts   = $(this);
		if (cur_l) {                                       
			cur.animate({
				"margin-left": (cur_l) +"px"               
			},200,function(){
				$(".nav").find("a").eq(ind).addClass("cur");
				if(ind+1 != _ts.index()){
					_ts.removeClass("cur");
				}
			});                                        
		}else{
			cur.animate({
				"margin-left": "27px"
			},200,function(){
				cur.css("display","none");
				_ts.removeClass("cur");
			});      									   
		}	

	})



	var i   = 1,
		lth = $(".banner").find("img").length, 
		Xs  = function(){
            if(i >= lth){
              $(".banner").css("margin-left","0");
              i = 0;
            }
            $(".banner").animate({
              "margin-left": "-" + i +"00%"
            },900,function(){
              i++;
            });
            setTimeout(Xs,3000);
        }
    setTimeout(Xs,3000);
})
function  indexImage(DispWidteh, DispHeight,ImgD){
     var  image=new  Image();  
     image.src=ImgD.src;
     if(image.width>0  &&  image.height>0){  
		       flag=true;  
		       if(image.width/image.height>=  DispWidteh/DispHeight){  
		         if(image.width>DispWidteh){      
		         ImgD.height=DispHeight;  
		         ImgD.width=(image.width*DispHeight)/image.height;  
		         }else{  
		         ImgD.height=DispHeight;  
		         ImgD.width=(image.width*DispHeight)/image.height;  
		         }  
		         ImgD.alt=image.width+"×"+image.height;  
		         }  
		       else{  
		         if(image.height>DispHeight){      
		         ImgD.width=DispWidteh;  
		         ImgD.height=(image.height*DispWidteh)/image.width;            
		         }else{  
		         ImgD.width=DispWidteh;  
		         ImgD.height=(image.height*DispWidteh)/image.width;   
		         }  
		         ImgD.alt=image.width+"×"+image.height;  
         		   }  
       }
        var my_hei = ($(ImgD).height()-DispHeight)*0.5;
        var my_wi = ($(ImgD).width()-DispWidteh)*0.5;
      //  alert(my_hei);
       //alert(my_wi);
     $(ImgD).css({left:-my_wi,top:-my_hei,'position':'absolute'});
     $(ImgD).parents('.pr').css({'width':DispWidteh,'height':DispHeight,'position':'relative'});
    // index = Math.random()*1000+2;
    //$(ImgD).parents('.pr').css({'width':DispWidteh,'height':DispHeight,'position':'relative'});
  //$(ImgD).siblings('.cover').css({'position':'relative','left':-my_wi,'top':-my_hei,'z-index':index});
  //$(ImgD).parent('a').css({'position':'absolute','left':-my_wi,'top':-my_hei,'z-index':index});
       //$(ImgD).css({'position':'relative','left':-my_wi,'top':-my_hei,'z-index':index});
    }
/*    function AutoResizeImage(maxWidth,maxHeight,objImg){ 
var img = new Image(); 
img.src = objImg.src; 
var hRatio; 
var wRatio; 
var Ratio = 1; 
var w = img.width; 
var h = img.height; 
wRatio = maxWidth / w; 
alert(wRatio);
hRatio = maxHeight / h; 
alert(hRatio);
if (maxWidth ==0 && maxHeight==0){ 
Ratio = 1; 
}else if (maxWidth==0){// 
if (hRatio<1) Ratio = hRatio; 
}else if (maxHeight==0){ 
if (wRatio<1) Ratio = wRatio; 
}else if (wRatio<1 || hRatio<1){ 
Ratio = (wRatio<=hRatio?wRatio:hRatio); 
} 
if (Ratio<1){ 
ww = w * Ratio; 
hh = h * Ratio; 
} 
//objImg.height = maxHeight; 
//alert(objImg.height);
//objImg.width = ww; 
//alert(w);
} */