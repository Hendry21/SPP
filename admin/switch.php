<?php
if(isset($_GET['page'])){
	$page=$_GET['page'];	
	$file="$page.php";
	
	if (!file_exists($file)){
		include ("awal.php");
	}else{
		include ("$page.php");
	}
	
}else{
	include ("awal.php");
}

?>