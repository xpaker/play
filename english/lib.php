<?php
$C_APP="english";

function getAndLastDirAndBasename($pathFile){
    $filename = basename($pathFile);
    $dirname = dirname($pathFile);
    $dirs=explode("\\", $dirname);
    if(count($dirs)>1){
        $dirnamed = $dirs[count($dirs)-1];
        //echo $dirnamed."\\".$filename."<br>";
        return $dirnamed."\\".$filename;
    }else{
        $dirs=explode("/", $dirname);
        if(count($dirs)>1){
            $dirnames = $dirs[count($dirs)-1];
            //echo $dirnames."/".$filename."<br>";
            return $dirnames."/".$filename;
        }else{
            return "";
        }
        
    }
    return "";
    
}


$fileNameNoHouZhuis = getFileNameNoHouZhuis();

$fileNameNoHouZhuis = [];



function getFileNameNoHouZhuis(){
    //echo('遍历目录开始');
    $path = realpath('mp3/');
    //var_dump(getDir($path));
    //echo('遍历目录结束');

    $files=getDir($path);
    $fileNameNoHouZhuis=[];
    $C_APP="english";
    
    if(!isset($_SESSION[$C_APP.'fileNameNoHouZhuis'])){
        $fileNameNoHouZhuis = [];
        foreach($files as $val){
            $isHaveTxt = false;

            $filename=getAndLastDirAndBasename($val);

            if($isHaveTxt != true && strpos($filename,'.txt') != false ){
                $isHaveTxt= true;
            }
            if(strpos($filename,'.mp3') !== false ){
                $fileNameNoHouZhui = str_replace(".mp3","",$filename);
                $fileNameNoHouZhuis[] = $fileNameNoHouZhui;
            }
        }
        sort($fileNameNoHouZhuis);
        $_SESSION[$C_APP.'fileNameNoHouZhuis']=$fileNameNoHouZhuis;
        
        if($isHaveTxt){
            $_SESSION[$C_APP.'fileType']='txt';
        }else{
            $_SESSION[$C_APP.'fileType']='lrc';
        }
    }else{
        $fileNameNoHouZhuis=$_SESSION[$C_APP.'fileNameNoHouZhuis'];
    }
    return $fileNameNoHouZhuis;
}

//var_dump($fileNameNoHouZhuis);

function str_replace_zy_func($str){
    $str = str_replace("&","zzzz1zzzz",$str);
    $str = str_replace("'","zzzz2zzzz",$str);
    $str = str_replace("/","zzzz3zzzz",$str);
    $str = str_replace("\\","zzzz4zzzz",$str);
    //echo $str;
    //$str = convert_uuencode($str);
    //echo $str;
    return $str;
}

function str_replace_zy_f_func($str){
    $str = str_replace("zzzz1zzzz","&",$str);
    $str = str_replace("zzzz2zzzz","'",$str);
    $str = str_replace("zzzz3zzzz","/",$str);
    $str = str_replace("zzzz4zzzz","\\",$str);
    //echo $str;
    //$str = convert_uudecode($str);
    //echo $str;
    return $str;
}

function getNext($fileNameNoHouZhuisVar,$manVar,$musicVar,$isPrevious){

    
    if($manVar=='' || $musicVar == ''){

        $manMusic=explode('－',$fileNameNoHouZhuisVar[0]);
     
        if(count($manMusic)<2){
            
            $reVar = [];
            $reVar['man'] = '';
            $reVar['music'] = '';
            
            return $reVar;
        }
    
        $man = $manMusic[0];
        $music = $manMusic[1];
    
        $reVar = [];
        $reVar['man'] = $man;
        $reVar['music'] = $music;
    
        return $reVar;
    }

    if($isPrevious){

        if($manVar."－".$musicVar==$fileNameNoHouZhuisVar[0] ){

            $manMusic=explode('－',$fileNameNoHouZhuisVar[count($fileNameNoHouZhuisVar)-1]);
            if(count($manMusic)<2){
        
                $reVar = [];
                $reVar['man'] = '';
                $reVar['music'] = '';

                return $reVar;
            }
        
            $man = $manMusic[0];
            $music = $manMusic[1];
        
            $reVar = [];
            $reVar['man'] = $man;
            $reVar['music'] = $music;
        
            return $reVar;
        }
        
        
        for($i=0;$i<count($fileNameNoHouZhuisVar);$i++){

                $manMusic=explode('－',$fileNameNoHouZhuisVar[$i]);
                if(count($manMusic)<2){
                    continue;
                }
        
                $man = $manMusic[0];
                $music = $manMusic[1];
        
                if($man==str_replace_zy_f_func($manVar) && $music == str_replace_zy_f_func($musicVar)){
                    
                    
                    
                    $manMusic2=explode('－',$fileNameNoHouZhuisVar[$i-1]);
        
        
                    if(count($manMusic2)<2){
                        $reVar = [];
                        $reVar['man'] = '';
                        $reVar['music'] = '';
                        return $reVar;
                    }
        
                    $man2 = $manMusic2[0];
                    $music2 = $manMusic2[1];
        
                    if(!isset($man2)){
                        $reVar = [];
                    }
        
                    $reVar = [];
                    $reVar['man'] = $man2;
                    $reVar['music'] = $music2;
        
                    return $reVar;;
                }
        
            
        }
    }else{
        
        if($manVar."－".$musicVar==$fileNameNoHouZhuisVar[ count($fileNameNoHouZhuisVar)-1] ){
            $manMusic=explode('－',$fileNameNoHouZhuisVar[0]);
            if(count($manMusic)<2){
        
                $reVar = [];
                $reVar['man'] = '';
                $reVar['music'] = '';
        
                return $reVar;
            }
        
            $man = $manMusic[0];
            $music = $manMusic[1];
        
            $reVar = [];
            $reVar['man'] = $man;
            $reVar['music'] = $music;
        
            return $reVar;
        }
        
        
        for($i=0;$i<count($fileNameNoHouZhuisVar);$i++){

      
                $manMusic=explode('－',$fileNameNoHouZhuisVar[$i]);
                if(count($manMusic)<2){
                    continue;
                }
        
                $man = $manMusic[0];
                $music = $manMusic[1];
        
                if($man==str_replace_zy_f_func($manVar) && $music == str_replace_zy_f_func($musicVar)){
                    $manMusic2=explode('－',$fileNameNoHouZhuisVar[$i+1]);
        
        
                    if(count($manMusic2)<2){
                        $reVar = [];
                        $reVar['man'] = '';
                        $reVar['music'] = '';
                        return $reVar;
                    }
        
                    $man2 = $manMusic2[0];
                    $music2 = $manMusic2[1];
        
                    if(!isset($man2)){
                        $reVar = [];
                    }
        
                    $reVar = [];
                    $reVar['man'] = $man2;
                    $reVar['music'] = $music2;
        
                    return $reVar;;
                }
        
            
        }
    }
    


    $reVar = [];
    $reVar['man'] = '';
    $reVar['music'] = '';
    return $reVar;
}





/**
 * 使用scandir 遍历目录
 *
 * @param $path
 * @return array
 */
function getDir($path)
{
    //判断目录是否为空
    if(!file_exists($path)) {
        return [];
    }

    $files = scandir($path);
    $fileItem = [];
    $fileItem2 = [];
    foreach($files as $v) {
        $newPath = $path .DIRECTORY_SEPARATOR . $v;
        if(is_dir($newPath) && $v != '.' && $v != '..') {
            $fileItem = array_merge($fileItem, getDir($newPath));
        }else if(is_file($newPath)){
            $fileItem[] = $newPath;
        }

         

    }

    return $fileItem;
}





?>
