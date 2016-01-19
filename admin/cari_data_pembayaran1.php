

<?php
 include_once "../config/inc.connection.php";
 include_once "../config/inc.library.php";
$tgl=date('d-m-Y');
//include_once "inc.library.php";
error_reporting(0);

$filterSQL= "";

// Temporary Variabel form
$dataPasien	= isset($_POST['cmbPasien2']) ? $_POST['cmbPasien2'] : 'SEMUA';

# PENCARIAN DATA BERDASARKAN FILTER DATA
if(isset($_POST['lprbtn'])) {
	# PILIH pasien
	if (trim($_POST['cmbPasien2']) =="KOSONG") {
		$filterSQL = "";
	}
	else {
		$filterSQL = "WHERE pembayaran_item.jns_bayar='$dataPasien'";
	}
}
else {
	$filterSQL= "";
}


 

?>
<h2>Laporan Data Pembayaran Per <?php echo $_POST['cmbPasien2'] ?> </h2>

<table  onclick="window.print()"    width="100%" border="1" cellspacing="0" cellpadding="0">
  
   
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="108" align="center" bgcolor="#CCCCCC"><strong>Tgl Bayar </strong></td>
    <td width="88" align="center" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="119"  align="center" bgcolor="#CCCCCC"><strong>Nama Siswa </strong></td>
    <td width="84" align="center" bgcolor="#CCCCCC"><strong>Kelas</strong></td>
    <td width="101" align="center" bgcolor="#CCCCCC"><strong>Jenis Bayar</strong></td>
    <td width="93" align="right" bgcolor="#CCCCCC"><strong> Biaya (Rp) </strong></td>
    <td width="93" align="right" bgcolor="#CCCCCC"><strong> Uang Bayar (Rp) </strong></td>
    <td width="114" align="right" bgcolor="#CCCCCC"><strong> Tuggakan (Rp) </strong></td>
    <td width="159" align="center" bgcolor="#CCCCCC"><strong> Periode Bulan &amp; Tahun</strong></td>
    <td width="82" align="center" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
  <?php
   
	# Perintah untuk menampilkan Semua Daftar Transaksi rawat
	$mySql = "SELECT pembayaran_item.*, pembayaran.tgl_bayar  FROM pembayaran_item 
				LEFT JOIN pembayaran ON pembayaran_item.kd_pembayaran =  pembayaran.kd_pembayaran
				$filterSQL
				ORDER BY pembayaran_item.kelas   ";

	$myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		$subSotal 	= $myData['uang_bayar'] - $myData['biaya'];
	$totalBayar	= $totalBayar +  $myData['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($myData['uang_bayar']);
	 
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
    <td><?php echo  ($myData['no_induk']); ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['kelas']; ?></td>
    <td align="center"><?php echo $myData['jns_bayar']; ?></td>
    <td align="right"><?php echo format_angka($myData['biaya']); ?></td>
    <td align="right"><?php echo format_angka($myData['uang_bayar']); ?></td>
    <td align="right"><b><?php echo format_angka($subSotal); ?></b></td>
    <td align="center"><?php echo IndonesiaTgl($myData['periode_thn']); ?></td>
    <td><?php echo $myData['ket']; ?></td>
  </tr>
  <?php } ?>
 <tr>
      <td colspan="5" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
      <td align="right"  bgcolor="#F5F5F5" >&nbsp;</td>
     
      <td align="right" bgcolor="#00CCCC"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td align="right" bgcolor="#00FF33"><b><?php echo format_angka($jumlahbarang); ?></b></td>
      <td bgcolor="#FFA540" align="right"><b><?php echo format_angka($totalBiaya); ?></b></td>
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
<p>&nbsp;</p>
