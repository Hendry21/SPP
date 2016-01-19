<?php

// Membaca variabel form
$KeyWord	= isset($_GET['KeyWord']) ? $_GET['KeyWord'] : '';
$dataCari	= isset($_POST['txtCari']) ? $_POST['txtCari'] : $KeyWord;

// Jika tombol Cari diklik
if(isset($_POST['btnCari'])){
	if($_POST) {
		$filterSql = "WHERE jns_bayar LIKE '%$dataCari%'";
	}
}
else {
	if($KeyWord){
		$filterSql = "WHERE jns_bayar LIKE '%$dataCari%'";
	}
	else {
		$filterSql = "";
	}
} 

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM jns_bayar $filterSql";
$pageQry = mysql_query($pageSql) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<style type="text/css">
.table-list tr td a {
	text-align: center;
}
</style>

<h2>Cari Jenis Pembayaran</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <p><strong>Cari Jenis Bayar:</strong>
    <input name="txtCari" type="text" value="<?php echo $dataCari; ?>" size="40" maxlength="100" />
    <input name="btnCari" type="submit" value="Cari" />
</p>
  <p>&nbsp;  </p>
</form>
<table  class="table table-striped table-bordered table-condensed" width="685" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <th width="40" bgcolor="#CCCCCC">No</th>
    <th width="145" bgcolor="#CCCCCC"><strong>Kode Bayar </strong></th>
    <th width="285" bgcolor="#CCCCCC"><strong>Jenis Bayar </strong></th>
    <th width="113" bgcolor="#CCCCCC"><strong>Biaya</strong></th>
    <td width="66" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
<?php
$mySql = "SELECT * FROM jns_bayar $filterSql ORDER BY kode_bayar ASC LIMIT $hal, $row";
$myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error());
$nomor = 0; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kode_bayar']; ?></td>
    <td><?php echo $myData['jns_bayar']; ?></td>
    <td><?php echo $myData['biaya']; ?></td>
    <td align="center"><a href="?page=addpembayaran&kode_bayar=<?php echo $myData['kode_bayar']; ?>" target="_self" alt="Bayar">Bayar</a></td>
  </tr>
<?php } ?>  
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong> <?php echo $jml; ?></td>
    <td colspan="4" align="right"><strong>Halaman ke : </strong>
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=cari-jenis&hal=$list[$h]&KeyWord=$dataCari'>$h</a> ";
	}
	?></td>
  </tr>
</table>
