<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(0);
 
$query = "select * from jns_bayar";
$sql1 = mysql_query($query);
$nomor = 0;


$tanggal= date("d-m-y");
?>
<style type="text/css">
.main-content .table.table-striped.table-bordered.table-condensed tr th {
	text-align: left;
}
</style>

<h2> DATA JENIS PEMBAYARAN<br />
  <br />
</h2>
<div class="main-content">
<div class="btn-toolbar list-toolbar">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%"> <a href="?page=tambahjenis">
    <button class="btn btn-primary"  >
<i class="fa fa-plus"></i> Tambah Jenis Pembayaran</button>
    </a>  <a href="?page=jns_bayar">
    <button class="btn btn-warning"  >
<i class="fa fa-refresh"></i> Segarkan Data</button>
    </a>  </td>
    <td width="47%" align="right"> <form class="form-inline" method="post" style="margin-top:0px; "  action="?page=jns_bayar">
                    <input class="input-xlarge form-control" placeholder="Cari Jenis Bayar..." id="appendedInputButton" name="search" type="text">
                    <button class="btn btn-default" name="submit" type="submit "><i class="fa fa-search"></i> Cari</button>
                </form></td>
  </tr>
</table>

  
          
      <div class="btn-group">
 
                
</div></div>
<table width="1068" class="table table-striped table-bordered table-condensed" id="example1">
  <tr>
    <th width="27" align="center" bgcolor="#CCCCCC">No</th>
    <th width="265" align="center" bgcolor="#CCCCCC">Kode Bayar</th>
    <th width="375" align="right" bgcolor="#CCCCCC">Jenis Bayar</th>
    <th width="228" align="right" bgcolor="#CCCCCC">Biaya</th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Alat</strong></td>
  </tr>
 <?php
	  if ((isset($_POST['submit'])) AND ($_POST['search'] <> ""))
{
	$search = $_POST['search'];
	$sql1 = mysql_query("SELECT * FROM jns_bayar WHERE jns_bayar LIKE '%$search%'") or die(mysql_error());
	}
	
	{
	$no=0;
	   while ($data = mysql_fetch_array($sql1)){
	  $nomor++;
		$total = mysql_num_rows($sql1);
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;

$row = 20;
$max= ceil($total/$row);
		 ?>
  <tr>
    <td ><?php echo $nomor; ?></td>
    <td><?php echo $data['kode_jenis'];?></td>
    <td align="left"><?php echo $data['jns_bayar'];?></td>
    <td><?php echo format_angka($data['biaya']);?></td>
    <td width="75" align="center"><a href="?page=editjenis&kode_jenis=<?php echo $data ['kode_jenis']; ?>" target="_self" alt="Edit Data"></a><a href="?page=editjenis&kode_jenis=<?php echo $data ['kode_jenis']; ?>"><i class="fa fa-edit"></i> Ubah</a></td>
    <td width="70" align="center"> <a href="?page=hapus_jenis&kode_jenis=<?php echo $data['kode_jenis'];?>" onClick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"role="button" data-toggle="modal"><i class="fa fa-trash-o"></i> Hapus</a></td>
   
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4"><strong>Jumlah Data :</strong><?php echo $total; ?></td>
    <td colspan="2" align="right"><strong>Halaman ke :</strong>
      <?php for ($h = 1; $h <= $max; $h++) 
 { $list[$h] = $row * $h - $row; echo "<a href='?page=jns_bayar&hal=$list[$h]'>$h</a> ";
}
   
 }?></td>
  </tr>
   
</table>
</div>
<div class="modal small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Konfirmasi Penghapusan</h3>
        </div>


        <div class="modal-body">
          <p class="error-text"><i class="fa fa-warning modal-icon"></i>Apakah anda yakin akan menghapus data ini ??
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
            <button class="btn btn-danger" data-dismiss="modal">Hapus</button>
        </div>
    </div>
  </div>
</div>

