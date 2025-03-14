<?php
session_start();

include_once 'lib.php';
 
if(!isset($_SESSION[$C_APP.'fileType'])){
    $fileNameNoHouZhuis = getFileNameNoHouZhuisMusicApp();     
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
    width: 600px;
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

    
</style>

</head> 
  
<body>


<div class="container" id="container" onclick="javascript: if(doms.audio.paused){doms.audio.play();}else{doms.audio.pause()}; return false;">
    <ul class="lrcList" id="lrcList">

    </ul>
</div>

<audio name="myPlayer" id="myPlayer" class="myPlayer"  controls="controls" autoplay="autoplay"></audio>

<img src='bg.jpeg' class='back-img'/>




<script>
//http://win/music/play.html?m=%E5%88%98%E8%8B%A5%E8%8B%B1-%E5%90%8E%E6%9D%A5



var doms;


var LRCData;
var lrc;
var conH;
var liH;



/**
* 根据变量名获取匹配值
*/
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURIComponent(r[2]);
    return "";
};


function getXmlHttpRequest(){
    var xmlHttpRequest = null;
    if(window.ActiveXObject){
        xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    } else if(window.XMLHttpRequest){
        xmlHttpRequest = new XMLHttpRequest();
    }
    return xmlHttpRequest;
}

 

//输出歌词信息   webURL 是 歌词存放的路径 或者歌词下载的路径 
function ajaxGetHTML(webURL) { 
    var url = webURL;  
    //console.log(url);
 
    var xmlhttp = getXmlHttpRequest(); 

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
			//alert(s);


          
			
			lrc = s;
			
			LRCData = parseLRC(lrc);
			createLrcList(LRCData);  // 创造歌词 li
			 
			conH = doms.container.clientHeight;  // 容器高度
			
			liH = doms.lrcList.children[0].clientHeight;  // li 高度
			
			// 初始化歌词位置，让第一句歌词在歌词区中间
			doms.lrcList.style.transform = "translateY(" + (-1*( liH/2  - conH/2)) + "px)";  

			
			doms.audio.addEventListener("timeupdate",function(){
			    var index = findIndex();
			    setLight(index);  // 歌词位移
			    setOffset(index); // 歌词高亮
			});
			
			doms.audio.src="mp3/"+getQueryString('m')+".mp3";

			
			doms.audio.controls = true;

			doms.audio.play();  // 播放
	
			 
        }  
        
    }  
    //alert(url);
    
    xmlhttp.open("GET", url, true);
    
    xmlhttp.send(null);  
}  

 

//把歌词字符串处理为 Object 对象

//   解析歌词字符串，的到歌词对象数组
//  每个歌词对象：
//  {
//time:开始时间,
//word:歌词
//  }

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

window.onload = function () {

	ajaxGetHTML("mp3/"+getQueryString('m')+".txt");

}



var timeStep = 10; //单位秒，每次增减5秒
var timeStepMouse = timeStep;
var timeStepKey = timeStep;

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
		//downKeyup();
		rightMouseup();
		return false;
	}else if(event.keyCode === 38){
		// 按 向上
		//upKeyup();
		leftMouseup();
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
	    }else if(e.keyCode === 40){
	 	    // 按 向下
	        rightMousedown();
	     	return false;
		}else if(e.keyCode === 38){
		   //向上
			leftMousedown();
		    return false;
	    }　　　　
	    　　
	}
}
	

</script>

</body>
</html>

    
    
