
<?php
error_reporting("E_ALL^E_NOTICE");
if (!defined('BASEPATH')) exit('No direct script access allowed');
//include_once "../library/inc.seslogin.php";
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";
list($thn,$bln,$tgl) = explode('-',$tampil1['$periode_thn']);

// =========================================================================

# TOMBOL TAMBAH (KODE barang) DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca Data dari Form
	 $txtTanggal 	= $_POST['txtTanggal'];
	$periode_thn	= mysql_real_escape_string($_POST['periode_thn']);
	$cmbJns_bayar	= mysql_real_escape_string($_POST['cmbJns_bayar']);
	$txtBiaya	= mysql_real_escape_string($_POST['txtBiaya']);
	$txtUang_bayar	= mysql_real_escape_string($_POST['txtUang_bayar']);
	$txtKodejenis 	= mysql_real_escape_string($_POST['txtKodejenis']);
	$txtKet	= mysql_real_escape_string($_POST['txtKet']);
    $no_induk	= $_POST['no_induk'];
	$nama_siswa	= $_POST['nama_siswa'];
	$kelas	= $_POST['kelas'];
	$txtUang_bayar1	= $_POST['txtUang_bayar1'];
 
$kd_pembayaran	= mysql_real_escape_string($_POST['kd_pembayaran']);

	# Validasi Form
	$pesanError = array();
	
	if (trim($kd_pembayaran)=="") {
		$pesanError[] = "Data <b>Biaya belum di isi</b>, silahkan pilih dari <b>Jenis Pembayaran !</b>";		
	}
	
	
	if (trim($nama_siswa)=="") {
		$pesanError[] = "Data <b>Uang Bayar (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	if(trim($txtUang_bayar)=="") {
		$pesanError[] = "Data <b>Uang Bayar Tunggakan</b> belum diisi  !";		
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
	 
		# SIMPAN KE DATABASE (tmp_penjualan)	
		// Jika Kode ditemukan, masukkan data ke Keranjang (TMP)
		
		{
			
			$tmpSql = "INSERT INTO tmp_hutang (periode_thn, no_induk, nama_siswa, kelas, kode_jenis, jns_bayar, biaya, uang_bayar, uang_bayar1, ket, kd_pembayaran, tgl_bayar, kd_petugas) 
					VALUES ('$periode_thn', '$no_induk', '$nama_siswa', '$kelas', '$txtKodejenis', '$cmbJns_bayar', '$txtBiaya', '$txtUang_bayar', '$txtUang_bayar1', '$txtKet', '$kd_pembayaran', '".InggrisTgl($txtTanggal)."', '".$_SESSION['SES_LOGIN']."')";
		    mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
			
  
			
		 
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
	
		 
		# …LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT * FROM tmp_hutang ORDER BY kode_jenis";
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
			$dataBayar1	= $tmpData['uang_bayar1'];
			 
			$dataK1	= $tmpData['kd_pembayaran'];
			$dataK2	= $tmpData['tgl_bayar'];
			$dataK3	= $tmpData['kd_petugas'];
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "UPDATE pembayaran_item SET 
			                        kd_pembayaran='$dataK1',
									kode_jenis='$dataKode',
									no_induk='$dataI', 
									nama_siswa='$dataNm', 
									kelas='$dataK',  
									jns_bayar='$dataJenis',
									periode_thn='$dataPeriode', 
									biaya='$dataBiaya',
									uang_bayar='$dataBayar', 
									ket='$dataKet'  
									WHERE kd_pembayaran='$dataK1'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			$itemSql = "UPDATE pembayaran SET 
			                        kd_pembayaran='$dataK1',
									tgl_bayar='$dataK2',
									no_induk='$dataI', 
									nama_siswa='$dataNm', 
									kelas='$dataK',  
									kd_petugas='$dataK3'
									WHERE kd_pembayaran='$dataK1'";									 ;
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			$itemSql1 = "INSERT INTO harian SET 
			                        kd_pembayaran='$dataK1',
			                        periode_thn='$dataPeriode',
									no_induk='$dataI', 
									nama_siswa='$dataNm', 
									kelas='$dataK',  
									kode_jenis='$dataKode',
									jns_bayar='$dataJenis',
									biaya='$dataBiaya',
									uang_bayar='$dataBayar', 
									uang_bayar1='$dataBayar1', 
									ket='$dataKet',
									tgl_bayar='$dataK2', 
									kd_petugas='$dataK3'";
			mysql_query($itemSql1, $koneksidb) or die ("Gagal Query ".mysql_error());
		# Kosongkan Tmp jika datanya sudah dipindah
		 $hapusSql = "DELETE FROM tmp_hutang";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		echo "<script>";
		echo "window.open('bayar_nota.php?noNota=$dataK1', width=12,height=12,left=12, top=25)";
		echo "</script>";
        
		
	}	
}	
 


  // Membaca 
$kode_jenis= isset($_GET['kode_jenis']) ?  $_GET['kode_jenis'] : '';
$mySql	= "SELECT * FROM pembayaran_item WHERE kode_jenis='$kode_jenis'";
$myQry	= mysql_query($mySql)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

# Kode
if($kode_jenis=="") {
	$kode_jenis= isset($_POST['kode_jenis']) ? $_POST['kode_jenis'] : '';
}


	


# TAMPILKAN DATA KE FORM
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataPeriode	= isset($_POST['periode_thn']) ? $_POST['periode_thn'] : '';
$dataBiaya   	= isset($_POST['txtBiaya']) ? $_POST['txtBiaya'] : '';
$dataUang_bayar	= isset($_POST['txtUang_bayar']) ? $_POST['txtUang_bayar'] : '';
$dataKode_jenis	= isset($_POST['txtKode_jenis']) ? $_POST['txtKode_jenis'] : '';
$dataKet	= isset($_POST['txtKet']) ? $_POST['txtKet'] : '';
$kd_pembayaran	= isset($_POST['kd_pembayaran']) ? $_POST['kd_pembayaran'] : '';

 


if(isset($_GET['noNota'])){
	// Membaca nomor penjualan dari URL
	$noNota = @mysql_real_escape_string($_GET['noNota']);
	// Skrip untuk pembaca data dari database
	$mySql = "SELECT pembayaran.*, admin.nm_petugas FROM pembayaran
				LEFT JOIN admin ON pembayaran.kd_petugas=admin.kd_petugas 
				WHERE kd_pembayaran='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData = mysql_fetch_array($myQry);

$dataNama		= $kolomData['nama_siswa'];
$dataKelas		= $kolomData['kelas'];
$no_induk		= $kolomData['no_induk'];
$kd_pembayaran  = $kolomData['kd_pembayaran'];
$periode_thn = $myData['thn']."-".$myData['bln']."-".$myData['tgl'];
$cmbJns_bayar		= $kolomData['jns_bayar'];
$biaya		= $kolomData['biaya'];
$uang_bayar		= $kolomData['uang_bayar'];

$ket		= $kolomData['ket'];

}

else  {

	if(isset($_GET['Edit'])){
	// Membaca nomor penjualan dari URL
	$Edit = @mysql_real_escape_string($_GET['Edit']);
	// Skrip untuk pembaca data dari database
	$mySql = "SELECT * from pembayaran_item
				WHERE kode_jenis='$Edit'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData = mysql_fetch_array($myQry);

$dataNama		= $kolomData['nama_siswa'];
$dataKelas		= $kolomData['kelas'];
$no_induk		= $kolomData['no_induk'];
$kd_pembayaran  = $kolomData['kd_pembayaran'];
$periode_thn = $myData['thn']."-".$myData['bln']."-".$myData['tgl'];
$cmbJns_bayar		= $kolomData['jns_bayar'];
$biaya		= $kolomData['biaya'];
$uang_bayar		= $kolomData['uang_bayar'];

$ket		= $kolomData['ket'];

}
else
{
	echo "Nomor Nota (noNota) tidak ditemukan";
	exit;
}}
?>
 
<?php 
$pag = "SELECT * FROM pembayaran_item  " ;
$pag1 = "SELECT * FROM  tmp_hutang WHERE kd_pembayaran='$noNota'" ;
 
$pageQ1  = mysql_query($pag) or die ("error paging: ".mysql_error());
$pageQ2  = mysql_query($pag1) or die ("error paging: ".mysql_error());

$jmlh	 = mysql_num_rows($pageQ);

	while ($jmlh1 = mysql_fetch_array($pageQ1))
	
	 {
		 
		 $totalBayar	=  $jmlh1['biaya'];
		$sub	=   $jmlh1['uang_bayar'];
		
		$htg1	=  $htg - $totalBayar ;
	while ($jmlh2 = mysql_fetch_array($pageQ2))	
	 {
		$htg	= $sub + $Sotal  ;
		$Sotal	=  $jmlh2['uang_bayar1'];
		
		}}		
 ?>
<!doctype html>
  
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Autocomplete dari database dengan jQuery dan PHP  </title>
	
   
    <script type="text/javascript">function startCalc(){interval=setInterval("calc()",1)}function calc(){one=document.autoSumForm.firstBox.value;two=document.autoSumForm.txtUang_bayar1.value;document.autoSumForm.txtUang_bayar.value=(one*1)+(two*1)}function stopCalc(){clearInterval(interval)}</script>
         <link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
    
</head>


<body>
   
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="autoSumForm" target="_self">
   
  <table class="table table-striped table-bordered table-condensed">
    <tr>
      <td colspan="3"><h1> DATA PEMBAYARAN TUNGGAKAN</h1></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCCCCC"><strong>DATA PEMBAYARAN </strong></td>
      <td width="68%">&nbsp;</td>
    </tr>
    <tr>
      <td width="30%"><strong>Kode Pembayaran </strong></td>
      <td width="2%"><strong>:</strong></td>
      <td><input name="kd_pembayaran" value="<?php echo $kd_pembayaran; ?>" size="23" maxlength="20" readonly/></td>
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
      <td colspan="2" bgcolor="#CCCCCC"><strong>DATA  SISWA </strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>NIS</strong></td>
      <td><strong>:</strong></td>
      <td><input name="no_induk" value="<?php echo $no_induk; ?>" size="13" maxlength="13"   type="text" readonly   />
      </td>
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
      <td><strong>Jenis Bayar </strong></td>
      <td><strong>:</strong></td>
      <td><p>
        <?php  
mysql_connect("localhost","root","");  
mysql_select_db("tu71");  
$result = mysql_query("SELECT * from pembayaran_item
				WHERE kd_pembayaran='$noNota'");  
$jsArray = "var prdName = new Array();\n";  
echo '<select name="cmbJns_bayar" onchange="changeValue(this.value)"  >';  
echo '<option>---Pilih Satu :---</option>';  
while ($row = mysql_fetch_array($result)) {  
    echo '<option value="' . $row['jns_bayar'] . '">' . $row['jns_bayar'] . '</option>';  
    $jsArray .= "prdName['" . $row['jns_bayar'] . "'] = {name:'" . addslashes($row['kode_jenis']) . "',desc:'".addslashes($row['biaya'])."',des:'".addslashes($row['uang_bayar'])."',des1:'".addslashes($row['ket'])."',des2:'".addslashes($row['periode_thn'])."'};\n";  
}  
echo '</select>';  
?>
      </td>
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
    </script>
        <input type="hidden" name="txtKodejenis"   id="prd_name"/>
      </b></td>
    </tr>
    <tr>
      <td><strong>Uang Bayar (Rp.)</strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input readonly id="prd_des" type=text name="firstBox" value="" onFocus="startCalc();" onBlur="stopCalc();">
+
<script type="text/javascript">  
<?php echo $jsArray; ?>
function changeValue(id){
document.getElementById('prd_name').value = prdName[id].name;
document.getElementById('prd_desc').value = prdName[id].desc;
document.getElementById('prd_des').value = prdName[id].des;
};
    </script>
<input type=text name="txtUang_bayar1" value="" onFocus="startCalc();" onBlur="stopCalc();" placeholder="Uang Bayar Tunggakan">
=
<input name="txtUang_bayar"   readonly  placeholder="Hasil" />
      </b></td>
    </tr>
    <tr>
      <td><b>Keterangan</b></td>
      <td><b>:</b></td>
      <td><b>
        <textarea name="txtKet" cols="40" id="prd_des1" ></textarea>
        <script type="text/javascript">  
<?php echo $jsArray; ?>
function changeValue(id){
document.getElementById('prd_name').value = prdName[id].name;
document.getElementById('prd_desc').value = prdName[id].desc;
document.getElementById('prd_des').value = prdName[id].des;
document.getElementById('prd_des1').value = prdName[id].des1;
    
};
    </script>
      </b></td>
    </tr>
      <tr>
      <td><strong>Periode Bulan &amp; Tahun</strong></td>
      <td><b>:</b></td>
      <td><b>
        <input type="text" name="periode_thn" cols="40" id="prd_des2"   >
        <script type="text/javascript">  
<?php echo $jsArray; ?>
function changeValue(id){
document.getElementById('prd_name').value = prdName[id].name;
document.getElementById('prd_desc').value = prdName[id].desc;
document.getElementById('prd_des').value = prdName[id].des;
document.getElementById('prd_des1').value = prdName[id].des1;
document.getElementById('prd_des2').value = prdName[id].des2;    
};
    </script>
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
  <br>
  <table class="table table-striped table-bordered table-condensed">
    <tr>
      <th colspan="10">DAFTAR JENIS PEMBAYARAN</th>
    </tr>
    <tr>
      <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="143" bgcolor="#CCCCCC"><strong>Tanggal Bayar</strong></td>
      <td width="143" bgcolor="#CCCCCC"><strong>Periode Bulan &amp; Tahun</strong></td>
      <td width="138" bgcolor="#CCCCCC"><strong>Kode Jenis</strong></td>
      <td colspan="3" bgcolor="#CCCCCC"><strong>Jenis Pembayaran</strong><strong>  </strong></td>
      <td width="96" align="right" bgcolor="#CCCCCC"><strong>Uang Bayar (Rp)</strong></td>
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
$tmpSql ="SELECT  * FROM tmp_hutang  ORDER BY kode_jenis ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	 
	$nomor++;
	$subSotal 	= $tmpData['uang_bayar'] ;
	$totalBayar	=  $tmpData['biaya'];
	$totalBiaya	= $totalBayar -  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($tmpData['uang_bayar']);
	 
	
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo IndonesiaTgl($tmpData['tgl_bayar']); ?></td>
      <td><?php echo IndonesiaTgl($tmpData['periode_thn']); ?></td>
      <td><?php echo $tmpData['kode_jenis']; ?></b></td>
      <td colspan="3"><?php echo $tmpData['jns_bayar']; ?> </td>
      <td align="right"><?php echo format_angka($tmpData['uang_bayar1']); ?></td>
      <td align="right"><?php echo $tmpData['ket']; ?></td>
      <td><a href="?page=hapus_tmp1&id=<?php echo $tmpData['id'];?>" target="_self" onClick="return confirm('Apakah anda yakin ingin menghapus data ini ?')">Hapus</a> / 
      <a href="bayar_nota1.php?id=<?php echo $tmpData['id'];?>" target="_blank"  >Cetak</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL : </strong></td>
      <td width="106" align="right" bgcolor="#00CCCC"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td width="103" align="right" bgcolor="#00FF33"><b><?php echo format_angka($subSotal); ?></b></td>
      <td width="96" align="right" bgcolor="#FFA540"><b><?php echo format_angka($totalBiaya); ?></b></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
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
      <td> Jumlah uang  bayar</td>
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