<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

include_once "../config/inc.connection.php";

    $no_induk		= mysql_real_escape_string($_POST['no_induk']);
	$nisn	= mysql_real_escape_string($_POST['nisn']);
	$nama_siswa	= mysql_real_escape_string($_POST['nama_siswa']);
	$tmpt_lahir		= mysql_real_escape_string($_POST['tmpt_lahir']);
	$dataTanggal	= mysql_real_escape_string($_POST['tgl_lahir']);
	$alamat		= mysql_real_escape_string($_POST['alamat']);
	$no_hp		= mysql_real_escape_string($_POST['no_hp']);
	$nm_wali		= mysql_real_escape_string($_POST['nm_wali']);
	$thn_ajaran		= mysql_real_escape_string($_POST['thn_ajaran']);
	$agama		= mysql_real_escape_string($_POST['agama']);
	$cmbKelas		= mysql_real_escape_string($_POST['kelas']);
	$cmbJurusan		= mysql_real_escape_string($_POST['jurusan']);
	$cmbKeahlian		= mysql_real_escape_string($_POST['prog_keahlian']);
	$jk		= mysql_real_escape_string($_POST['jk']);


error_reporting (E_ALL ^ E_NOTICE);
if (trim($no_induk)=="")

{	
	?><script language="javascript">alert("masukan No induk!");location.href="javascript:history.back()";</script><?php 
}else{
	$cekdata="select no_induk from siswa where no_induk='$no_induk'";
	$ada=mysql_query($cekdata) or die(mysql_error());
	if(mysql_num_rows($ada)>0)
	{ ?><script language="javascript">alert("No Induk Sudah Ada!");location.href="javascript:history.back()";</script><?php }
		mysql_query("INSERT INTO siswa (no_induk, nisn, nama_siswa, tmpt_lahir, tgl_lahir,  alamat, kelas,  jurusan, jk, no_hp, nm_wali, thn_ajaran, prog_keahlian, agama) 
						VALUES ('$no_induk',
								'$nisn',
								'$nama_siswa',
								'$tmpt_lahir',
								'$tgl_lahir',
								'$alamat',
								'$cmbKelas',
								'$cmbJurusan',
								'$jk',
								'$no_hp',
								'$nm_wali',
								'$thn_ajaran',
								'$cmbKeahlian',
								'$agama')");
		?><script language="javascript">alert("Data berhasil di tambahkan!"); location.href="index.php?page=data_siswa1";</script><?php
	}
?>		