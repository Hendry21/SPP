<?php
error_reporting(0);
include "../config/inc.connection.php";

$no_induk = $_POST['no_induk'];
$nisn = $_POST['nisn'];
$nama_siswa = $_POST['nama_siswa'];
$tmpt_lahir = $_POST['tmpt_lahir'];
$tgl_lahir = $_POST['tgl_lahir'];
$jk = $_POST['jk'];
$alamat = $_POST['alamat'];
$kelas = $_POST['kelas'];
$nm_jurusan = $_POST['nm_jurusan'];
$prog_keahlian = $_POST['prog_keahlian'];
$agama = $_POST['agama'];
$no_hp = $_POST['no_hp'];
$nm_wali = $_POST['nm_wali'];
$nm_bpk = $_POST['nm_bpk'];
$nm_ibu = $_POST['nm_ibu'];
$no_hp_bpk = $_POST['no_hp_bpk'];
$no_hp_ibu = $_POST['no_hp_ibu'];
$thn_ajaran = $_POST['thn_ajaran'];
if (empty($no_induk))

{	
	?><script language="javascript">alert("no_induk !");location.href="javascript:history.back()";</script><?php 
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
			mysql_query("UPDATE siswa WHERE no_induk='$no_induk' LIMIT 1");
		} 
		else { ?><script language="javascript">alert("Jenis gambar yang anda kirim salah. Harus .jpg .gif .png, image sementara akan di kosongkan");location.href="page.php?page=data_pegawai";</script><?php }
	}
	$masukan=mysql_query("UPDATE siswa SET nisn='$nisn',nama_siswa='$nama_siswa',tmpt_lahir='$tmpt_lahir',tgl_lahir='$tgl_lahir',jk='$jk',alamat='$alamat',kelas='$kelas',nm_jurusan='$nm_jurusan',prog_keahlian='$prog_keahlian',agama='$agama',no_hp='$no_hp',nm_wali='$nm_wali',thn_ajaran='$thn_ajaran' WHERE no_induk='$no_induk'");
	if($masukan){
		?><script language="javascript">alert("Data berhasil di ubah !"); location.href="index.php?page=data_siswa12";</script><?php
		}else
		{
		?><script language="javascript">alert("GAGAL di Ubah !"); location.href="javascript:history.back()";</script><?php
		}

   
	exit;
}		
?>