<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 
  <?php   
    $mySql = mysql_query("SELECT sum(biaya) as jumlah FROM jns_bayar");
    while($row=mysql_fetch_assoc($mySql)):?>
    <td> <?php echo($row['jumlah']);?></td>
    <?php endwhile;?>
<?php
include_once "../config/inc.library.php";
error_reporting (0);
# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

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
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembayaran_item,siswa $filterPeriode";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN PEMBAYARAN PER PERIODE </h2>
<p>&nbsp;</p>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0" class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>PERIODE PEMBAYARAN </strong></td>
    </tr>
    <tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><input name="txtTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
        <input name="txtTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
<table class="table table-striped table-bordered table-condensed" width="1295" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="31" rowspan="3" align="center" bgcolor="#CCCCCC"><div align="center"><strong>No</strong></div></td>
    <td width="88" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>NIS</strong></div></td>
    <td width="126" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>Nama Siswa</strong></div></td>
    <td width="112" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>Kelas</strong></div></td>
    <td width="173" rowspan="3" bgcolor="#CCCCCC"><div align="center"><strong>Prog. Keahlian</strong></div></td>
    <td colspan="10" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Jenis Pembayaran</strong></div></td>
    <td width="38" rowspan="2" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Jumlah</strong></div></td>
  </tr>

  <tr>
   <?php
  # Perintah untuk menampilkan Penjualan dengan Filter Periode
  $mySql = "SELECT * FROM jns_bayar";
  $myQry = mysql_query($mySql)  or die ("Query 1 salah : ".mysql_error());
  
  while ($myData = mysql_fetch_array($myQry)):?>
    <td><?php echo $myData['jns_bayar'];?></td>
    <?php endwhile;?>
  </tr>
   <tr>
   <?php
  # Perintah untuk menampilkan Penjualan dengan Filter Periode
  $mySql = "SELECT * FROM jns_bayar";
  

  $myQry = mysql_query($mySql)  or die ("Query 1 salah : ".mysql_error());
  
  while ($myData = mysql_fetch_array($myQry)):?>
    <td><?php echo $myData['biaya'];?></td>
    <?php endwhile;?>
    
    <td>
    <?php
    //jumlah   
    $mySql = mysql_query("SELECT sum(biaya) as jumlah FROM jns_bayar");
    while($row=mysql_fetch_assoc($mySql)):?>
     <?php echo($row['jumlah']);?>
    <?php endwhile;?>
    </td>
    
  </tr>
  <?php
	# Perintah untuk menampilkan Penjualan dengan Filter Periode
	$mySql = "select no_induk,nama_siswa,kelas,prog_keahlian from siswa";
	$myQry = mysql_query($mySql)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $hal;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
	
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_induk']; ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['kelas']; ?></td>
    <td><?php echo $myData['prog_keahlian']; ?></td>

    <td>
      
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong> <?php echo $Jumlahl; ?></td>
    <td colspan="13" align="right"><strong>Halaman ke :</strong>
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Laporan-Penjualan-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
	}
	?>
    </td>
  </tr>
</table>
