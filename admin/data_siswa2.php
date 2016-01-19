<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//include_once "library/inc.seslogin.php";
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ?  mysql_real_escape_string($_GET['hal']) : 0;
$pageSql 	= "SELECT * FROM siswa";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<style type="text/css">
.main-content .table.table-striped.table-bordered.table-condensed tr th {
	text-align: left;
}
</style>

<h2> MANAJEMEN DATA SISWA KELAS XI<br />
  <br />
</h2>
<div class="main-content">
<div class="btn-toolbar list-toolbar">
    <a href="?page=addsiswa2">
    <button class="btn btn-primary"  ><i class="fa fa-plus"></i> Tambah Siswa Kelas XI</button></a>  
    
  <div class="btn-group"><br /><br />

</div></div>
<table width="1068" class="table table-striped table-bordered table-condensed" id="example1">
  <tr>
    <th width="24" align="center" bgcolor="#CCCCCC">No</th>
    <th width="76" align="center" bgcolor="#CCCCCC">No Induk</th>
    <th width="75" align="right" bgcolor="#CCCCCC">NISN</th>
    <th width="188" bgcolor="#CCCCCC">Nama Siswa</th>
    <th width="110" bgcolor="#CCCCCC">Jenis Kelamin</th>
    <th width="206" align="center" bgcolor="#CCCCCC">Tempat, Tanggal Lahir</th>
    <th width="78" align="right" bgcolor="#CCCCCC">Kelas</th>
    <th width="164" align="right" bgcolor="#CCCCCC">Alamat</th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql = "SELECT * FROM siswa ORDER BY nama_siswa ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_induk'];
		?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_induk']; ?></td>
    <td align="left"><?php echo ($myData['nisn']); ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['jk']; ?></td>
    <td align="left"><?php echo $myData['tmpt_lahir']; ?>    , <?php echo $myData['tgl_lahir']; ?></img></td>
    <td align="left"><?php echo ($myData['kelas']); ?></td>
    <td align="left"><?php echo ($myData['alamat']); ?></td>
    <td width="55" align="center"><a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"></a><a href="#"><i class="fa fa-edit"></i> Ubah</a></td>
    <td width="48" align="center"> <a href="?page=hapus_siswa2&no_induk=<?php echo $myData['no_induk'];?>" onClick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"role="button" data-toggle="modal"><i class="fa fa-trash-o"></i> Hapus</a></td>
   
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td colspan="6" align="right"><strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Barang-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
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
           <a href="?page=hapus_siswa2&no_induk=<?php echo $myData['no_induk'];?>"> <button class="btn btn-danger" data-dismiss="modal">Hapus</button></a>
        </div>
    </div>
  </div>
</div>

