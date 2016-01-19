<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=simpanbyrxls.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
<?php
error_reporting(0);

//include_once "library/inc.seslogin.php";
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 10000000;
$halaman 	= isset($_GET['hal']) ? mysql_real_escape_string($_GET['hal']) : 0;
$pageSql 	= "SELECT * FROM  pembayaran";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<div align="center"> <h2> DATA TRANSAKSI PEMBAYARAN </h2>
<br />
<div class="main-content">
<div class="btn-toolbar list-toolbar">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%">
    
    </a>  </td>
    <td width="47%" align="right">   </td>
  </tr>
</table>

 <div class="btn-group">
 
                
</div></div>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <td width="21" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="79" bgcolor="#CCCCCC"><strong>Tanggal Bayar</strong></td>
    <td width="108" bgcolor="#CCCCCC"><strong>Kode Bayar </strong></td>
    <td width="108" bgcolor="#CCCCCC"><strong>Jenis Bayar </strong></td>
    <td width="70" align="left" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Nama Siswa</strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Kelas</strong></td>
    <td width="76" align="right" bgcolor="#CCCCCC"><strong>Uang Bayar</strong></td>
  
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi Penjualan$subTotalJual	= 0;
	$grandTotalJual	= 0;
	$jumlahbarang	= 0;
	// SQL menampilkan item barang yang dijual
	$mySql ="SELECT    pembayaran.*,  pembayaran_item.uang_bayar,biaya,jns_bayar FROM pembayaran
			  LEFT JOIN pembayaran_item ON pembayaran.kd_pembayaran=pembayaran_item.kd_pembayaran
			  ORDER BY pembayaran.tgl_bayar  asc LIMIT $halaman, $barisData";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$jumData	= mysql_num_rows($myQry);
	$nomor  = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotalJual 	= $myData['biaya'] - $myData['uang_bayar'];
		$grandTotalJual	= $grandTotalJual + $subTotalJual; 
		       $jumlahbarang	= $jumlahbarang + $myData['biaya'];
	?>
    
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
    <td><?php echo $myData['kd_pembayaran']; ?></td>
    <td><?php echo $myData['jns_bayar']; ?></td>
    <td align="left"><?php echo $myData['no_induk']; ?></td>
    <td align="right"><?php echo $myData['nama_siswa']; ?></td>
    <td align="right"><?php echo $myData['kelas']; ?></td>
    <td align="right"><?php echo format_angka($myData['uang_bayar']); ?></td>
   
  </tr>
  <?php } ?>
  <tr>
    <td colspan="7" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><b><?php echo format_angka($jumlahbarang); ?></b></td>
   
  </tr>
  <tr>
    <td colspan="8"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="2" align="right"><strong></strong></td>
  </tr>
</table>
<p>&nbsp;</p>
</div>
</div>