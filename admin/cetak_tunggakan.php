<a href="javascript:window.print()">


<?php
 
error_reporting(0);
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM jns_bayar";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Tunggakan</title>
 <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">
</head>
<body>
<h2>LAPORAN DATA TUNGGAKAN</h2>
<form action="cetak_tunggakan.php" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="2" bgcolor="#CCCCCC"><strong>DATA SISWA</strong></td>
    </tr>
    <tr>
    <?php 
				$nis=$_POST['nis'];
				$nama=$_POST['nama'];
				$kelas=$_POST['kelas'];

				
			?>
      <td><strong>NIS</strong></td>
      <td><strong>:</strong> <?php echo "$nis";?></td>
    </tr>
    <tr>
      <td><strong>Nama Siswa</strong></td>
      <td><strong>: </strong><?php echo "$nama";?></td>
    </tr>
    <tr>
      <td width="235"><strong>Kelas</strong></td>
      <td><strong>: </strong><?php echo "$kelas";?></td>
    </tr>
  </table>
  <br />
  <br />


<table class="table table-striped table-bordered table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="47" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="417" bgcolor="#CCCCCC"><strong>Jenis Bayar</strong></td>
    <td width="187" align="right" bgcolor="#CCCCCC"><strong> Biaya (Rp) </strong></td>
    <td width="187" align="right" bgcolor="#CCCCCC"><strong> Uang Bayar (Rp) </strong></td>
    <td width="230" align="right" bgcolor="#CCCCCC"><strong> Tuggakan (Rp) </strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi rawat
	$mySql = "SELECT *  FROM jns_bayar 
				ORDER BY kode_jenis ASC LIMIT $hal, $row";

	$myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		$subSotal 	= $myData['uang_bayar'] - $myData['biaya'];
	$totalBayar	= $totalBayar +  $myData['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($myData['uang_bayar']);
	# Membaca Nomor Rawat
	$noRawat = $myData['no_rawat']; 
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['jns_bayar']; ?></td>
    <td align="right"><?php echo format_angka($myData['biaya']); ?></td>
    <td align="right"><?php echo format_angka($myData['uang_bayar']); ?></td>
    <td align="right"><b><?php echo format_angka($subSotal); ?></b></td>
  </tr>
  <?php } ?>
 <tr>
      <td colspan="2" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL :  </strong></td>
      <td align="right" bgcolor="#00CCCC"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td align="right" bgcolor="#00FF33"><b><?php echo format_angka($jumlahbarang); ?></b></td>
      <td bgcolor="#FFA540" align="right"><b><?php echo format_angka($totalBiaya); ?></b></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
</a>
</body>
</html>