<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//include_once "library/inc.seslogin.php";
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";
error_reporting(0);
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$bariss 		= 90000;
$halaman 	= isset($_GET['hal']) ?  mysql_real_escape_string($_GET['hal']) : 0;
$pageSql 	= "SELECT * FROM siswa ORDER BY no_induk ASC LIMIT $halaman, $bariss";
$sql1 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
 $jmlData 	= mysql_num_rows($sql1);
 {
 $q	= "";

$maksData	= ceil($jmlData/$bariss);
?>
<style type="text/css">
.main-content .table.table-striped.table-bordered.table-condensed tr th {
	text-align: left;
}
</style>

<h2> MANAJEMEN DATA SISWA KELAS X<br />
  <br />
</h2>
<div class="main-content">
<div class="btn-toolbar list-toolbar">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%"> <a href="?page=addsiswa1">
    <button class="btn btn-primary"  >
<i class="fa fa-plus"></i>Tambah Siswa Kelas X</button>
    </a>  <a href="?page=data_siswa12">
    <button class="btn btn-warning"  >
<i class="fa fa-refresh"></i> Lihat Semua Data</button>
    </a> 
	 <a href="simpansiswaxls.php"><button class="btn btn-info"  ><i class="fa fa-save"></i> Simpan Excel </button>
    </a>   </td>
    <td width="47%" align="right"> <form class="form-inline" method="post" style="margin-top:0px; "  action="?page=data_siswa12">
                    <?php  
mysql_connect("localhost","root","");  
mysql_select_db("tu71");  
$result = mysql_query("select distinct kelas from siswa");  
$jsArray = "var prdName = new Array();\n";  
echo '<select name="cmbKelas"  class=" form-control" onchange="changeValue(this.value)"  >';  
echo '<option>--- Cari Kelas :---</option>';  
echo '<option> </option>';
 
    
while ($row = mysql_fetch_array($result)) {  
    echo '<option value="' . $row['kelas'] . '">' . $row['kelas'] . '</option>';  
    $jsArray .= "prdName['" . $row['kelas'] . "'] = {name:'" . addslashes($row['kelas']) . "' };\n";  
}  
echo '</select>';  
?>
                    <input class="input-xlarge form-control"  value="<?php echo $q; ?>"placeholder="Cari Jenis Bayar..." id="prd_name" name="search" type="hidden"><script type="text/javascript">  
<?php echo $jsArray; ?>
function changeValue(id){
document.getElementById('prd_name').value = prdName[id].name;
};
</script>
                    <button class="btn btn-default" name="submit" type="submit "><i class="fa fa-search"></i> Cari</button>
                </form></td>
  </tr>
</table>
    
  <div class="btn-group"><br /><br />

</div></div>
<table width="1088" class="table table-striped table-bordered table-condensed" id="example1">
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
	  if ((isset($_POST['submit'])) AND ($_POST['search'] <> "da"))
{
	$search = $_POST['search'];
	$sql1 = mysql_query("SELECT * FROM siswa   WHERE kelas LIKE '%$search%' ORDER BY no_induk ASC LIMIT $halaman, $bariss") or die(mysql_error());
	}
	
	{
	$nomor  = 0; 
	   while ($myData = mysql_fetch_array($sql1)){
	 $nomor++;
		$Kode = $myData['no_induk'];
		$jmlDat  = mysql_num_rows($sql1);
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;

$baris 		= 10000;
$maksDat 	= ceil($jmlDat/$baris);		 ?>
  
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_induk']; ?></td>
    <td align="left"><?php echo ($myData['nisn']); ?></td>
    <td><?php echo $myData['nama_siswa']; ?></td>
    <td><?php echo $myData['jk']; ?></td>
    <td align="left"><?php echo $myData['tmpt_lahir']; ?>    , <?php echo $myData['tgl_lahir']; ?></img></td>
    <td align="left"><?php echo ($myData['kelas']); ?></td>
    <td align="left"><?php echo ($myData['alamat']); ?></td>
     <td width="6%"><div align="center"><a href="?page=editsiswa&no_induk=<?php echo $myData['no_induk'];?>">Ubah</a></div></td>
    <td width="48" align="center"> <a href="?page=hapus_siswa2&no_induk=<?php echo $myData['no_induk'];?> ">Hapus</a></td>
   
  </tr>
  <?php }?>
  <tr>
    <td colspan="10"><strong>Jumlah Data :</strong> <?php echo $jmlDat ; ?> </td>
    </tr>
  <?php }?>
</table>
<table width="100%" border="0">
  <tr>
    <td><strong>Jumlah Semua Data Siswa : <?php echo $jmlData; ?></strong></td>
    <td align="right"><strong><?php
	 
	 }
	?></strong></td>
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
<p><button onclick="window.print()"  /> Cetak  </button></p>
