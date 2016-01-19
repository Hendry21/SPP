<?php



// Membaca variabel form
$KeyWord	= isset($_GET['KeyWord']) ? $_GET['KeyWord'] : '';
$dataCari	= isset($_POST['txtCari']) ? $_POST['txtCari'] : $KeyWord;

// Jika tombol Cari diklik
if(isset($_POST['btnCari'])){
	if($_POST) {
		$filterSql = "WHERE no_induk LIKE '%$dataCari%'";
	}
}
else {
	if($KeyWord){
		$filterSql = "WHERE no_induk LIKE '%$dataCari%'";
	}
	else {
		$filterSql = "";
	}
} 

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM siswa $filterSql";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<style type="text/css">
.table.table-striped.table-bordered.table-condensed tr th {
	text-align: center;
}
</style>

<h2>Cari Induk Siswa</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <b>Cari No Induk Siswa :
  <input name="txtCari" type="text" value="<?php echo $dataCari; ?>" size="40" maxlength="100" />
  <input name="btnCari" type="submit" value="Cari" />
  </b>
</form>
<p>&nbsp;</p>
<table class="table table-striped table-bordered table-condensed" width="787" border="0" cellspacing="1" cellpadding="2">
  <tr >
    <th width="28" align="center">No</th>
    <th width="89"><strong>No Induk </strong></th>
    <th width="81"><strong>NISN </strong></th>
    <th width="207"><strong>Nama Siswa</strong></th>
    <th width="116"><strong>Jenis Kelamin</strong></th>
    <th width="93"><strong>Kelas </strong></th>
    <th width="94"><strong>Tahun Ajaran</strong></th>
    <td align="center"><strong>Tools</strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM siswa $filterSql ORDER BY no_induk ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td bordercolor="#000000"><?php echo $myData['no_induk']; ?></td>
    <td bordercolor="#000000"><?php echo $myData['nisn']; ?></td>
    <td bordercolor="#000000"><?php echo $myData['nama_siswa']; ?></td>
    <td  align="center" bordercolor="#000000"><?php echo $myData['jk']; ?></td>
    <td  align="center" bordercolor="#000000"><?php echo $myData['kelas']; ?></td>
    <td  align="center" bordercolor="#000000"><?php echo $myData['thn_ajaran']; ?></td>
    <td width="38" align="center" bordercolor="#000000"><a href="?page=addpembayaran&amp;no_induk=<?php echo $myData['no_induk']; ?>" target="_self" alt="Daftar">Daftar</a></td>
  </tr>
  <?php } ?>
  <tr  >
    <td colspan="4"><strong>Jumlah Data :</strong> <?php echo $jml; ?> </td>
    <td colspan="4" align="right"><strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=cari_siswa&hal=$list[$h]&KeyWord=$dataCari'>$h</a> ";
	}
	?></td>
  </tr>
</table>
