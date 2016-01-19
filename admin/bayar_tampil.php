<?php
error_reporting(0);
// Membaca variabel form
$KeyWord	= isset($_GET['KeyWord']) ? $_GET['KeyWord'] : '';
$dataCari	= isset($_POST['txtCari']) ? $_POST['txtCari'] : $KeyWord;

// Jika tombol Cari diklik
if(isset($_POST['btnCari'])){
	if($_POST) {
		$filterSql = "WHERE nama_siswa LIKE '%$dataCari%'";
	}
}
else {
	if($KeyWord){
		$filterSql = "WHERE nama_siswa LIKE '%$dataCari%'";
	}
	else {
		$filterSql = "";
	}
}
if (!defined('BASEPATH')) exit('No direct script access allowed');
//include_once "library/inc.seslogin.php";
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 100;
$halaman 	= isset($_GET['hal']) ? mysql_real_escape_string($_GET['hal']) : 0;
$pageSql 	= "SELECT    pembayaran.*,  pembayaran_item.uang_bayar,biaya,jns_bayar FROM pembayaran
			  LEFT JOIN pembayaran_item ON pembayaran.kd_pembayaran=pembayaran_item.kd_pembayaran 
			  ORDER BY pembayaran.tgl_bayar  asc  ";
			  
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2> DATA TRANSAKSI PEMBAYARAN </h2>
<br />
<div class="main-content">
<div class="btn-toolbar list-toolbar">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%"> <a href="?page=addpembayaran">
    <button class="btn btn-primary"  >
<i class="fa fa-plus"></i> Tambah  Pembayaran Baru</button>
    </a>   <a href="simpanbyrxls.php"> 
    <button class="btn btn-info"  ><i class="fa fa-save"></i> Simpan Excel </button>
    </a> </td>
    <td width="47%" align="right"><form class="form-inline" method="post" style="margin-top:0px; "  action="?page=bayar_tampil" name="cari">
                    <input class="input-xlarge form-control" placeholder="Cari Nama Siswa ..." id="appendedInputButton" name="txtCari" type="text"  value="<?php echo $dataCari; ?>">
                    <button class="btn btn-default" name="btnCari" type="submit "><i class="fa fa-search"></i> Cari</button>
                </form>
                </td>
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
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi Penjualan$subTotalJual	= 0;
	$grandTotalJual	= 0;
	$jumlahbarang	= 0;
	// SQL menampilkan item barang yang dijual
	$mySql ="SELECT    pembayaran.*,  pembayaran_item.uang_bayar,biaya,jns_bayar FROM pembayaran
			  LEFT JOIN pembayaran_item ON pembayaran.kd_pembayaran=pembayaran_item.kd_pembayaran 
			  ORDER BY pembayaran.tgl_bayar  asc LIMIT $halaman, $barisData ";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$jumData	= mysql_num_rows($myQry);
	$nomor  = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotalJual 	= $myData['biaya'] - $myData['uang_bayar'];
		$grandTotalJual	= $grandTotalJual + $subTotalJual; 
		       $jumlahbarang	= $jumlahbarang + $myData['uang_bayar'];
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
    <td width="31" align="center"><a href="bayar_nota.php?noNota=<?php echo $myData ['kd_pembayaran'];?>" target="_blank">Nota</a></td>
    <td width="52" align="center"><a href="?page=hapus_bayar&amp;kd_pembayaran=<?php echo $myData ['kd_pembayaran'];?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENJUALAN INI ... ?')">Delete</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="7" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><b><?php echo format_angka($jumlahbarang); ?></b></td>
    <td colspan="2" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="8" align="right"><strong>Halaman ke :
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?page=bayar_tampil&hal=$list[$h]'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
<p>&nbsp;</p>
</div>
</div>