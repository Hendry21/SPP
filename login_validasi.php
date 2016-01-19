<?php
include_once "config/inc.connection.php";
include_once "config/inc.library.php";
session_start();

//tangkap data dari form login
$username =  $_POST['username'];
$password = $_POST['password'];

//untuk mencegah sql injection
//kita gunakan mysql_real_escape_string
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

//cek data yang dikirim, apakah kosong atau tidak
if (empty($username) && empty($password)) {
	//kalau username dan password kosong
	header('location:index.php?error=1');
	break;
} else if (empty($username)) {
	//kalau username saja yang kosong
	header('location:index.php?error=2');
	break;
} else if (empty($password)) {
	//kalau password saja yang kosong
	header('location:index.php?error=3');
	break;
}
# LOGIN CEK KE TABEL USER LOGIN
$mySql = "SELECT * FROM admin WHERE username='$username' AND password='".md5($password)."'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Query Salah : ".mysql_error());
		$myData= mysql_fetch_array($myQry);
		
		# JIKA LOGIN SUKSES
		if(mysql_num_rows($myQry) >= 1) {
			// Menyimpan Kode yang Login
			$_SESSION['SES_LOGIN'] = $myData['kd_petugas']; 
			$_SESSION['NAMA_LOGIN'] = $myData['nm_petugas']; 
			$_SESSION['photo'] = $myData['photo']; 
			
			 header("Location:admin/index.php");
} else {
	//kalau username ataupun password tidak terdaftar di database
	header('location:index.php?error=4');
}
?>