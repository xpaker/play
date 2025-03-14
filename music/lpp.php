<?php
session_start();

include_once 'lplib.php';
$C_APP="lp";

if( !isset($_SESSION[$C_APP.'playTimeNum']) ){
    $_SESSION[$C_APP.'playTimeNum'] = $_GET['n'];
}
if ( $_SESSION[$C_APP.'playTimeNum'] != $_GET['n'] ){
    $_SESSION[$C_APP.'playTimeNum'] = $_GET['n'];
}

if( is_numeric( $_SESSION[$C_APP.'playTimeNum'] ) ){
    $playTimeNum = number_format( $_SESSION[$C_APP.'playTimeNum'] );
}else{
    $playTimeNum = 1;
}

if($playTimeNum<1){    
    $playTimeNum = 1;
}else if($playTimeNum >10){
    $playTimeNum = 10;
}




?>



<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta content="always" name="referrer">
<meta name="theme-color" content="#ffffff">
<meta name="description" content="">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>Music Play</title>
<style>
    
*{
    margin: 0;
    padding: 0;
}

html {
      height: 100%;
    }
 
    body {
      margin: 0;
      height: 90%;
     overflow: auto;
    }

    
 
ul,li,ol{
    list-style: none;
}
 
.myPlayer{
    display: block;
    width: 50%;
    margin-top: 50px;
    margin-left: auto;
    margin-right: auto;
    opacity: 0.5;
    transition:all 0.2s;
}
.myPlayer:hover{
    opacity: 1;
}

.back-img{

    z-index:-1;

    position:fixed;

    width:100%;

    height:100%;

    left:0;

    top:0;

}

 
.container{
    width: 100%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 30px; 
    height: 60%;
    overflow: hidden;
    position: relative;
	margin:0;
	height: 90%;
}
 
 
.lrcList{
    font-size: 32px;
    line-height: 60px;
    color: #222222;
    text-align: center;
    transition:all 0.2s;  /* 过渡动画。实现歌词上下移动的动画 */
}
.lrcList li{
    transition:all 0.2s;
    height: 60px;
    opacity: 0.5;
}
.lrcList .current{
    transform: scale(1.4);
    color: #3f3f3f;
    opacity: 1;
}









        .control-wrapper {
        	
    
        	
           
            width: 50vw;
            height: 50vw;
            max-width: 300px;
            max-height: 300px;
            min-width: 240px;
            min-height: 240px;
            margin: 0 auto;
            border-radius: 50%;
        	
        	position: absolute;
            bottom: 0px;
            right: 0px;
        }
        .control-btn {
            position: absolute;
            width: 38%;
            height: 38%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #78aee4;
            box-sizing: border-box;
            transition: all .3s linear;
        }
        .control-btn:after {
            content: '';
            position: absolute;
            width: 60%;
            height: 60%;
            background: #fff;
            z-index: 2;
        }
        .control-btn:before {
            content: '';
            position: relative;
            display: block;
            width: 16px;
            height: 16px;
            border-top: 3px solid #78aee4;
            border-right: 3px solid #78aee4;
            border-radius: 0 4px 0 0;
            box-sizing: border-box;
            z-index: 2;
        }
        .control-top {
            top: 0;
            left: 50%;
            transform: translateX(-50%) rotate(-45deg);
            border-radius: 4px 100% 4px 4px;
        }
        .control-top:before {
            transform: translate(30%, -25%);
        }
        .control-top:after {
            left: 0;
            bottom: 0;
            border-top: 1px solid #78aee4;
            border-right: 1px solid #78aee4;
            border-radius: 0 100% 0 0;
        }
        .control-bottom {
            left: 50%;
            bottom: 0;
            transform: translateX(-50%) rotate(45deg);
            border-radius: 4px 4px 100% 4px;
        }
        .control-bottom:before {
            transform: translate(25%, 25%) rotate(90deg);
        }
        .control-bottom:after {
            top: 0;
            left: 0;
            border-bottom: 1px solid #78aee4;
            border-right: 1px solid #78aee4;
            border-radius: 0 0 100% 0;
        }
        .control-left {
            top: 50%;
            left: 0;
            transform: translateY(-50%) rotate(45deg);
            border-radius: 4px 4px 4px 100%;
        }
        .control-left:before {
            transform: translate(-25%, 30%) rotate(180deg);
        }
        .control-left:after{
            right: 0;
            top: 0;
            border-bottom: 1px solid #78aee4;
            border-left: 1px solid #78aee4;
            border-radius: 0 0 0 100%;
        }
        .control-right {
            top: 50%;
            right: 0;
            transform: translateY(-50%) rotate(45deg);
            border-radius: 4px 100% 4px 4px;
        }
        .control-right:before {
            transform: translate(30%, -25%);
        }
        .control-right:after {
            left: 0;
            bottom: 0;
            border-top: 1px solid #78aee4;
            border-right: 1px solid #78aee4;
            border-radius: 0 100% 0 0;
        }
        .control-round {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 51.2%;
            height: 51.2%;
            background: #fff;
            border-radius: 50%;
        }
        .control-round-inner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: center;
            width: 66%;
            height: 66%;
            border: 1px solid #78aee4;
            border-radius: 50%;
        }
        .control-round-inner:after {
            content: "| |";
            display: block;
            width: 50px;
            line-height: 50px;
            text-align: center;
            background: #78aee4;
            font-weight: bolder;
            color: #fff;
            border-radius: 50%;
        }
        
#title {
	   position: absolute;
       left: 40px;
       top: 20px;
}

#title h1{
	font-size:20px;
	padding:10px 30px;
	margin: 10px;
	
   } 
    
</style>
</head> 
  
<body>
<div id="title">
<h1><?php if(isset($_SESSION[$C_APP.'curMusic'])){ echo str_replace_zy_f_func($_SESSION[$C_APP.'curMusic']); }?></h1>
</div>
<div class="container" id="container" onclick="javascript: if(doms.audio.paused){doms.audio.play();}else{doms.audio.pause()}; return false;">
    <ul class="lrcList" id="lrcList">

    </ul>
</div>



<div>
    <div>
    
    <audio name="myPlayer" id="myPlayer" class="myPlayer"  controls="controls" autoplay="autoplay"></audio>
    
    </div>
    <div class="control-wrapper">
        <div class="control-btn control-top" onclick="javascript: upKeyup();return false;"></div>
        <div class="control-btn control-left" id="left" onclick="javascript: return false;leftKeyup();"> </div>
        <div class="control-btn control-bottom" onclick="javascript: downKeyup();return false;"></div>
        <div class="control-btn control-right" id="right" onclick="javascript: return false;rightKeyup();"></div>
        <div class="control-round">
            <div class="control-round-inner"  onclick="javascript: playAndPauseKeyup();return false;"></div>
        </div>
    </div>
</div>


<img src='bg.jpeg' class='back-img'/>
    
<script>


var start = 0;//定义循环的变量
var times = <?php echo $playTimeNum;?>;//定于循环的次数
var isGetNext = false;


let LRCData;
let lrc;
let conH;
let liH;


/**
* 根据变量名获取匹配值
*/
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURIComponent(r[2]);
    return "";
};



var HtmlUtil = {
        /*1.用浏览器内部转换器实现html编码（转义）*/
        htmlEncode:function (html){
            //1.首先动态创建一个容器标签元素，如DIV
            var temp = document.createElement ("div");
            //2.然后将要转换的字符串设置为这个元素的innerText或者textContent
            (temp.textContent != undefined ) ? (temp.textContent = html) : (temp.innerText = html);
            //3.最后返回这个元素的innerHTML，即得到经过HTML编码转换的字符串了
            var output = temp.innerHTML;
            temp = null;
            return output;
        },
        /*2.用浏览器内部转换器实现html解码（反转义）*/
        htmlDecode:function (text){
            //1.首先动态创建一个容器标签元素，如DIV
            var temp = document.createElement("div");
            //2.然后将要转换的字符串设置为这个元素的innerHTML(ie，火狐，google都支持)
            temp.innerHTML = text;
            //3.最后返回这个元素的innerText或者textContent，即得到经过HTML解码的字符串了。
            var output = temp.innerText || temp.textContent;
            temp = null;
            return output;
        },
        /*3.用正则表达式实现html编码（转义）*/
        htmlEncodeByRegExp:function (str){  
             var temp = "";
             if(str.length == 0) return "";
             temp = str.replace(/&/g,"&amp;");
             temp = temp.replace(/</g,"&lt;");
             temp = temp.replace(/>/g,"&gt;");
             temp = temp.replace(/\s/g,"&nbsp;");
             temp = temp.replace(/\'/g,"&#39;");
             temp = temp.replace(/\"/g,"&quot;");
             return temp;
        },
        /*4.用正则表达式实现html解码（反转义）*/
        htmlDecodeByRegExp:function (str){  
             var temp = "";
             if(str.length == 0) return "";
             temp = str.replace(/&amp;/g,"&");
             temp = temp.replace(/&lt;/g,"<");
             temp = temp.replace(/&gt;/g,">");
             temp = temp.replace(/&nbsp;/g," ");
             temp = temp.replace(/&#39;/g,"\'");
             temp = temp.replace(/&quot;/g,"\"");
             return temp;  
        },
        /*5.用正则表达式实现html编码（转义）（另一种写法）*/
        html2Escape:function(sHtml) {
             return sHtml.replace(/[<>&"]/g,function(c){return {'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c];});
        },
        /*6.用正则表达式实现html解码（反转义）（另一种写法）*/
        escape2Html:function (str) {
             var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"'};
             return str.replace(/&(lt|gt|nbsp|amp|quot);/ig,function(all,t){return arrEntities[t];});
        }
    };


 
function getZYZHString(r2){
    r2=r2.replace("zzzz1zzzz", "&");
    r2=r2.replace("zzzz2zzzz", "'");
    r2=r2.replace("zzzz3zzzz", "/");
    r2=r2.replace("zzzz4zzzz", "\\");
    //r2 = HtmlUtil.htmlDecodeByRegExp(r2);
    return r2;
}

function getZYString(r2){
    r2=r2.replace("&", "zzzz1zzzz");
    r2=r2.replace("'", "zzzz2zzzz");
    r2=r2.replace("/", "zzzz3zzzz");
    r2=r2.replace("\\", "zzzz4zzzz");
    //r2 = HtmlUtil.htmlEncodeByRegExp(r2); 
    return r2;
}

function getXmlHttpRequest(){
    var xmlHttpRequest = null;
    if(window.ActiveXObject){
        xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    } else if(window.XMLHttpRequest){
        xmlHttpRequest = new XMLHttpRequest();
    }
    return xmlHttpRequest;
}


/* 输出歌词信息   webURL 是 歌词存放的路径 或者歌词下载的路径   */
function ajaxGetHTML(playMusicName) { 
	var mp3Dir="mp3\\";
    var musicUrl = mp3Dir + getZYZHString(playMusicName) +".mp3" ;
    var lrcUrl = mp3Dir + getZYZHString(playMusicName) +".<?php echo $_SESSION[$C_APP.'fileType'];?>" ;
    console.log("getHtml musicUrl="+musicUrl);
    console.log("getHtml lrcUrl="+lrcUrl);

    var titleString = HtmlUtil.htmlEncode( getZYZHString( playMusicName ) );

    document.getElementById("title").innerHTML = titleString;
    
    var xmlhttp = getXmlHttpRequest(); 
     
    xmlhttp.onreadystatechange = function() {  
       
        if (xmlhttp.readyState == 4) {  
            
            isGetNext = false;
			start = 0;
            
            var s = xmlhttp.responseText;
			// 去除文件中已 <开头  >结尾的所有文本内容 
			s =s.replace(/<.*?>/g,"");  
            s = s.replace(/</g, "<");  
            s = s.replace(/>/g, ">"); 
			s = s.replace(/;/g, "<br>");
		 	//s = s.replace(/<\/?.+?>/g,"<br/>");  
			//s = s.replace(/[\r\n]/g, "<br/>"); 
			//alert(s);
			
			lrc = s;
			
			LRCData = parseLRC(lrc);
			createLrcList(LRCData);  // 创造歌词 li
			conH = doms.container.clientHeight;  // 容器高度
			liH = doms.lrcList.children[0].clientHeight;  // li 高度
			// 初始化歌词位置，让第一句歌词在歌词区中间
			doms.lrcList.style.transform = "translateY(" + (-1*( liH/2  - conH/2)) + "px)";  
			
			doms.audio.addEventListener("timeupdate",function(){
			    let index = findIndex();
			    setLight(index);  // 歌词位移
			    setOffset(index); // 歌词高亮
			});
			
			doms.audio.src= musicUrl;
	
			doms.audio.controls = true;
			
			doms.audio.play();  // 播放

        }  
    }  

    
    xmlhttp.open("GET", lrcUrl, true);
    
    xmlhttp.send(null);  
}  




//把歌词字符串处理为 Object 对象

//解析歌词字符串，的到歌词对象数组
//每个歌词对象：
//{
//time:开始时间,
//word:歌词
//}

function parseLRC(LRC){
	
var lines = LRC.split('\n'); // 把歌词转为数组
var LRCArr = [];  // 歌词数组
//遍历数组


for (var i = 0; i < lines.length; i++){  
	
    var item =  lines[i]; 
    
    if(item != ''){

	        //try{
				let parts = item.split("]"); //  [00:06.77 , 安静地又说分开
		        let timer =  parts[0].slice(1).trim();  // 00:06.77
		       
		        //let obj = {
		        //    time: parseTime(timer),
		        //    word: parts[1].trim()==""?"":parts[1]  // 安静地又说分开
		        //}
		        
    		var word="";
            var temp="";
            
            if(parts[1]!=null){
                 temp=parts[1];
            }
            if(temp.trim()!="?") {
           		   word=temp.trim();
            }
    		//console.log(word);
             let obj = {
                time: parseTime(timer),
                word:word  // 安静地又说分开
            }
				
		        //console.info( obj );
		        LRCArr.push(obj);  
		        
	        //}catch{
	        	
	        //}

	}
    
    
}  

return LRCArr;
}



//把时间字符串转为时间数字
//eg:
//01:06.77  => 66.77
function parseTime(timer){
    var t = timer.split(":");
    var result = Number(t[0])*60 + Number(t[1]);
    return result ; 
}




//计算出，再当前播放器播放到第几秒的情况
//LRCData 应该高亮显示的歌词下标。
//高亮歌词是: 比当前时间数【第一次大】的上一句。
//如果没有任何歌词显示，就为 -1 。
//返回值：当前歌词对应的索引
function findIndex(){
//播放器当前时间
var index = -1;
var curTime = doms.audio.currentTime;
for(var i=0; i<=LRCData.length-1 ; i++){
    if( curTime < LRCData[i].time ){
        index = i - 1;
        return  index;
    }
    }
//找遍了，都没有歌词，说明播放完毕里，显示最后一句歌词。
index = LRCData.length-1
return index;
}

//界面部分
//生成歌词 li
function createLrcList(lrc){
//避免多次操作 DOM。创建一个 DOM 片段，它不会显示，但是可以集中处理 DOM。
var frag = document.createDocumentFragment();
doms.lrcList.innerHTML = "";

for (var i = 0; i < lrc.length; i++){  

    var item =  lrc[i]; 
    //console.log(item);
    var li = document.createElement("li");
    li.innerHTML = item.word;
    frag.appendChild(li);
}

doms.lrcList.appendChild(frag);
}



//设置歌词 ul 的偏移量
function setOffset(index){
var dis =-1*( index * liH + liH/2  - conH/2 );  // 位移距离
doms.lrcList.style.transform ="translateY("+dis+"px)";
//console.info( dis );
}


//设置歌词高亮
function setLight(i){
var ul = doms.lrcList;
var lis = ul.children;
var cur = document.querySelector(".current");
if( cur ){ // 如果存在
    cur.classList.remove("current");
	//cur.className = '';
}
//console.log("i="+i+" "+lis[i].classList)
lis[i].classList.add("current");
//lis[i].className = 'current';
}



doms = {
	 audio:document.querySelector("audio"),
	 lrcList:document.querySelector("#lrcList"),
	 container:document.querySelector("#container")
}


/* 得到下一首歌曲的名称   */
function ajaxGetNext(url) {
	start = 0;

    if(isGetNext){
        return false;
    }
    
    var xmlhttp;  
    try {  
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");  
    } catch(e) {  
        try {  
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");  
        } catch(e) {}  
    }  
    if (!xmlhttp) xmlhttp = new XMLHttpRequest();  
    xmlhttp.onreadystatechange = function() {  
        if (xmlhttp.readyState == 4) {  
            var s = xmlhttp.responseText;
			// 去除文件中已 <开头  >结尾的所有文本内容 
			s =s.replace(/<.*?>/g,"");  
            s = s.replace(/</g, "<");  
            s = s.replace(/>/g, ">"); 
			s = s.replace(/;/g, "<br>");
		 	//s = s.replace(/<\/?.+?>/g,"<br/>");  
			//s = s.replace(/[\r\n]/g, "<br/>"); 

			ajaxGetHTML(  getZYZHString(s) )

			isGetNext = false;
        }  
    }  
    
    xmlhttp.open("GET", url, true);
    
    xmlhttp.send(null);  
	isGetNext = true;
}  




function Orderprocessing(){
	//alert('order');
 	var vid = doms.audio;//获取音频对象
	vid.addEventListener("ended",function() {
	       start++; //循环
	       console.log("start="+start+" times="+times);
	       if(isGetNext != false){
		         return false;
		   }
		   //也就是当循环的变量等于次数的时候，就会终止循环并且关掉音频
		   if(start >= times){
			   ajaxGetNext("lpn.php?m="+getQueryString('m'));
		   }else{
		      doms.audio.play();// 播放
		   }
	});
	//vid.play();//启动音频，用于第一次启动
}


doms = {
    audio:document.querySelector("audio"),
    lrcList:document.querySelector("#lrcList"),
    container:document.querySelector("#container")
}

window.onload = function () {
    Orderprocessing();
     
	//setInterval("Orderprocessing()",5000);//每隔1分钟自动调用一次启动音频的方法

	ajaxGetHTML( getZYZHString(getQueryString('m') ));

}

var timeStep = 5; //单位秒，每次增减5秒
var timeStepMouse = timeStep/5;
var timeStepKey = timeStep/10;

var isKeyDown = false;
var timeid = null;

function playAndPauseKeyup(){
	console.log("playAndPauseKeyup");
	if(doms.audio.paused){doms.audio.play();}else{doms.audio.pause()};
}


function rightKeyup(){
	console.log("rightKeyup");
	if(timeid!=null){
		window.clearTimeout(timeid);
		timeid=null;
		isKeyDown = false
	    return false;
	}
	doms.audio.currentTime !== doms.audio.duration ? doms.audio.currentTime += timeStep : 1;
}


function leftKeyup(){
	console.log("leftKeyup");
	if(timeid!=null){
		window.clearTimeout(timeid);
		timeid=null;
		isKeyDown = false
	    return false;
	}
	isKeyDown = false;
	doms.audio.currentTime !== 0 ? doms.audio.currentTime -= timeStep : 1;
}

function upKeyup(){
	console.log("upKeyup");
	ajaxGetNext("lpn.php?m="+getQueryString('m')+"&p=1");;
}

function downKeyup(){
	console.log("downKeyup");
	ajaxGetNext("lpn.php?m="+getQueryString('m'));
}




function leftCFSBKey(){
	console.log("leftCFSBKey");
	doms.audio.currentTime !== 0 ? doms.audio.currentTime -=  timeStepKey : 1;
}

function rightCFSBKey(){
	console.log("rightCFSBKey");
	doms.audio.currentTime !== doms.audio.duration ? doms.audio.currentTime += timeStepKey : 1;
}

function leftCFSBMouse(){
	console.log("leftCFSBMouse");
	doms.audio.currentTime !== 0 ? doms.audio.currentTime -=  timeStepMouse : 1;
}

function rightCFSBMouse(){
	console.log("rightCFSBMouse");
	doms.audio.currentTime !== doms.audio.duration ? doms.audio.currentTime += timeStepMouse : 1;
}

function leftKeydown(){
	console.log("leftKeydown");
	leftCFSBKey();
	isKeyDown = true;
}


function rightKeydown(){
	console.log("rightKeydown");
	rightCFSBKey();
	isKeyDown = true;
}



function leftMousedown(){
	console.log("leftMousedown");
	if(timeid!=null){
		window.clearTimeout(timeid);
	}
	timeid = window.setInterval("leftCFSBMouse()",100);
	isKeyDown = true;
}

function rightMousedown(){
	console.log("rightMousedown");
	if(timeid!=null){
		window.clearTimeout(timeid);
	}
	timeid = window.setInterval("rightCFSBMouse()",100);
	isKeyDown = true;
}

function leftMouseup(){
	console.log("leftMouseup");
	if(timeid!=null){
		window.clearTimeout(timeid);
		timeid=null;
	}
	isKeyDown = true;
}

function rightMouseup(){
	console.log("rightMouseup");
	if(timeid!=null){
		window.clearTimeout(timeid);
		timeid=null;
	}
	isKeyDown = true;
}

//键盘弹起
window.onkeyup=function(){
	//alert(1);
	console.log("onkeyup");
	var event = window.event;  


	if( event.keyCode == 32 || event.keyCode == 13) { // this is the spacebar
		playAndPauseKeyup();
		return false;
	}else if(event.keyCode === 37){
		// 按 向左键
		leftMouseup();
		//leftKeyup();
		return false;
	}else if(event.keyCode === 39){
		rightMouseup();
		//rightKeyup();
		return false;
	}else if(event.keyCode === 40){
		// 按 向下
		downKeyup();
		return false;
	}else if(event.keyCode === 38){
		// 按 向上
		upKeyup();
		return false;
	}
	
}

document.onkeydown=function(event){
    var e = event || window.event || arguments.callee.caller.arguments[0];
   
	if (timeid==null) {
	    if(e.keyCode === 37){
	 	    // 按 向左键
	        leftMousedown();
	     	return false;
		}else if(e.keyCode === 39){
			rightMousedown();
		    return false;
	    }
	}
	
} 
	
 


var div1 = document.getElementById('left');
div1.addEventListener('mousedown', function(event) {
	leftMousedown();
});
div1.addEventListener('mouseup', function(event) {
	leftMouseup();
});

var div2 = document.getElementById('right');
div2.addEventListener('mousedown', function(event) {
	rightMousedown();
});
div2.addEventListener('mouseup', function(event) {
	rightMouseup();
});



</script>





</body>
</html>
