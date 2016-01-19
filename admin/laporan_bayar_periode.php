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

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "WHERE ( periode_thn  BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat Nomor Halaman diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "WHERE ( periode_thn  BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 1000000;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembayaran_item  $filterPeriode";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<?php 
$pageS = "SELECT * FROM siswa" ;
$pag = "SELECT * FROM jns_bayar" ;
$pag1 = "SELECT * FROM pembayaran_item $filterPeriode " ;
 
$pageQ  = mysql_query($pageS) or die ("error paging: ".mysql_error());
$pageQ1  = mysql_query($pag) or die ("error paging: ".mysql_error());
$pageQ2  = mysql_query($pag1) or die ("error paging: ".mysql_error());

$jmlh	 = mysql_num_rows($pageQ);

	while ($jmlh1 = mysql_fetch_array($pageQ1))
	
	 {
		 
		$sub	= $sub +  $jmlh1['biaya'];
		$sub1   = $sub * $jmlh;
		$htg	= $sub1 - $Sotal;
		 	
	while ($jmlh2 = mysql_fetch_array($pageQ2))	
	 {
		
		$Sotal	= $Sotal +  $jmlh2['uang_bayar'];
		
		}}		
 ?>
<h2 align="center">LAPORAN PEMBAYARAN PER PERIODE </h2>
<p align="center"><strong>PERIODE :</strong> <?php echo $tglAwal  ?><strong> S/D</strong> <?php echo $tglAkhir  ?></p>
<table onclick="window.print()" width="100%" border="1"  >
  
  <tr>
    <td colspan="4" align="left" bgcolor="#CCCCCC"><strong>Daftar Siswa</strong></td>
  </tr>
  <tr>
    <td width="61" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="209" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="523" bgcolor="#CCCCCC"><strong>Nama Siswa </strong></td>
    <td width="280" bgcolor="#CCCCCC"><strong>Kelas</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi rawat
	$mySql = "SELECT distinct no_induk,nama_siswa,kelas  FROM pembayaran_item 
				 
				$filterPeriode 
				ORDER BY pembayaran_item.no_induk  ASC LIMIT $hal, $row";

	$myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		
	
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo  ($myData['no_induk']); ?></td>
    <td> <?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['kelas']; ?></td>
  </tr>
  <?php } ?>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi rawat
	$mySql = "SELECT pembayaran_item.*   FROM pembayaran_item 
				LEFT JOIN siswa ON pembayaran_item.no_induk =  siswa.no_induk
				$filterPeriode 
				ORDER BY siswa.no_induk  ASC LIMIT $hal, $row";
	
 

	
	$myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		
				
		$subSotal 	= $myData['uang_bayar'] - $myData['biaya'];
	$totalBayar	= $totalBayar +  $myData['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($myData['uang_bayar']);
	 
	?><?php }  ?>
    
  <tr>
    <td colspan="4"   align="right" bgcolor="#9999FF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"   align="center" bgcolor="#F5F5F5"><strong>Keterangan : </strong></td>
    <td colspan="2" align="right" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
      <td colspan="2"   align="right" bgcolor="#F5F5F5"><strong>Grand Total Uang </strong></td>
      <td colspan="2"   align="left" bgcolor="#F5F5F5"><b> : Rp. <?php echo format_angka($sub1); ?></td>
      
  </tr>
  
  <tr>
    <td colspan="2"   align="right" bgcolor="#F5F5F5"><strong>Grand Total Uang Masuk </strong></td>
    <td colspan="2"   align="left" bgcolor="#F5F5F5"><b> : Rp. <?php echo format_angka($jumlahbarang); ?></b></td>
  </tr>
  <tr>
    <td colspan="2"   align="right" bgcolor="#F5F5F5"><strong>Grand Total Uang Belum Masuk </strong></td>
    <td colspan="2"   align="left" bgcolor="#F5F5F5"><b> : Rp. <?php echo format_angka($htg); ?></b></td>
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
<p>&nbsp;</p>
