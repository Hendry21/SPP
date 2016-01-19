<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=simpansiswaxls.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php include_once "../config/inc.connection.php";
$data=mysql_query("SELECT *from siswa ");
$jumlah=mysql_num_rows($data);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
a:link{color:#000000;}
a:visited{color:#000000;}
a:hover{color:#000000;}
.style1 {color: #000000}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script language="javascript">
function check_all()
{
	var chk = document.getElementsByName('check_list[]');
	for (i = 0; i < chk.length; i++)
	chk[i].checked = true ;
}

function uncheck_all()
{
	var chk = document.getElementsByName('check_list[]');
	for (i = 0; i < chk.length; i++)
	chk[i].checked = false ;
}
</script>
<body>
<div style="width:800px; margin:auto;">
<div>
  <h2 align="center" style="color:#000000;">DATA SISWA</h2>
  <div style="padding-top:10px;"></div>
</div>
<form method="post" action="#">
<?php
// Jumlah Data/ halaman yang tampilkan
$jum_hal= 9000;

// 
error_reporting (E_ALL ^ E_NOTICE);
if($_REQUEST['hal']==0|| empty($_REQUEST['hal']))
{
	$mulai = 0;
	$halaman = 1;
}
else 
{
	$mulai = ($jum_hal * $_REQUEST['hal'])- $jum_hal ;
	$halaman = $_REQUEST['hal'];
}

?>
<?php
	
//Jumlah data yang di database
$jum_data = mysql_num_rows(mysql_query("SELECT * FROM siswa "));
$jum_page = ceil($jum_data / $jum_hal);

//Atur halaman berikutnya
$next = $halaman+1;
//Atur halaman sebelumnya
$back = $halaman-1;

//tampilkan tombol back / sebelumnya
if ($halaman>1)
{
	echo "<a href='index.php?page=data_siswa&hal=$back'>Back</a> ";
}

// Tampilkan data halaman 
echo " $halaman / $jum_page Halaman  ";

//tampilkan tombol next / berikutnya
if ($halaman<$jum_page)
{
	echo "<a href='index.php?page=data_siswa&hal=$next'>Next</a>";
}

?>
<div style="padding-top:10px; padding-bottom:5px;">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border:#8fb041 1px solid;">
    <tr>
      <td><table width="100%" cellspacing="1" cellpadding="3" ><tr   style="font-weight:bold; font-size:13px;color:#FFFFFF" align="center" ><td width="9%"><table width="100%" border="0" cellpadding="3" cellspacing="1" >
        <tr   style="font-weight:bold;   align="center" >
          <td width="8%"  "><span class="style1">NO</span></td>
          <td width="17%" height="30"  ><span class="style1">NO INDUK</span></td>
		   <td width="23%"  ><span class="style1">NISN</span></td>
          <td width="31%"  ><span class="style1">NAMA SISWA</span></td>
          <td width="21%"  ><span class="style1">JENIS KELAMIN</span></td>
          <td width="21%"  ><span class="style1">TEMPAT, TGL LAHIR</span></td>
          <td width="21%"   ><span class="style1">KELAS</span></td>
          <td width="23%"  ><span class="style1">ALAMAT</span></td>
		      <td width="23%"  ><span class="style1">NAMA AYAH</span></td>
			      <td width="23%"  ><span class="style1">NAMA IBU</span></td>
				      <td width="23%"  ><span class="style1">NO HP AYAH</span></td>
					      <td width="23%"  ><span class="style1">NO HP IBU</span></td>
          </tr>
        <?php
	if ((isset($_POST['submit'])) AND ($_POST['search'] <> ""))
{
	$search = $_POST['search'];
	$sql1 = mysql_query("SELECT * FROM siswa LIKE '%$search%'") or die(mysql_error());
	}
	else{
	$sql1 = mysql_query("SELECT * FROM siswa order by no_induk asc LIMIT $mulai,$jum_hal");
	}
	$jumlah1 = mysql_num_rows($sql1);
	{
	$no=0;
	while ($tampil = mysql_fetch_array($sql1)){
	
	?>
  <tr><td   align="center"><span class="style1"><?php echo $no=$no+1;?></span></td>
      <td align="center"  ><span class="style1"><?php echo $tampil['no_induk']?></span></td>
    <td  ><a href="" class="style1"><?php echo $tampil['nisn']?></a></td>
    <td align="center"  ><span class="style1"><?php echo $tampil['nama_siswa'];?></span></td>
	 <td align="center"  ><span class="style1"><?php echo $tampil['jk'];?></span></td>
    <td align="center"  ><span class="style1"><?php echo $tampil['tmpt_lahir'];?>,<?php echo $tampil['tgl_lahir'];?></span></td>
    <td align="center"  ><span class="style1"><?php echo $tampil['kelas'];?></span></td>
    <td align="center"  ><span class="style1"><?php echo $tampil['alamat'];?></span></td>
	 <td align="center"  ><span class="style1"><?php echo $tampil['alamat'];?></span></td>
	  <td align="center"  ><span class="style1"><?php echo $tampil['alamat'];?></span></td>
	   <td align="center"  ><span class="style1"><?php echo $tampil['alamat'];?></span></td>
	    <td align="center"  ><span class="style1"><?php echo $tampil['alamat'];?></span></td>
    </tr>
  <?php
  }
}
  ?>
      </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
</form>
</div>
</body>
</html>
