


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
     <link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
    
</head>


<body>
   
        <h1>TAMBAH DATA SISWA KELAS X</h1>
     
<?php
error_reporting(0);
if (!defined('BASEPATH')) exit('No direct script access allowed');


# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Data Form
	$no_induk		= mysql_real_escape_string($_POST['no_induk']);
	$nisn	= mysql_real_escape_string($_POST['nisn']);
	$nama_siswa	= mysql_real_escape_string($_POST['nama_siswa']);
	$tmpt_lahir		= mysql_real_escape_string($_POST['tmpt_lahir']);
	$tgl_lahir	= mysql_real_escape_string($_POST['tgl_lahir']);
	$alamat		= mysql_real_escape_string($_POST['alamat']);
	$no_hp		= mysql_real_escape_string($_POST['no_hp']);
	$nm_wali		= mysql_real_escape_string($_POST['nm_wali']);
	$thn_ajaran		= mysql_real_escape_string($_POST['thn_ajaran']);
	$agama		= mysql_real_escape_string($_POST['agama']);
	$kelas		= mysql_real_escape_string($_POST['kelas']);
	$nm_jurusan		= mysql_real_escape_string($_POST['nm_jurusan']);
	$prog_keahlian		= mysql_real_escape_string($_POST['prog_keahlian']);
	$jk		= mysql_real_escape_string($_POST['jk']);
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($no_induk)=="") {
		$pesanError[] = "Data <b>No Induk Siswa</b> tidak boleh kosong !";		
	}
	if (trim($nisn)=="") {
		$pesanError[] = "Data <b>NISN Siswa</b> tidak boleh kosong!";		
	}
	if (trim($nama_siswa)=="") {
		$pesanError[] = "Data <b>Nama Siswa</b> tidak boleh kosong!";		
	}
	if (trim($tmpt_lahir)=="") {
		$pesanError[] = "Data <b>Tempat Lahir Siswa</b> tidak boleh kosong!";		
	}
	if (trim($dataTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Lahir Siswa</b> tidak boleh kosong!";		
	}
	if (trim($alamat)=="") {
		$pesanError[] = "Data <b>Alamat Siswa</b> tidak boleh kosong!";		
	}
	if (trim($no_hp)=="") {
		$pesanError[] = "Data <b>No.HP Siswa</b> tidak boleh kosong!";		
	}
	if (trim($nm_wali)=="") {
		$pesanError[] = "Data <b>Nama Wali Siswa</b> tidak boleh kosong!";		
	}
	if (trim($thn_ajaran)=="") {
		$pesanError[] = "Data <b>Tahun Ajaran</b> tidak boleh kosong!";		
	}
	
	if (trim($agama)=="KOSONG") {
		$pesanError[] = "Data <b>Agama</b> belum ada yang dipilih !";		
	}
	if (trim($kelas)=="KOSONG") {
		$pesanError[] = "Data <b>Kelas Siswa</b> tidak boleh kosong !";		
	}
	if (trim($nm_jurusan)=="KOSONG") {
		$pesanError[] = "Data <b>Jurusan Siswa</b> belum ada yang dipilih !";		
	}
	if (trim($prog_keahlian)=="KOSONG") {
		$pesanError[] = "Data <b>Prog. Keahlian Siswa</b> belum ada yang dipilih !";		
	}
	if (trim($jk)=="KOSONG") {
		$pesanError[] = "Data <b>Jenis Kelamin Siswa</b> belum ada yang dipilih !";		
	}
	$cekdata="select no_induk from siswa where no_induk='$no_induk'";
	$ada=mysql_query($cekdata) or die(mysql_error());
	if(mysql_num_rows($ada)>0){
				$pesanError[] = "Data <b>No Induk Siswa Sudah Ada !</b> belum ada yang dipilih !";		
	}
    $cekdata="select nisn from siswa where nisn='$nisn'";
	$ada=mysql_query($cekdata) or die(mysql_error());
	if(mysql_num_rows($ada)>0){
				$pesanError[] = "Data <b>NISN Siswa Sudah Ada !</b> belum ada yang dipilih !";		
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
	else {
		# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
		
		$mySql	= "INSERT INTO siswa (no_induk, nisn, nama_siswa, tmpt_lahir, tgl_lahir,  alamat, kelas,  nm_jurusan, jk, no_hp, nm_wali, thn_ajaran, prog_keahlian, agama) 
						VALUES ('$no_induk',
								'$nisn',
								'$nama_siswa',
								'$tmpt_lahir',
								'$tgl_lahir',
								'$alamat',
								'$kelas',
								'$nm_jurusan',
								'$jk',
								'$no_hp',
								'$nm_wali',
								'$thn_ajaran',
								'$prog_keahlian',
								'$agama')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<script>alert('Data Siswa Berhasil di simpan')</script>";
			echo "<meta http-equiv='refresh' content='0; url=?page=data_siswa1'>";
		}
		exit;
	}
} // Penutup POST
	
	
# VARIABEL DATA UNTUK DIBACA FORM

$dataTanggal 	= isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : date('Y-m-d');
?>


<!-- Modal Dialog Contact -->
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"    >
  <table width="430" align="left" class="table table-striped table-bordered table-condensed">
    
    
    <tr>
      <td width="21%"><strong>No Induk </strong></td>
      <td width="2%"><strong>:</strong></td>
      <td width="77%"><b>
        <input name="no_induk" type="text"  size="40" maxlength="40"  />
      </b></td>
    </tr>
    <tr>
      <td><strong>NISN </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input name="nisn" type="text" size="40" maxlength="40"  />
      </b></td>
    </tr>
    <tr>
      <td><strong>Nama Siswa</strong></td>
      <td><b>:</b></td>
      <td><b>
        <input name="nama_siswa" type="text" size="40" maxlength="40"  />
      </b></td>
    </tr>
    <tr>
      <td><strong>Tempat, Tanggal Lahir</strong></td>
      <td><strong>:</strong></td>
      <td><input name="tmpt_lahir"  size="23" type="text" maxlength="20" />
        .
          <input name="tgl_lahir" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="20" maxlength="20" /></td>
    </tr>
	<tr>
	  <td><strong>Jenis Kelamin</strong></td>
	  <td><b>:</b></td>
	  <td>
            
            <select name="jk"  >
             <option value="KOSONG">Pilih Satu :</option>
              <option value="Laki-Laki">Laki-Laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
         </td>
    </tr>
	<tr>
      <td><strong>Alamat</strong></td>
      <td><strong>:</strong></td>
      <td><textarea name="alamat"   cols="50"></textarea></td>
    </tr>
    <tr>
      <td><strong>Kelas</strong></td>
      <td>&nbsp;</td>
      <td> <select name="kelas"  >
             <option value="KOSONG">Pilih Satu :</option>
             
              <option value="XII RPL 1">XII RPL 1</option>
              <option value="XII RPL 2">XII RPL 2</option>
              <option value="XII TKR 1">XII TKR 1</option>
              <option value="XII TKR 2">XII TKR 2</option>
              <option value="XII TKR 3">XII TKR 3</option>
              <option value="XII TSM 1">XII TSM 1</option>
              <option value="XII TSM 2">XII TSM 2</option>
              <option value="XII TSM 3">XII TSM 3</option>
              <option value="XII TITL 1">XII TITL 1</option>
              <option value="XII TITL 1">XII TITL 1</option>
              <option value="XII TITL 2">XII TITL 2</option>
              <option value="XII TITL 3">XII TITL 3</option>
              
             
            </select></td>
    </tr>
    <tr>
      <td><strong>Jurusan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="nm_jurusan"  >
             <option value="KOSONG">Pilih Satu :</option>
              <option value="Teknik Kendaraan Ringan (TKR)">Teknik Kendaraan Ringan (TKR)</option>
              <option value="Teknik Sepeda Motor (TSM)">Teknik Sepeda Motor (TSM)</option>
              <option value="Teknik Instalasi Tenaga Listrik (TITL)">Teknik Instalasi Tenaga Listrik (TITL)</option>
              <option value="Teknik Rekayasa Perangkat Lunak (RPL)">Teknik Rekayasa Perangkat Lunak (RPL)</option>
            </select></td>
    </tr>
    <tr>
      <td><strong>Prog. Keahlian</strong></td>
      <td><strong>:</strong></td>
      <td> <select name="prog_keahlian"  >
             <option value="KOSONG">Pilih Satu :</option>
              <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
              <option value="Teknik Sepeda Motor">Teknik Sepeda Motor</option>
              <option value="Teknik Instalasi Pemanfaatan Tenaga Listrik">Teknik Instalasi Pemanfaatan Tenaga Listrik</option>
              <option value="Teknik Komputer dan Informatika">Teknik Komputer dan Informatika</option>
            </select></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td><b>:</b></td>
      <td>
       <select name="agama"  >
             <option value="KOSONG">Pilih Satu :</option>
              <option value="Islam">Islam</option>
              <option value="Kristen">Kristen</option>
            </select>
     </td>
    </tr>
    <tr>
      <td><b>No HP</b></td>
      <td><b>:</b></td>
      <td><b>
        <input name="no_hp" type="text" size="40" maxlength="40"  />
      </b></td>
    </tr>
    <tr>
      <td><b>Nama Wali</b></td>
      <td><b>:</b></td>
      <td><b>
        <input name="nm_wali" type="text" size="40" maxlength="40"  />
        </b></td>
    </tr>
    <tr>
      <td><b>Tahun Ajaran</b></td>
      <td><b>:</b></td>
      <td><b>
        <input name="thn_ajaran"  type="text" size="40" maxlength="40"  value="<?php echo date("Y") ?>" />
        </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><b>
      <button class="btn btn-primary" name="btnSimpan" type="submit"   ><i class="fa fa-save"></i> Simpan</button>
      </b></td>
    </tr>
   
  </table>
  
<br>
</form>
</div>
</div>
  </div>
</div>

</body>

</html>