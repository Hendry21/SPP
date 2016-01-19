

<?php
//include_once "inc.library.php";
error_reporting(0);
// Variabel SQL
$filterSQL= "";

// Temporary Variabel form
$dataPasien	= isset($_POST['cmbPasien']) ? $_POST['cmbPasien'] : 'SEMUA';

# PENCARIAN DATA BERDASARKAN FILTER DATA
if(isset($_POST['btnTampil'])) {
	# PILIH pasien
	if (trim($_POST['cmbPasien']) =="KOSONG") {
		$filterSQL = "";
	}
	else {
		$filterSQL = "WHERE pembayaran_item.jns_bayar='$dataPasien'";
	}
}
else {
	$filterSQL= "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 900000000;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembayaran_item $filterSQL";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN DATA PEMBAYARAN PER JENIS BAYAR</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA JENIS PEMBAYARAN</strong></td>
    </tr>
    <tr>
      <td width="130"><strong>Jenis Bayar </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="351">
	  <select name="cmbPasien">
        <option value="KOSONG">....</option>
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
      </select>
      <input name="btnTampil" type="submit" value="Tampilkan " />
      </td>
    </tr>
  </table>
</form>

<table  class="table table-striped table-bordered table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="76" bgcolor="#CCCCCC"><strong>Tgl Bayar </strong></td>
    <td width="91" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="142" bgcolor="#CCCCCC"><strong>Nama Siswa </strong></td>
    <td width="82" bgcolor="#CCCCCC"><strong>Kelas</strong></td>
    <td width="99" bgcolor="#CCCCCC"><strong>Jenis Bayar</strong></td>
    <td width="91" align="right" bgcolor="#CCCCCC"><strong> Biaya (Rp) </strong></td>
    <td width="91" align="right" bgcolor="#CCCCCC"><strong> Uang Bayar (Rp) </strong></td>
    <td width="112" align="right" bgcolor="#CCCCCC"><strong> Tuggakan (Rp) </strong></td>
    <td width="125" align="center" bgcolor="#CCCCCC"><strong> Periode Bulan &amp; Tahun</strong></td>
    <td width="106" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi rawat
	$mySql = "SELECT pembayaran_item.*, pembayaran.tgl_bayar  FROM pembayaran_item 
				LEFT JOIN pembayaran ON pembayaran_item.kd_pembayaran =  pembayaran.kd_pembayaran
				$filterSQL
				ORDER BY pembayaran_item.kd_pembayaran ASC LIMIT $hal, $row";

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
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
    <td><?php echo  ($myData['no_induk']); ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['kelas']; ?></td>
    <td><?php echo $myData['jns_bayar']; ?></td>
    <td align="right"><?php echo format_angka($myData['biaya']); ?></td>
    <td align="right"><?php echo format_angka($myData['uang_bayar']); ?></td>
    <td align="right"><b><?php echo format_angka($subSotal); ?></b></td>
    <td align="center"><?php echo $myData['periode_thn']; ?></td>
    <td><?php echo $myData['ket']; ?></td>
  </tr>
  <?php } ?>
 <tr>
      <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
      <td align="right"  >&nbsp;</td>
     
      <td align="right" bgcolor="#00CCCC"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td align="right" bgcolor="#00FF33"><b><?php echo format_angka($jumlahbarang); ?></b></td>
      <td bgcolor="#FFA540" align="right"><b><?php echo format_angka($totalBiaya); ?></b></td>
       <td bgcolor="#F5F5F5"> </td>
            <td bgcolor="#F5F5F5"> </td>
      
  </tr>
</table>
<p>
<form name="form1" method="post"  target="_blank" action="cari_data_pembayaran1.php">
  
  <table  align="left" cellpadding="2" cellspacing="2">
   
    <tr>
      <td> 
        <input name="cmbPasien2" type="hidden" value="<?php echo $_POST['cmbPasien'] ?>  " />
       <button class="btn btn-warning" name="lprbtn" type="submit" ><i class="fa fa-print"></i> Cetak</button>
      </td>
    </tr>
  </table>
</form> 

 
