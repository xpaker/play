<?php
$C_APP="music";

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


function getFileNameNoHouZhuisMusicApp(){
    $path = realpath('./mp3/');
    $isHaveTxt = false;
    $C_APP="music";
    if(!isset($_SESSION[$C_APP.'fileNameNoHouZhuis'])){
        
        $files=getDir($path);
        
        $fileNameNoHouZhuis = [];
        
        foreach($files as $val){
            
            $filename=basename($val);
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
        $C_APP="music";
        $fileNameNoHouZhuis=$_SESSION[$C_APP.'fileNameNoHouZhuis'];
        
        
     }
     //echo "$_SESSION[fileType]=".$_SESSION[$C_APP.'fileType'];;
     return $fileNameNoHouZhuis;
}

 

?>