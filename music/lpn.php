<?php
session_start();

include_once 'lplib.php';
$curMusic = '';

$C_APP="lp";
 

if(!isset($_SESSION[$C_APP.'curMusic'])){
    if(!isset($_GET['m'])){
        //echo "get m is null<br>";
        $curMusic = '';
    }else{
        $curMusic = $_GET['m'];
        
    }
}else{
    $curMusic = $_SESSION[$C_APP.'curMusic'];
}

//echo "curMusic=".$curMusic."<br>";

if($curMusic==''){
    $man = '';
    $music = '';
}else{
    $manMusic=explode('-',$curMusic);

    if(count($manMusic)==2){
        $man = $manMusic[0];
        $music = $manMusic[1];
    }else{
        $man = '';
        $music = '';
    }

}

$fileNameNoHouZhuis = getFileNameNoHouZhuis();



if(isset($_GET['p']) && $_GET['p']=='1'){
    $isPrevious = true;
}else{
    $isPrevious = false;
}
//echo "<br>isPrevious=".$isPrevious."<br>";

$next = getNext($fileNameNoHouZhuis, str_replace_zy_f_func($man), str_replace_zy_f_func($music), $isPrevious);

 
$_SESSION[$C_APP.'curMusic'] = str_replace_zy_func($next['man'])."-".str_replace_zy_func($next['music']);

//echo "<br>_SESSION[$C_APP.'curMusic']=".$_SESSION[$C_APP.'curMusic']."<br>";

echo str_replace_zy_func($_SESSION[$C_APP.'curMusic']);?>