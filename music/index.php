<?php
$C_APP="music";
session_start();

include_once 'lib.php';

 

$fileNameNoHouZhuis = [];

if( !isset($_SESSION[$C_APP.'fileType']) ){
    $fileNameNoHouZhuis = getFileNameNoHouZhuisMusicApp();
}else{
    $fileNameNoHouZhuis=$_SESSION[$C_APP.'fileNameNoHouZhuis'];
}



 
function str_replace_zy_func($str){
    $str = str_replace("&","zzzz1zzzz",$str);
    $str = str_replace("'","zzzz2zzzz",$str);
    $str = str_replace("/","zzzz3zzzz",$str);
    $str = str_replace("\\","zzzz4zzzz",$str);
    return $str;
}

function str_replace_zy_f_func($str){
    $str = str_replace("zzzz1zzzz","&",$str);
    $str = str_replace("zzzz2zzzz","'",$str);
    $str = str_replace("zzzz3zzzz","/",$str);
    $str = str_replace("zzzz4zzzz","\\",$str);
    return $str;
}


 
 
$curMan='';
$manMusics = [];
$musics = [];

//var_dump($fileNameNoHouZhuis);

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
        
        
	 .list {
        padding:0px;
        margin: 0px;
           


        }

        .playlist {

            padding:0px;
            margin: 0px 0;


        }


        .playlist-item {
            margin: 0px;
        	padding:0px;
        }


 

.playlist-item p {


        margin: 0;
        padding:0px;

    }

h1{
	font-size:20px;
	padding:0px;
	margin: 0px 0px 0px 10px;
	
   } 

.back-img{

    z-index:-1;

    position:fixed;

    width:100%;

    height:100%;

    left:0;

    top:0;

}

.masonry {
    display: grid;
    grid-gap: 10px;
    grid-template-columns: repeat(5, 1fr);
    grid-auto-rows: minmax(50px, auto);
	margin:0px;
	padding:0px;
}


.column {
    display: flex;
    flex-flow: column wrap;
    width: 100%;

</style>


</head>


<body>
<img src='bg.jpeg' class='back-img'/>


<div class="masonry"> 
 
<?php	
//var_dump($manMusics);
foreach($manMusics as $man => $musics){
?>
  
<div class="list column">
<h1><?php echo $man; ?></h1>
<div class="playlist">
    <ul>

		<?php
		foreach($musics as $music){
		?>
        <li class="playlist-item" 
            onclick="javascript: location.href='play.php?m=<?php echo $man."-".$music; ?>'; return false;"><?php echo $music; ?></li>
		<?php  
		}
		?>


    </ul>
</div>
</div>


<?php  
}
?>







</div>









<script>


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