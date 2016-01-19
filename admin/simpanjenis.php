<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

include_once "../config/inc.connection.php";

    $kode_jenis		= mysql_real_escape_string($_POST['kode_jenis']);
	$jns_bayar	= mysql_real_escape_string($_POST['jns_bayar']);
	$biaya	= mysql_real_escape_string($_POST['biaya']);
	

error_reporting (E_ALL ^ E_NOTICE);
if (trim($jns_bayar)=="")

{	
	?><script language="javascript">alert("Masukan Jenis Pembayaran !");location.href="javascript:history.back()";</script><?php 
	}else

	if (trim($biaya)=="")

{	
	?><script language="javascript">alert("Masukan Biaya Jenis Pembayaran !");location.href="javascript:history.back()";</script><?php 

}else{
	$cekdata="select kode_jenis from jns_bayar where kode_jenis='$kode_jenis'";
	$ada=mysql_query($cekdata) or die(mysql_error());
	if(mysql_num_rows($ada)>0)
	{ ?><script language="javascript">alert("No Induk Sudah Ada!");location.href="javascript:history.back()";</script><?php }
		mysql_query("INSERT INTO jns_bayar (kode_jenis, jns_bayar, biaya) 
						VALUES ('$kode_jenis',
								'$jns_bayar',
								'$biaya')");
		?><script language="javascript">alert("Data berhasil di tambahkan!"); location.href="index.php?page=jns_bayar";</script><?php
	}
?>		