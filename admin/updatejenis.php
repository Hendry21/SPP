<?php
error_reporting(0);
include "../config/inc.connection.php";

$kode_jenis = $_POST['kode_jenis'];
$jns_bayar = $_POST['jns_bayar'];
$biaya = $_POST['biaya'];



if (empty($jns_bayar))

{	
	?><script language="javascript">alert("jns_bayar !");location.href="javascript:history.back()";</script><?php 
} 
else
{
	if (!empty($_FILES["photo"]["tmp_name"]))
	{
		$namafolder="../admin/photo/";
		$jenis_gambar=$_FILES['photo']['type'];
		if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/png" || $jenis_gambar=="image/bmp")
		{           
			$photo = $namafolder . basename($_FILES['photo']['name']);       
			if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo)) 
			{
			   die("Gambar gagal dikirim");
			}
			//Hapus photo yang lama jika ada
			$res = mysql_query();
			$d=mysql_fetch_object($res);
			if (strlen($d->photo)>3)
			{
				if (file_exists($d->photo)) unlink($d->photo);
			}					
			mysql_query("UPDATE calonpeserta WHERE Nip='$Nip' LIMIT 1");
		} 
		else { ?><script language="javascript">alert("Jenis gambar yang anda kirim salah. Harus .jpg .gif .png, image sementara akan di kosongkan");location.href="page.php?page=data_pegawai";</script><?php }
	}
	$masukan=mysql_query("UPDATE jns_bayar SET jns_bayar='$jns_bayar',biaya='$biaya' WHERE kode_jenis='$kode_jenis'");
	if($masukan){
		?><script language="javascript">alert("Data berhasil di ubah !"); location.href="index.php?page=jns_bayar";</script><?php
		}else
		{
		?><script language="javascript">alert("GAGAL di Ubah !"); location.href="javascript:history.back()";</script><?php
		}

   
	exit;
}		
?>