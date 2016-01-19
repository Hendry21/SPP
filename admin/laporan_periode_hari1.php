<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 

<?php
 include_once "../config/inc.connection.php";
 include_once "../config/inc.library.php";

error_reporting (0);
# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";
$tgl=date('d-m-Y');
$filterSQL= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');
$dataPasien	= isset($_POST['cmbPasien']) ? $_POST['cmbPasien'] : 'SEMUA';

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "WHERE ( tgl_bayar  BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat Nomor Halaman diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "WHERE ( tgl_bayar  BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
if(isset($_POST['btnTampil'])) {
	# PILIH pasien
	if (trim($_POST['cmbPasien']) =="SEMUA") {
		$filterSQL = "";
	}
	else {
		$filterSQL = "WHERE harian.jns_bayar='$dataPasien' AND harian.tgl_bayar  BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."'";
	}
}
else {
	$filterSQL= "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 900000000;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM harian  $filterSQL";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2 align="center">LAPORAN PEMBAYARAN HARIAN </h2>
<p align="center" ><strong>PERIODE :</strong> <?php echo $tglAwal  ?><strong> S/D</strong> <?php echo $tglAkhir  ?><strong> Per </strong><?php echo $dataPasien  ?></p>

<table onclick="window.print()"  width="100%" border="1" cellspacing="0" cellpadding="0">
  
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="87" bgcolor="#CCCCCC"><strong>Tgl Bayar </strong></td>
    <td width="81" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="118" bgcolor="#CCCCCC"><strong>Nama Siswa </strong></td>
    <td width="78" bgcolor="#CCCCCC"><strong>Kelas</strong></td>
    <td width="136" align="right" bgcolor="#CCCCCC"><strong> Jenis Bayar</strong></td>
    <td width="83" align="right" bgcolor="#CCCCCC"><strong> Uang Bayar (Rp) </strong></td>
    <td width="116" align="center" bgcolor="#CCCCCC"><strong> Periode Bulan &amp; Tahun</strong></td>
    <td width="94" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi rawat
	$mySql = "SELECT * FROM harian	$filterSQL 
				ORDER BY  no_induk  ASC LIMIT $hal, $row";

	$myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		$subSotal 	= $myData['uang_bayar1'] - $myData['biaya'];
	$totalBayar	= $totalBayar +  $myData['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($myData['uang_bayar1']);
	# Membaca Nomor Rawat
	
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
    <td><?php echo  ($myData['no_induk']); ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['kelas']; ?></td>
    <td align="right"><?php echo  ($myData['jns_bayar']); ?></td>
    <td align="right"><?php echo format_angka($myData['uang_bayar1']); ?></td>
    <td align="center"><?php echo $myData['periode_thn']; ?></td>
    <td><?php echo $myData['ket']; ?></td>
  </tr>
  <?php } ?>
 <tr>
      <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
      <td bgcolor="#F5F5F5"> </td>
      <td align="right" bgcolor="#00FF33"><b><?php echo format_angka($jumlahbarang); ?></b></td>
      <td bgcolor="#F5F5F5"> </td>
      <td bgcolor="#F5F5F5"> </td>
  </tr>
</table>
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
    <td><p align="center">Bendahara<br />
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
    <td><div align="center">Dra. Ita Rosintawati</div></td>
  </tr>
</table>
 