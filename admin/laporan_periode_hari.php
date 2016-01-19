<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 

<?php
include_once "../config/inc.library.php";
error_reporting (0);
# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";
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
	$filterPeriode = "WHERE $dataPasien( tgl_bayar  BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
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
$row = 1000000;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM harian  $filterSQL";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN PEMBAYARAN PER PERIODE </h2>
<p>&nbsp;</p>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0" class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>PERIODE PEMBAYARAN PER JENIS BAYAR</strong></td>
    </tr>
    <tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><input name="txtTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
        <input name="txtTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Jenis Bayar</strong></td>
      <td>&nbsp;</td>
      <td><select name="cmbPasien">
        <option value="SEMUA">..:: Semua ::..</option>
        <?php
	  $dataSql = "SELECT distinct jns_bayar FROM jns_bayar   ORDER BY jns_bayar";
	  $dataQry = mysql_query($dataSql) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['jns_bayar'] == $dataPasien) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[jns_bayar]' $cek>[ $dataRow[kd_pembayaran] ]  $dataRow[jns_bayar]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
<table class="table table-striped table-bordered table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
  
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
<form action="laporan_periode_hari1.php" method="post" name="form1" target="_blank">
  <table width="397" border="0"  >
    <tr>
      <td width="391">
         <input name="txtTglAwal" type="hidden" class="tcal" value="<?php echo $tglAwal; ?>" />
     
        <input name="txtTglAkhir" type="hidden" class="tcal" value="<?php echo $tglAkhir; ?>" />
        <input name="cmbPasien" type="hidden"  value="<?php echo $dataPasien; ?>" />
<button class="btn btn-warning" name="btnTampil" type="submit" ><i class="fa fa-print"></i> Cetak</button></td>
    </tr>
  </table>
</form>