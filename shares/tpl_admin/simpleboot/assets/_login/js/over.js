var over=Object();
over.dc=document;
over.ele=[];
var se=null;
over.eleA=over.dc.getElementById("layer");
over.eleAf=over.dc.getElementById("layerf");
over.a=0;
over.b=0;
over.eleAf.onmousemove=function(e){
     var e= e || window.event;
     var tar=e.target || e.srcElement;
     over.eleAchil=over.eleA.getElementsByTagName("span");
     //over.eleA.style.display="black"
     //clearTimeout(se);
    if(navigator.userAgent.toLocaleLowerCase().match("msie 7.0") && tar.tagName.toLocaleLowerCase() == 'img'){
     	over.eleA.style.display="block";
     	if(tar.parentNode.parentNode.tagName.toLocaleLowerCase() == "li" && !this.getAttribute("none")){
     		over.eleA.style.width=tar.clientWidth+"px";
            over.eleA.style.height=tar.clientHeight+"px";
            over.eleA.style.left=tar.parentNode.parentNode.parentNode.offsetLeft+tar.parentNode.parentNode.offsetLeft+tar.parentNode.offsetLeft+"px";
            over.eleA.style.top=tar.parentNode.parentNode.parentNode.offsetTop+tar.parentNode.parentNode.offsetTop+tar.parentNode.offsetTop+"px";
            over.eleA.style.backgroundColor="black";
            over.eleA.href=tar.parentNode.href;
            over.eleAchil[0].innerHTML=tar.getAttribute("textn");
            over.eleAchil[1].innerHTML=tar.getAttribute("textc");
         // alert(tar.parentNode.parentNode.parentNode.offsetTop+tar.parentNode.parentNode.offsetTop+tar.parentNode.offsetTop+";"+tar.offsetLeft+"LI")
     	}else{
     		over.eleA.style.width=tar.clientWidth+"px";
            over.eleA.style.height=tar.clientHeight+"px";
            over.eleA.style.left=tar.parentNode.offsetLeft+tar.parentNode.parentNode.offsetLeft+"px";
            over.eleA.style.top=tar.parentNode.offsetTop+tar.parentNode.parentNode.offsetTop+"px";
            over.eleA.style.backgroundColor="black";
            over.eleA.href=tar.parentNode.href;
            over.eleAchil[0].innerHTML=tar.getAttribute("textn");
            over.eleAchil[1].innerHTML=tar.getAttribute("textc");
           //alert(tar.parentNode.offsetTop+";"+tar.parentNode.href)
     	}
     }
     else if(tar.tagName.toLocaleLowerCase() == 'img'){
     	over.eleA.style.display="block";
     	over.eleA.style.width=tar.clientWidth+"px";
        over.eleA.style.height=tar.clientHeight+"px";
        over.eleA.style.left=tar.offsetLeft+"px";
        over.eleA.style.top=tar.offsetTop+"px";
        over.eleA.style.backgroundColor="black";
        over.eleA.href=tar.parentNode.href;
        over.eleAchil[0].innerHTML=tar.getAttribute("textn");
        over.eleAchil[1].innerHTML=tar.getAttribute("textc");
        
     };
     //alert(getComputedStyle(over.eleA,false)["display"]+";"+over.eleA.clientWidth)

};
over.eleA.onmouseover=function(){
    clearTimeout(se);
    //over.b=1;
   // alert(12)
};
/*over.eleA.onmouseout=function(){
    this.style.display="none";
    over.b=0;
};*/
over.eleAf.onmouseout=function(e){
    clearTimeout(se);
    var e= e || window.event;
    var tar=e.target || e.srcElement;
    se=setTimeout(function(){
       //if(tar.tagName.toLocaleLowerCase() == 'img' && over.b==0){
         over.eleA.style.display="none";
    //}; 
    },100);
    //alert(90)
};

