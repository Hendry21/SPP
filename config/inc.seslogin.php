<?php
if(empty($_SESSION['SES_LOGIN'])) {
	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br>
		  Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
	echo "</center>";
	
	// Refresh
	echo "<meta http-equiv='refresh' content='3; url=../index.php'>";
	exit;
}
?>