<?php
error_reporting(0);
include "../config/inc.connection.php";

$no_induk=$_GET['no_induk'];
$qryjenis=mysql_query("select * from siswa where no_induk='$no_induk'");
$tampil=mysql_fetch_array($qryjenis);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<h2> SUNTING SISWA<br />
  <br />
</h2>
<form id="form1" name="formeditd" method="post" action="updatesiswa.php">

<table width="430" align="left" class="table table-striped table-bordered table-condensed">
  <tr>
    <td width="21%"><b>No Induk</b></td>
    <td width="2%"><strong>:</strong></td>
    <td width="81%"><input type="text" name="no_induk" required="required" value="<?php echo $tampil['no_induk'];?>" /></td>
  </tr>
  <tr>
    <td><strong>NISN</strong></td>
    <td><strong>:</strong></td>
    <td><input type="text" name="nisn" required="required" value="<?php echo $tampil['nisn'];?>" /></td>
  </tr>
  <tr>
    <td><b>Nama Siswa</b></td>
    <td><b>:</b></td>
    <td><input type="text" name="nama_siswa" required="required"  value="<?php echo $tampil['nama_siswa'];?>" /></td>
  </tr>
   <tr>
      <td><strong>Tempat, Tanggal Lahir</strong></td>
      <td><strong>:</strong></td>
      <td><input type="text"  name="tmpt_lahir" required="required"  value="<?php echo $tampil['tmpt_lahir'];?>" />
        .
          <input type="text" name="tgl_lahir" required="required"  value="<?php echo $tampil['tgl_lahir'];?>" /></td>
    </tr>
	  <tr>
                   <td height="32">Jenis Kelamin</td>
         <td><strong>:</strong></td>
            <td><select name="jk" size="1">
      <option value="<?php echo $tampil['jk'];?>" selected="selected"><?php echo $tampil['jk'];?></option>
              <option value="laki-laki">Laki - Laki</option>
              <option value="perempuan">Perempuan</option>
            </select></td>
          </tr>
		   <tr> 
            <td><strong>Alamat</strong></td>
    <td><strong>:</strong></td>
      <td><span class="td1">
        <textarea name="alamat" cols="30" rows="3" style="font-size:12px; font-family:'Courier New', Courier, monospace; resize:none;"><?php echo $tampil['alamat'];?></textarea>
        </span></td></tr>
		<tr>
                   <td height="32">Kelas</td>
         <td><strong>:</strong></td>
            <td><select name="kelas" size="1">
      <option value="<?php echo $tampil['kelas'];?>" selected="selected"><?php echo $tampil['kelas'];?></option>
		<option value="KOSONG">Pilih Satu :</option>
				<option value="X RPL ">X RPL </option>
              <option value="X RPL 1">X RPL 1</option>
              <option value="X RPL 2">X RPL 2</option>
              <option value="X TKR 1">X TKR 1</option>
              <option value="X TKR 2">X TKR 2</option>
              <option value="X TKR 3">X TKR 3</option>
              <option value="X TSM 1">X TSM 1</option>
              <option value="X TSM 2">X TSM 2</option>
              <option value="X TSM 3">X TSM 3</option>
              <option value="X TITL">X TITL </option>
              <option value="XI TITL">XI TITL </option>
              <option value="XII TITL">XII TITL </option>
	    
            </select></td>
    </tr>
	 <tr>
      <td><strong>Jurusan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="nm_jurusan"  >
	        <option value="<?php echo $tampil['nm_jurusan'];?>" selected="selected"><?php echo $tampil['nm_jurusan'];?></option>
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
	   <option value="<?php echo $tampil['prog_keahlian'];?>" selected="selected"><?php echo $tampil['prog_keahlian'];?></option>
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
	   	   <option value="<?php echo $tampil['agama'];?>" selected="selected"><?php echo $tampil['agama'];?></option>
             <option value="KOSONG">Pilih Satu :</option>
              <option value="Islam">Islam</option>
              <option value="Kristen">Kristen</option>
            </select>
     </td>
    </tr>
	  <tr>
      <td><b>No HP</b></td>
      <td><b>:</b></td>
       <td><input type="text" name="no_hp" required="required"  value="<?php echo $tampil['no_hp'];?>" /></td>
</td>
    </tr>
	 <tr>
      <td><b>Nama Wali</b></td>
      <td><b>:</b></td>
	          <td><input type="text" name="nm_wali" required="required"  value="<?php echo $tampil['nm_wali'];?>" /></td>
			   <tr>
      <td><b>Nama Bapak Siswa</b></td>
      <td><b>:</b></td>
<td><input type="text" name="nm_bpk" required="required"  value="<?php echo $tampil['nm_bpk'];?>" /></td>
    </tr>
    <tr>
      <td><b>Nama Ibu Siswa</b></td>
      <td><b>:</b></td>

       <td><input type="text" name="nm_ibu" required="required"  value="<?php echo $tampil['nm_ibu'];?>" /></td>

    </tr>
    <tr>
      <td><b>No HP Bapak Siswa</b></td>
      <td><b>:</b></td>

           <td><input type="text" name="no_hp_bpk" required="required"  value="<?php echo $tampil['no_hp_bpk'];?>" /></td>
 
    </tr>
    <tr>
      <td><b>No HP Ibu Siswa</b></td>
      <td><b>:</b></td>

          <td><input type="text" name="no_hp_ibu" required="required"  value="<?php echo $tampil['no_hp_ibu'];?>" /></td>

    </tr>
</td>
    </tr>
	 <tr>
      <td><b>Tahun Ajaran</b></td>
      <td><b>:</b></td>
	           <td><input type="text" name="thn_ajaran" required="required"  value="<?php echo $tampil['thn_ajaran'];?>" /></td>
     </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b>
      <button class="btn btn-primary" name="btnSimpan" type="submit"   ><i class="fa fa-edit"></i> Ubah</button>  <button input="input" name="batal" type="button" value="BATAL" class="btn btn-warning" onclick="javascript:history.back()"> <i class="glyphicon glyphicon-remove"></i>Batal </button>
    </b></td>
  </tr>
</table>
</form>