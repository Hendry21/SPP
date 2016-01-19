<?php
error_reporting(0);
include "../config/inc.connection.php";

$kode_jenis=$_GET['kode_jenis'];
$qryjenis=mysql_query("select * from jns_bayar where kode_jenis='$kode_jenis'");
$tampil=mysql_fetch_array($qryjenis);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<h2> SUNTING JENIS PEMBAYARAN<br />
  <br />
</h2>
<form id="form1" name="formeditd" method="post" action="updatejenis.php">

<table width="430" align="left" class="table table-striped table-bordered table-condensed">
  <tr>
    <td width="21%"><b>Kode</b></td>
    <td width="2%"><strong>:</strong></td>
    <td width="81%"><input name="kode_jenis" type="text"  required="required" value="<?php echo $tampil['kode_jenis'];?>" readonly="readonly"/></td>
  </tr>
  <tr>
    <td><strong>Jenis Bayar</strong></td>
    <td><strong>:</strong></td>
    <td><input type="text" name="jns_bayar" required="required" size="60" value="<?php echo $tampil['jns_bayar'];?>" /></td>
  </tr>
  <tr>
    <td><b>Biaya</b></td>
    <td><b>:</b></td>
    <td><input type="text" name="biaya" required="required"  value="<?php echo $tampil['biaya'];?>" /></td>
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