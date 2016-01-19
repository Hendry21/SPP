
<?php
error_reporting("E_ALL^E_NOTICE");
if (!defined('BASEPATH')) exit('No direct script access allowed');
//include_once "../library/inc.seslogin.php";
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";


// =========================================================================

# TOMBOL TAMBAH (KODE barang) DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca Data dari Form
	$periode_thn = $_POST['thn']."-".$_POST['bln']."-".$_POST['tgl'];

	$cmbJns_bayar	= mysql_real_escape_string($_POST['cmbJns_bayar']);
	$txtBiaya	= mysql_real_escape_string($_POST['txtBiaya']);
	$txtUang_bayar	= mysql_real_escape_string($_POST['txtUang_bayar']);
	$txtKodejenis 	= mysql_real_escape_string($_POST['txtKodejenis']);
	$txtKet	= mysql_real_escape_string($_POST['txtKet']);
    $no_induk	= $_POST['no_induk'];
	$nama_siswa	= $_POST['nama_siswa'];
	$kelas	= $_POST['kelas'];
	$txtNomor	= $_POST['txtNomor'];
	$txtTanggal	= $_POST['txtTanggal'];
 


	# Validasi Form
	$pesanError = array();
	
	if (trim($txtBiaya)=="") {
		$pesanError[] = "Data <b>Biaya belum di isi</b>, silahkan pilih dari <b>Jenis Pembayaran !</b>";		
	}
	
	
	if (trim($txtUang_bayar)=="") {
		$pesanError[] = "Data <b>Uang Bayar (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	if(trim($no_induk)=="") {
		$pesanError[] = "Data <b>NIS</b> belum diisi  !";		
	}
	if(trim($nama_siswa)=="") 
	{
		$pesanError[] = "Data <b>Nama Siswa</b> belum diisi  !";		
	}
	if(trim($kelas)=="") 
	{
		$pesanError[] = "Data <b>Kelas</b> belum diisi  !";		
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
		
		{
			$tmpSql = "INSERT INTO tmp_pembayaran (periode_thn, no_induk, nama_siswa, kelas, kode_jenis, jns_bayar, biaya, uang_bayar, ket, kd_pembayaran, tgl_bayar, kd_petugas) 
					VALUES ('$periode_thn', '$no_induk', '$nama_siswa', '$kelas', '$txtKodejenis', '$cmbJns_bayar', '$txtBiaya', '$txtUang_bayar', '$txtKet', '$txtNomor', '".InggrisTgl($txtTanggal)."', '".$_SESSION['SES_LOGIN']."')";
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
	$no_induk	= $_POST['no_induk'];
	$nama_siswa	= $_POST['nama_siswa'];
	$kelas	= $_POST['kelas'];
			
	# Validasi Form
	$pesanError = array();
	if(trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada tanggal !";		
	}
	
	if(trim($no_induk)=="") {
		$pesanError[] = "Data <b>NIS</b> belum diisi  !";		
	}
	if(trim($kelas)=="") {
		$pesanError[] = "Data <b>Kelas Siswa</b> belum diisi, pilih pada NIS !";		
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
		$kd_pembayaran = buatKode("pembayaran", "PB");
		$mySql	= "INSERT INTO pembayaran SET 
						kd_pembayaran='$kd_pembayaran', 
						tgl_bayar='".InggrisTgl($txtTanggal)."', 
						no_induk='$no_induk',
						nama_siswa='$nama_siswa',
						kelas='$kelas',
						kd_petugas='".$_SESSION['SES_LOGIN']."'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		# …LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT * FROM tmp_pembayaran ORDER BY kode_jenis";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kode_jenis'];
			$dataPeriode	= $tmpData['periode_thn'];
			$dataJenis	= $tmpData['jns_bayar'];
			$dataBiaya	= $tmpData['biaya'];
			$dataBayar	= $tmpData['uang_bayar'];
			$dataKet	= $tmpData['ket'];
			$dataI	= $tmpData['no_induk'];
			$dataNm	= $tmpData['nama_siswa'];
			$dataK	= $tmpData['kelas'];
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO pembayaran_item SET 
			                        kd_pembayaran='$kd_pembayaran',
									kode_jenis='$dataKode',
									no_induk='$dataI', 
									nama_siswa='$dataNm', 
									kelas='$dataK',  
									jns_bayar='$dataJenis',
									periode_thn='$dataPeriode', 
									biaya='$dataBiaya',
									uang_bayar='$dataBayar', 
									ket='$dataKet'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql1 = "INSERT INTO harian SET 
			                        kd_pembayaran='$kd_pembayaran',
			                        periode_thn='$dataPeriode',
									no_induk='$dataI', 
									nama_siswa='$dataNm', 
									kelas='$dataK',  
									kode_jenis='$dataKode',
									jns_bayar='$dataJenis',
									biaya='$dataBiaya',
									uang_bayar1='$dataBayar', 
									ket='$dataKet',
									tgl_bayar='".InggrisTgl($txtTanggal)."', 
									kd_petugas='".$_SESSION['SES_LOGIN']."'";
			mysql_query($itemSql1, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_pembayaran";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		echo "<script>";
		echo "window.open('bayar_nota.php?noNota=$kd_pembayaran', width=12,height=12,left=12, top=25)";
		echo "</script>";
        
		
	}	
}


  // Membaca 
$no_induk= isset($_GET['no_induk']) ?  $_GET['no_induk'] : '';
$mySql	= "SELECT no_induk, nama_siswa, kelas FROM siswa WHERE no_induk='$no_induk'";
$myQry	= mysql_query($mySql)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);
$dataNama		= $myData['nama_siswa'];
$dataKelas		= $myData['kelas'];

# Kode
if($no_induk=="") {
	$no_induk= isset($_POST['no_induk']) ? $_POST['no_induk'] : '';
}


	


# TAMPILKAN DATA KE FORM
$kd_pembayaran = buatKode("pembayaran", "PB");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataPeriode	= isset($_POST['periode_thn']) ? $_POST['periode_thn'] : '';
$dataBiaya   	= isset($_POST['txtBiaya']) ? $_POST['txtBiaya'] : '';
$dataUang_bayar	= isset($_POST['txtUang_bayar']) ? $_POST['txtUang_bayar'] : '';
$dataKode_jenis	= isset($_POST['txtKode_jenis']) ? $_POST['txtKode_jenis'] : '';
$dataKet	= isset($_POST['txtKet']) ? $_POST['txtKet'] : '';

?>

<!doctype html>
  
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Autocomplete dari database dengan jQuery dan PHP  </title>
	
    <link rel="stylesheet"
    href="js/jquery-ui.css" />
    <script src="js/jquery-1.8.3.js"></script>
    <script src="js/jquery-ui.js"></script>
 
    <script>
/*autocomplete muncul setelah user mengetikan minimal2 karakter */
    $(function() {  
        $( "#anime" ).autocomplete({
         source: "data.php",  
           minLength:2, 
        });
    });
    </script>
         <link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
    
</head>


<body>
   
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
   
  <table class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3"><h1>TAMBAH DATA PEMBAYARAN</h1></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCCCCC"><strong>DATA PEMBAYARAN </strong></td>
      <td width="68%">&nbsp;</td>
    </tr>
    <tr>
      <td width="30%"><strong>Kode Pembayaran </strong></td>
      <td width="2%"><strong>:</strong></td>
      <td><input name="txtNomor" value="<?php echo $kd_pembayaran; ?>" size="23" maxlength="20" readonly/></td>
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
      <td><strong>NIS</strong></td>
      <td><strong>:</strong></td>
      <td><input name="no_induk" value="<?php echo $no_induk; ?>" size="13" maxlength="13"   type="text" />
        <a href="?page=cari_siswa"  target="_self">Cari NIS Siswa </a></td>
    </tr>
    <tr>
      <td><strong>Nama Siswa</strong></td>
      <td><strong>:</strong></td>
      <td><input name="nama_siswa" value="<?php echo $dataNama; ?>" size="40" maxlength="40" readonly /></td>
    </tr>
    <tr>
      <td><strong>Kelas</strong></td>
      <td><strong>:</strong></td>
      <td><input name="kelas" value="<?php echo $dataKelas; ?>" size="40" maxlength="40" readonly /></td>
    </tr>
    <tr>
      <td colspan="2"bgcolor="#CCCCCC"><strong>INPUT PEMBAYARAN</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Periode Bulan &amp; Tahun</strong></td>
      <td><strong>:</strong></td>
      <td><input name="tgl" value="<?php echo date("d");?>" size="5" maxlength="40"  />
        <input name="bln" value="<?php echo date("m");?>" size="5" maxlength="40"  />
        <input name="thn" value="<?php echo date("Y");?>" size="5" maxlength="40"  /></td>
    </tr>
    <tr>
      <td><strong>Jenis Bayar </strong></td>
      <td><strong>:</strong></td>
      <td><p><?php  
mysql_connect("localhost","root","");  
mysql_select_db("tu71");  
$result = mysql_query("select * from jns_bayar");  
$jsArray = "var prdName = new Array();\n";  
echo '<select name="cmbJns_bayar" onchange="changeValue(this.value)"  >';  
echo '<option>---Pilih Satu :---</option>';  
while ($row = mysql_fetch_array($result)) {  
    echo '<option value="' . $row['jns_bayar'] . '">' . $row['jns_bayar'] . '</option>';  
    $jsArray .= "prdName['" . $row['jns_bayar'] . "'] = {name:'" . addslashes($row['kode_jenis']) . "',desc:'".addslashes($row['biaya'])."',des:'".addslashes($row['biaya'])."'};\n";  
}  
echo '</select>';  
?>  </td>
    </tr>
    <tr>
      <td><strong>Biaya (Rp.)</strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input type="text" name="txtBiaya"   id="prd_desc"  readonly/>
<script type="text/javascript">  
<?php echo $jsArray; ?>
function changeValue(id){
document.getElementById('prd_name').value = prdName[id].name;
document.getElementById('prd_desc').value = prdName[id].desc;
};
</script><input type="hidden" name="txtKodejenis"   id="prd_name"/>
      </b></td>
    </tr>
    <tr>
      <td><strong>Uang Bayar (Rp.)</strong></td>
      <td><strong>:</strong></td>
      <td><b><input name="txtUang_bayar"  size="40" maxlength="40" id="prd_des" />
       <script type="text/javascript">  
<?php echo $jsArray; ?>
function changeValue(id){
document.getElementById('prd_name').value = prdName[id].name;
document.getElementById('prd_desc').value = prdName[id].desc;
document.getElementById('prd_des').value = prdName[id].des;
};
</script>
      </b></td>
    </tr>
    <tr>
      <td><b>Keterangan</b></td>
      <td><b>:</b></td>
      <td><b>
        <textarea name="txtKet" cols="40" ></textarea>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><b>
        <input name="btnTambah" class="btn btn-primary" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
   
  </table>
  <br>
  <table class="table table-striped table-bordered table-condensed">
    <tr>
      <th colspan="9">DAFTAR JENIS PEMBAYARAN</th>
    </tr>
    <tr>
      <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="143" bgcolor="#CCCCCC"><strong>Periode Bulan &amp; Tahun</strong></td>
      <td width="138" bgcolor="#CCCCCC"><strong>Kode Jenis</strong></td>
      <td width="106" bgcolor="#CCCCCC"><strong>Jenis Pembayaran</strong></td>
      <td width="103" align="right" bgcolor="#CCCCCC"><strong>Biaya (Rp) </strong></td>
      <td width="96" align="right" bgcolor="#CCCCCC"><strong>Uang Bayar (Rp)</strong></td>
      <td width="96" align="right" bgcolor="#CCCCCC"><strong>Subotal(Rp) </strong></td>
      <td width="124" align="right" bgcolor="#CCCCCC"><strong>Ket </strong></td>
      <td width="45" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
<?php
// deklarasi variabel
$hargaDiskon= 0; 
$totalBayar	= 0; 
$jumlahbarang	= 0;
$totalBiaya	= 0;


// Qury menampilkan data dalam Grid TMP_Penjualan 
$tmpSql ="SELECT  * FROM tmp_pembayaran  ORDER BY kode_jenis ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$subSotal 	= $tmpData['uang_bayar'] - $tmpData['biaya'];
	$totalBayar	= $totalBayar +  $tmpData['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($tmpData['uang_bayar']);
	
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['periode_thn']; ?></td>
      <td><?php echo $tmpData['kode_jenis']; ?></b></td>
      <td><?php echo $tmpData['jns_bayar']; ?></td>
      <td align="right"><?php echo format_angka($tmpData['biaya']); ?></td>
      <td align="right"><?php echo format_angka($tmpData['uang_bayar']); ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td align="right"><?php echo $tmpData['ket']; ?></td>
      <td><a href="?page=hapus_tmp&id=<?php echo $tmpData['id'];?>" target="_self" onClick="return confirm('Apakah anda yakin ingin menghapus data ini ?')">Hapus</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
      <td align="right" bgcolor="#00CCCC"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td align="right" bgcolor="#00FF33"><b><?php echo format_angka($jumlahbarang); ?></b></td>
      <td align="right" bgcolor="#FFA540"><b><?php echo format_angka($totalBiaya); ?></b></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
      <td bgcolor="#F5F5F5"><input name="txtTotBayar" type="hidden" value="<?php echo $totalBayar; ?>" /></td>
    </tr>
  </table>
  
  <table class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC" align="center"><input name="btnSimpan" type="submit"  class="btn btn-warning" style="cursor:pointer;" value="CETAK PEMBAYARAN " /></td>
    </tr>
  </table>
  <div class="col col-lg-5">
    <table width="709"      ">
	 <tr>
      <td colspan="2" ><strong>Ket warna.</strong></td>
      <td width="10"  >&nbsp;</td>
      <td width="608"  >&nbsp;</td>
      </tr>
    <tr>
      <td width="51" rowspan="3">&nbsp;  </td>
      <td width="20" bgcolor="#00CCCC">&nbsp;</td>
      <td>&nbsp;</td>
      <td> Jumlah dari biaya jenis pembayaran</td>
    </tr>
    <tr>
      <td bgcolor="#00FF33">&nbsp;</td>
      <td>&nbsp;</td>
      <td> Jumlah uang yang harus di bayar</td>
    </tr>
    <tr>
      <td bgcolor="#FFA540">&nbsp;</td>
      <td>&nbsp;</td>
      <td>Jumlah tunggakan</td>
    </tr>
  </table>
</div>
</form>
</body>
</html>