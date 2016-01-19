<?php
 include_once "../config/inc.connection.php";
 include_once "../config/inc.library.php";
$tgl=date('d-m-Y');
//include_once "inc.library.php";
error_reporting(0);



?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Nota Pembayaran</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body onLoad="window.print()">
 
<table width="748" height="165" align="center" class="table table-striped table-bordered table-condensed">
<tr>
	  <td width="79" height="31" class="head-data">Laporan Pembayaran Per Kelas </td>
  </tr>
	<?php 
	error_reporting(0);	include "../config/inc.connection.php";

	
	echo "<tr><td class='td-data'>";
	
	
	$siswa			= isset($_POST['kab']) ? $_POST['kab'] : "";
	$pminjam		=mysql_query("SELECT * FROM pembayaran WHERE kelas ='$siswa'");
	$pminjam_lkp	=mysql_fetch_array($pminjam);
	
	if ($siswa=="") {
		echo "<table class='table-data' width='100%'>
		<tr><td class='head-data' align='center' colspan='5'>Data Kelas Siswa Yang Sudah Bayar</td></tr>
		<tr><td class='td-data' align='center'colspan='5'>-->>Silakan Pilih Tahun Ajaran dan Pilih Kelas Terlebih Dahulu<<--</td></tr></table>";
	} else {
		print "&nbsp;<table class='table table-striped   table-condensed'  >
			 
			<tr><td class='head-data'  colspan='11'><b>Daftar Jenis Pembayaran</b></td>
			</tr>
			 
			";
	?>

<tr>

  </tr>
<tr>
<tr>
    <td width="23" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    
    <td width="81" bgcolor="#F5F5F5"><strong>NIS</strong></td>
    <td width="118" bgcolor="#F5F5F5"><strong>Nama Siswa </strong></td>
    <td width="78" bgcolor="#F5F5F5"><strong>Kelas</strong></td>
    <td width="136" align="left" bgcolor="#F5F5F5"><strong> Jenis Bayar</strong></td>
    <td width="90" align="left" bgcolor="#F5F5F5"><strong> Biaya (Rp) </strong></td>
    <td width="83" align="left" bgcolor="#F5F5F5"><strong> Uang Bayar (Rp) </strong></td>
    <td width="104" align="left" bgcolor="#F5F5F5"><strong> Tuggakan (Rp) </strong></td>
    <td width="116" align="center" bgcolor="#F5F5F5"><strong> Periode Bulan &amp; Tahun</strong></td>
    <td width="94" bgcolor="#F5F5F5"><strong>Keterangan</strong></td>
  </tr>
 
  </tr>   
	<?php
	$jumlahbarang	= 0;

	$query=mysql_query("SELECT * from pembayaran_item  WHERE kelas ='$siswa'") or die (mysql_error());
	$jum=mysql_num_rows($query);
	if ($jum==0) {
	echo "<tr><td class='td-data' colspan='4'>-- $siswa Tidak Ada Data Pembayaran--</td></tr>";
	} else {
	while ($hasil=mysql_fetch_array($query))	 {
		$subSotal 	= $hasil['uang_bayar'] - $hasil['biaya'];
		$nomor++;
	$totalBayar	= $totalBayar +  $hasil['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($hasil['uang_bayar']);
	echo "<tr><td class='td-data'> $nomor </td> <td class='td-data'>$hasil[no_induk]</td><td align='left' class='td-data'>$hasil[nama_siswa]</td><td align='left'class='td-data'>$hasil[kelas]</td><td align='left' class='td-data'>$hasil[jns_bayar]</td><td align='left' class='td-data'>$hasil[biaya]</td><td align='left' class='td-data'>$hasil[uang_bayar]</td><td align='left' class='td-data'>$subSotal</td><td align='center' class='td-data'>$hasil[periode_thn]</td><td align='center' class='td-data'>$hasil[ket]</td> </tr>
	
	";
	
	
	} echo "<tr>
       <td width='138' height='24'colspan='3' align='right' bgcolor='#F5F5F5'><strong>GRAND TOTAL : </strong></td>
      
	  <td align='left'bgcolor='#F5F5F5'><b> </b></td>
	  <td align='left'bgcolor='#F5F5F5'><b> </b></td>
	  <td align='left'bgcolor='#F5F5F5'><b>$totalBayar</b></td>
	  <td align='left'bgcolor='#F5F5F5'><b> $jumlahbarang</b></td>
      <td align='left'bgcolor='#F5F5F5'><b>$totalBiaya</b></td>
      <td align='left'bgcolor='#F5F5F5'><b></b></td>
        <td align='left'bgcolor='#F5F5F5'></td>
		
    </tr>";
	
	}
	}	
    ?>
</table></td></tr></table>	
<table width="900" border="0" align="center">
  <tr>
    <td width="232">&nbsp;</td>
    <td width="455">&nbsp;</td>
    <td align="center" width="199"><br />
    Sumedang, <?php echo $tgl ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><p align="center">Bendahara TU<br />
      SMK KORPRI SUMEDANG</p></td>
  </tr>
  <tr>
    <td height="104">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
    <td>&nbsp;</td>
    <td><div align="center">Yati Supiati</div></td>
  </tr>
</table>		</body>
</html>