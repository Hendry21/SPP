<?php
error_reporting(0);

$ambil = mysql_query("SELECT MAX(kode_jenis) AS kode_jenis FROM jns_bayar");
$tampil1 = mysql_fetch_array($ambil);
$id=$tampil1['kode_jenis'];
$nourut = (int) substr($id, 3, 3);
$nourut++;
$char = "B";
$kode_jenis = $char . sprintf("%03s", $nourut);
?>
<h2> TAMBAH JENIS PEMBAYARAN<br />
  <br />
</h2>
<form action="?page=simpanjenis" method="post" name="ftambah" enctype="multipart/form-data" id="frm">

<table width="430" align="left" class="table table-striped table-bordered table-condensed">
    
    
    <tr>
      <td width="21%"><b>Kode</b></td>
      <td width="2%"><strong>:</strong></td>
      <td width="511"><input  readonly type="text" name="kode_jenis" placeholder="Masukan kode bayar" value="<?php echo $kode_jenis;?>" /></td>
    </tr>
    <tr>
      <td><strong>Jenis Bayar</strong></td>
      <td><strong>:</strong></td>
      <td><input type="text" name="jns_bayar" placeholder="Masukan jenis bayar"/></td>
    </tr>
    <tr>
      <td><b>Biaya</b></td>
      <td><b>:</b></td>
      <td><input type="text" name="biaya"  placeholder="biaya" /></td>
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
       <button input name="fulang" type="reset" class="btn btn-danger"  > <i class="glyphicon glyphicon-refresh"></i>Ulang<br> </button>
        <button input name="batal" type="button" value="Batal" class="btn btn-warning" onClick="javascript:history.back()">
			<i class="glyphicon glyphicon-remove"></i>Batal </button>
      </b></td>
    </tr>
   
  </table>
  </form>