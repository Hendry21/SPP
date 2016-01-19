<?php
error_reporting("E_ALL^E_NOTICE");
if (!defined('BASEPATH')) exit('No direct script access allowed');
//include_once "../library/inc.seslogin.php";
//include_once "../config/inc.connection.php";
//include_once "../config/inc.library.php";


// =========================================================================

# TOMBOL TAMBAH (KODE barang) DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca Data dari Form
	 $txtKode = mysql_real_escape_string($_POST['txtKode']);
	$txtHarga	= mysql_real_escape_string($_POST['txtHarga']);
	$txtJumlah	= mysql_real_escape_string($_POST['txtJumlah']);
   
	# Validasi Form
	$pesanError = array();
	
	if (trim($txtKode)=="") {
		$pesanError[] = "Data <b>Kode Barang belum dipilih</b>, silahkan pilih dari kode barang!";		
	}
	
	
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah Barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	
	# Cek Stok, jika stok Opname (stok bisa dijual) < kurang dari Jumlah yang dibeli, maka buat Pesan Error
	$cekSql	= "SELECT stok FROM barang WHERE kd_barang='$txtKode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
	$cekRow = mysql_fetch_array($cekQry);
	if ($cekRow['stok'] < $txtJumlah) 
	{
		$pesanError[] = "Stok Barang untuk Kode <b>$txtKode</b> adalah <b> $cekRow[stok]</b>, tidak dapat dijual!";
	}
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else 
	{
		# SIMPAN KE DATABASE (tmp_penjualan)	
		// Jika Kode ditemukan, masukkan data ke Keranjang (TMP)
		if(!empty($txtKode))
		{
			$tmpSql = "INSERT INTO tmp_penjualan (kd_barang, harga, jumlah) 
					VALUES ('$txtKode', '$txtHarga', '$txtJumlah')";
		    mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
			
		}
	}
}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan']))
{
	# Baca Variabel from
	$txtTanggal 	= $_POST['txtTanggal'];
	$txtUangBayar	= $_POST['txtUangBayar'];
	$txtTotBayar	= $_POST['txtTotBayar'];
			
	# Validasi Form
	$pesanError = array();
	if(trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada tanggal !";		
	}
	
	if(trim($txtUangBayar)==""  or ! is_numeric(trim($txtUangBayar))) {
		$pesanError[] = "Data <b>Uang Bayar</b> belum diisi, harus berupa angka !";		
	}
	if(trim($txtUangBayar) < trim($txtTotBayar)) {
		$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
						 Total belanja adalah <b> Rp. ".format_angka($txtTotBayar)."</b>";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql = "SELECT COUNT(*) As qty FROM tmp_penjualan";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData= mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, belum ada barang yang dimasukan, <b>minimal 1 barang</b>.";
	}
	
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel penjualan dan penjualan_item
		$kd_jual = buatKode("penjualan", "JL15");
		$mySql	= "INSERT INTO penjualan SET 
						kd_jual='$kd_jual', 
						tgl_penjualan='".InggrisTgl($txtTanggal)."', 
						uang_bayar='$txtUangBayar'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		# …LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT * FROM tmp_penjualan ORDER BY kd_barang";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kd_barang'];
			$dataHarga	= $tmpData['harga'];
			$dataJumlah	= $tmpData['jumlah'];
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO penjualan_item SET 
									kd_jual='$kd_jual', 
									kd_barang='$dataKode', 
									harga='$dataHarga', 
									jumlah='$dataJumlah'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_penjualan";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		echo "<script>";
		echo "window.open('penjualan_nota.php?noNota=$kd_jual')";
		echo "</script>";

	}	
}
 
# TAMPILKAN DATA KE FORM
$kd_jual 	= buatKode("penjualan", "JL15");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
     <link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
    
</head>


<body>
   

  <?php
  // Membaca Nomor RM data Pasien
$no_induk= isset($_GET['no_induk']) ?  $_GET['no_induk'] : '';
$mySql	= "SELECT no_induk, nama_siswa FROM siswa WHERE no_induk='$no_induk'";
$myQry	= mysql_query($mySql)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);
$dataNama		= $myData['nama_siswa'];

# Kode pasien
if($no_induk=="") {
	$nisn= isset($_POST['no_induk']) ? $_POST['no_induk'] : '';
}

?>
 <?php
  // Membaca Nomor RM data Pasien
$kode_bayar= isset($_GET['kode_bayar']) ?  $_GET['kode_bayar'] : '';
$mySql	= "SELECT kode_bayar, jns_bayar FROM jns_bayar WHERE kode_bayar='$kode_bayar'";
$myQry	= mysql_query($mySql)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);
$dataJenis		= $myData['jns_bayar'];

# Kode pasien
if($kode_bayar=="") {
	$kode_bayar= isset($_POST['kode_bayar']) ? $_POST['kode_bayar'] : '';
}

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="430" align="left" class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3"><h2> TAMBAH DATA PEMBAYARAN</h2></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCCCCC"><strong>DATA PEMBAYARAN </strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="21%"><strong>Kode Pembayaran </strong></td>
      <td width="2%"><strong>:</strong></td>
      <td width="77%"><input name="txtNomor" value="<?php echo $kd_jual; ?>" size="23" maxlength="20" readonly/></td>
    </tr>
    <tr>
      <td><strong>Tanggal Pembayaran </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCCCCC"><strong>INPUT  SISWA </strong></td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td><strong>NISN</strong></td>
      <td><strong>:</strong></td>
      <td><input name="no_induk" value="<?php echo $no_induk; ?>" size="13" maxlength="13"   type="text" /> 
      <a href=""  target="_self">Cari siswa</a></td>
    </tr>
	<tr>
      <td><strong>Nama Siswa</strong></td>
      <td><strong>:</strong></td>
      <td><input name="nama_siswa" value="<?php echo $dataNama; ?>" size="40" maxlength="40" readonly /> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"bgcolor="#CCCCCC"><strong>INPUT PEMBAYARAN</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Periode Bulan &amp; Tahun</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtJenis2" value="<?php echo date("d");?>" size="5" maxlength="40"  />
      <input name="txtJenis3" value="<?php echo date("m");?>" size="5" maxlength="40"  />
      <input name="txtJenis4" value="<?php echo date("Y");?>" size="5" maxlength="40"  /></td>
    </tr>
    <tr>
      <td><strong>Jenis Bayar </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbjns_bayar">
        <option value="KOSONG">....</option>
        <?php
	  $bacaSql = "SELECT * FROM jns_bayar ORDER BY kode_bayar";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['jns_bayar'] == $datajns_bayar) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[jns_bayar]' $cek>$bacaData[jns_bayar] ,$cek>$bacaData[biaya]</option>";
	  }
	  ?>
      </select>       
      </td>
    </tr>
    <tr>
      <td><strong>Bayar (Rp.)</strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input name="txtHarga2"  size="40" maxlength="40"  />
      </b></td>
    </tr>
    <tr>
      <td><b>Keterangan</b></td>
      <td><b>:</b></td>
      <td><b>
        <textarea name="txtHarga" cols="40" ><?php echo $dataHargaJual; ?></textarea>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><b>
        <input name="btnTambah" class="btn btn-primary" type="submit" style="cursor:pointer;" value=" Simpan " />
      </b></td>
    </tr>
   
  </table>
  <br /></form>
</body>
<?php include "include/cari_siswa.php";?>
</html>