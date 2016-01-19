

<?php
//include_once "inc.library.php";
error_reporting(0);


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM jns_bayar";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN DATA TUNGGAKAN</h2>
<form action="cetak_tunggakan.php" method="post" name="form1" target="_blank">
  <table width="500" border="0"  class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>DATA SISWA</strong></td>
    </tr>
    <tr>
      <td><strong>NIS</strong></td>
      <td><strong>:</strong></td>
      <td><input name="nis" type="text" size="50"  placeholder="Masukan NIS"/></td>
    </tr>
    <tr>
      <td><strong>Nama Siswa</strong></td>
      <td><strong>:</strong></td>
      <td><input name="nama" type="text" size="50"  placeholder="Masukan Nama Siswa"/></td>
    </tr>
    <tr>
      <td width="130"><strong>Kelas</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="351"><input name="kelas" type="text" size="50"  placeholder="Masukan Kelas"/></td>
    </tr>
  </table>


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
<p><input type="submit" value="Cetak">
</p>
</form>