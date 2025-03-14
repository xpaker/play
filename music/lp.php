<?php
$C_APP="lp";

session_start();

include_once 'lplib.php';



$fileNameNoHouZhuis = [];

if( !isset($_SESSION[$C_APP.'fileType']) ){
    $fileNameNoHouZhuis = getFileNameNoHouZhuis();
}else{
    $fileNameNoHouZhuis=$_SESSION[$C_APP.'fileNameNoHouZhuis'];
}

if(!isset( $_SESSION[$C_APP.'playTimeNum'] )){
    $playTimeNum = 1;
    $_SESSION[$C_APP.'playTimeNum'] = ''.$playTimeNum;
}else{
    $playTimeNum =is_numeric( $_SESSION[$C_APP.'playTimeNum'] );    
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

$curMan='';
$manMusics = [];
$musics = [];

for($i=0;$i<count($fileNameNoHouZhuis);$i++){
    $manMusic=explode('-',$fileNameNoHouZhuis[$i]);
    if(count($manMusic)<2){
        continue;
    }
    
    $man = $manMusic[0];
    $music = $manMusic[1];

    if(!isset($man)){
        continue;
    }
    if(!array_key_exists($man, $manMusics) && !isset($manMusics[$man]) ){
        $musics = [];
        $musics[] = $music;
        $manMusics[$man] = $musics;
    }else{
        $musics = $manMusics[$man];
        $musics[] = $music;
        $manMusics[$man] = $musics;
    }
    
    
    
    

}
//var_dump($manMusics);
	      
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


    <title>Music Playlist</title>


    <style>


        body {

            font-family: Arial, sans-serif;

            margin: 20px;
			
        	paddin: 10px;

        }
        
        

        
        ul .list{
	       list-style: none;
        }
        
        ul li.listItme{
	        display: inline;
        }


 

.back-img{

    z-index:-1;

    position:fixed;

    width:100%;

    height:100%;

    left:0;

    top:0;

}



</style>


</head>


<body>
<img src='bg.jpeg' class='back-img'/>


<div> 

<div id="number">播放次数
    <button type="button" onclick="jian()">-</button>
    <input type="text" value="<?php echo $_SESSION[$C_APP.'playTimeNum'];?>" name="n" id="n" size="1" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')">
    <button type="button" onclick="jia()">+</button>
</div>


<?php	
foreach($manMusics as $man => $musics){

?>
  

    <ul class="list">

		<?php
		foreach($musics as $music){
		     
		?>
        <li class="listItem" onclick="javascript: play('<?php echo str_replace_zy_func($man)."-".str_replace_zy_func($music)?>');return false;">
            <?php echo $man; ?>-<?php echo $music; ?>
         </li>
		<?php  
		}
		?>


    </ul>

<?php  
}
?>








</div>









<script>

function play(s){
    var href='lpp.php?m='+s+'&n='+document.getElementById('n').value;
	console.log(href);
	location.href = href;
}


function jia() {
	//console.log(!Number.isNaN(n));
	var n = document.getElementById("n").value;
	var reg = /^\d{1,10}$/; //正规表达式对象
    if(reg.test(n) ){
       n = parseInt(n);
    }else{
       n = 10;
    }

    n++;

    if(n>10) n=10;

    document.getElementById("n").value = n;
}



function jian() {
	var n = document.getElementById("n").value;
	var reg = /^\d{1,10}$/; //正规表达式对象
    if(reg.test(n) ){
       n = parseInt(n);
    }else{
       n = 10;
    }
    
    n--;

    if(n<1) n=1;

    document.getElementById("n").value = n;
}



    function searchSongs() {


        var input, filter, table, tr, td, i, txtValue;


        input = document.getElementById("searchInput");


        filter = input.value.toUpperCase();


        table = document.querySelector("table");


        tr = table.getElementsByTagName("tr");


        for (i = 1; i < tr.length; i++) {


            tr[i].style.display = "none";


            td = tr[i].getElementsByTagName("td");


            for (var j = 0; j < td.length; j++) {


                if (td[j]) {


                    txtValue = td[j].textContent || td[j].innerText;


                    if (txtValue.toUpperCase().indexOf(filter) > -1) {


                        tr[i].style.display = "";


                        break;


                    }


                }


            }


        }


    }


</script>



</body>


</html>
