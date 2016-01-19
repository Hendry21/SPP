<?php
error_reporting(0);
//include_once "../library/inc.seslogin.php";
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";

# SKRIP MEMBACA DATA PENJUALAN
if(isset($_GET['noNota'])){
	// Membaca nomor penjualan dari URL
	$noNota = @mysql_real_escape_string($_GET['noNota']);
	// Skrip untuk pembaca data dari database
	$mySql = "SELECT pembayaran.*, admin.nm_petugas FROM pembayaran
				LEFT JOIN admin ON pembayaran.kd_petugas=admin.kd_petugas 
				WHERE kd_pembayaran='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Nota (noNota) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Nota Pembayaran</title>
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
<style type="text/css">
.table-list tr td strong b {
	font-size: 10px;
}
.table-list tr td strong b {
	font-size: 12px;
}
.table-list tr td strong u {
	font-size: 12px;
}
.table-list {
	font-size: 12px;
}
</style>
</head>
<body onLoad="window.print()">

<table class="table-list" width="400" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td height="90" colspan="6" align="center">
		<table width="99" height="62" border="0" align="left" cellpadding="0" cellspacing="0">
		  <tr>
		    <td width="180"><img src="../images/logo yayasan.gif" width="96" height="86"></td>
	      </tr>
	  </table>
	  <strong><b>YAYASAN KORPRI KABUPATEN SUMEDANG</b></strong><br>
		<strong><b>SEKOLAH MENENGAH KEJURUAN KORPRI SUMEDANG</b></strong><br>
		<strong><b>TERAKREDITASI  A  (AMAT BAIK) NO.02.00/324/BAP-SMK/XI/2013</b></strong><br>
		<strong><b>Tgl. 14 Nopember 2013 NSS/NIS : 322021018004/400060</b></strong><br>
		<strong><b>Jalan Mekarsari, Mekarjaya Telp.(0261) 202267 Sumedang 45323</b></strong><br></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><span class="table-list"><span class="style2">___________________________________________________________________________________________________</span></span></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><strong><u>KWITANSI</u></strong></td>
  </tr>
  <tr>
    <td width="136">&nbsp;</td>
    <td width="95">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="table-list"><strong>No Pembayaran </strong></span></td>
    <td><span class="table-list"><strong>:</strong> <?php echo $kolomData['kd_pembayaran']; ?></span></td>
    <td  align="right" colspan="4"><span class="table-list"><strong>Kelas :</strong> <?php echo $kolomData['kelas']; ?></span></td>
  </tr>
  <tr>
    <td><span class="table-list"><strong>Sudah terima dari </strong></span></td>
    <td colspan="5"><span class="table-list"><strong>:</strong> <?php echo $kolomData['nama_siswa']; ?></span></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#999999"><span class="table-list"><strong>Daftar Jenis Pembayaran </strong></span></td>
    <td width="159" align="left"  bgcolor="#999999"><span class="table-list"><strong>Periode</strong></span></td>
    <td width="118" align="right"  bgcolor="#999999"><span class="table-list"><strong>Biaya (Rp)</strong></span></td>
    <td width="171" align="right"  bgcolor="#999999"><span class="table-list"><strong>Uang Bayar (Rp) </strong></span></td>
  </tr>
<?php
# Baca variabel
$totalBayar = 0; 
$jumlahBarang = 0;  
$uangKembali=0;

# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
$notaSql = "SELECT pembayaran_item.*, pembayaran.nama_siswa FROM pembayaran_item
			LEFT JOIN pembayaran ON pembayaran_item.kd_pembayaran=pembayaran.kd_pembayaran 
			WHERE pembayaran_item.kd_pembayaran='$noNota'
			ORDER BY pembayaran.no_induk ASC";
$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query list salah : ".mysql_error());
$nomor  = 0;  
while($tmpData = mysql_fetch_array($notaQry)) {
	$nomor++;
	$subSotal 	= $tmpData['uang_bayar'] - $tmpData['biaya'];
	$totalBayar	= $totalBayar +  $tmpData['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($tmpData['uang_bayar']);
?>
  <tr>
    <td colspan="3"><span class="table-list"><?php echo $tmpData['kode_jenis']; ?>/ <?php echo $tmpData['jns_bayar']; ?></span></td>
    <td align="left"><span class="table-list"><?php echo $tmpData['periode_thn']; ?></span></td>
    <td align="right"><span class="table-list"><?php echo format_angka($tmpData['biaya']); ?></span></td>
    <td align="right"><span class="table-list"><?php echo format_angka($tmpData['uang_bayar']); ?></span></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><span class="table-list"><strong>Jumlah Biaya (Rp) : </strong></span></td>
    <td align="right" bgcolor="#999999"><span class="table-list"><b><?php echo format_angka($totalBayar); ?></b></span></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><span class="table-list"><strong> Jumlah Uang Bayar (Rp) : </strong></span></td>
    <td align="right" bgcolor="#999999"><span class="table-list"><b><?php echo format_angka($jumlahbarang); ?></b></span></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><span class="table-list"><strong>Jumlah Uang Tunggakan (Rp) : </strong></span></td>
    <td align="right" bgcolor="#999999"><span class="table-list"><b><?php echo format_angka($totalBiaya); ?></b></span></td>
  </tr>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
    <td align="left"><span class="table-list">Sumedang, <?php echo IndonesiaTgl($kolomData['tgl_bayar']); ?></span></td>
  </tr>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
    <td align="center"><span class="table-list">Yang Menerima,</span></td>
  </tr>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
    <td align="center"><span class="table-list">TTD</span></td>
  </tr>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
    <td align="center"><span class="table-list"><?php echo $kolomData['nm_petugas']; ?></span></td>
  </tr>
</table>
</body>
</html>
