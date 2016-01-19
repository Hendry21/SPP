<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(0);
$row 	= 100000000;
$hal 	= isset($_GET['hal']) ? mysql_real_escape_string($_GET['hal']) : 0;
$pageSql 	= "SELECT * FROM  pembayaran";
$sql1 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$total	= mysql_num_rows($sql1);
$max	= ceil($jumData/$barisData);

 
$tanggal= date("d-m-y");
?>
<style type="text/css">
.main-content .table.table-striped.table-bordered.table-condensed tr th {
	text-align: left;
}
</style>

<h2> DATA PEMBAYARAN TUNGGAKAN<br />
  <br />
</h2>
<div class="main-content">
<div class="btn-toolbar list-toolbar">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%"><a href="?page=addpembayaran">
    <button class="btn btn-primary"  >
<i class="fa fa-plus"></i> Tambah  Pembayaran Baru</button>
    </a>    <a href="?page=bayar_tampil1">
    <button class="btn btn-warning"  >
<i class="fa fa-refresh"></i> Segarkan Data</button>
    </a>   <a href="simpantunggakanxls.php"><button class="btn btn-info"  ><i class="fa fa-save"></i> Simpan Excel </button>
    </a>   </td>
    <td width="47%" align="right"> <form class="form-inline" method="post" style="margin-top:0px; "  action="?page=bayar_tampil1">
                    <input class="input-xlarge form-control" placeholder="Cari Kode Pembayaran ..." id="appendedInputButton" name="search" type="text">
                    <button class="btn btn-default" name="submit" type="submit "><i class="fa fa-search"></i> Cari</button>
                </form></td>
  </tr>
</table>

  
          
      <div class="btn-group">
 
                
</div></div>
<table width="100%" class="table table-striped table-bordered table-condensed" id="example1">
  <tr>
    <th width="20" align="center" bgcolor="#CCCCCC">No</th>
    <th width="182" align="center" bgcolor="#CCCCCC">Kode Pembayaran</th>
    <th width="246" align="right" bgcolor="#CCCCCC">Tanggal Pembayaran</th>
    <th width="137" align="right" bgcolor="#CCCCCC">NIS</th>
    <th width="144" align="right" bgcolor="#CCCCCC">Nama Siswa</th>
    <th width="152" align="right" bgcolor="#CCCCCC">Kelas</th>
    
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Alat</strong></td>
  </tr>
 <?php
	  if ((isset($_POST['submit'])) AND ($_POST['search'] <> ""))
{
	$search = $_POST['search'];
	$sql1 = mysql_query("SELECT * FROM pembayaran WHERE kd_pembayaran LIKE '%$search%' LIMIT $hal, $row" ) or die(mysql_error());
	}
	
	{
	$no=0;
	   while ($data = mysql_fetch_array($sql1)){
	  $nomor++;
		$total = mysql_num_rows($sql1);
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$row = 1000000;
$max= ceil($total/$row);
$total	= mysql_num_rows($sql1);

		 ?>
  <tr>
    <td ><?php echo $nomor; ?></td>
    <td><?php echo $data['kd_pembayaran'];?></a></td>
    <td align="left"><?php echo $data['tgl_bayar'];?></td>
    <td><?php echo ($data['no_induk']);?></td>
    <td><?php echo ($data['nama_siswa']);?></td>
    <td><?php echo ($data['kelas']);?></td>
    
    <td colspan="2" align="center"><a href="?page=addpembayaranhutang&amp;noNota=<?php echo $data['kd_pembayaran'];?>" target="_self"><i class="fa fa-money"></i> Bayar Tunggakan</a> </td>
    </tr>
  <?php } ?>
  <tr>
    <td colspan="8"><strong>Jumlah Data :</strong> <?php echo $total; }?><strong> </strong>
      </td>
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

