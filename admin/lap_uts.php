
<?php include("kelas_siswa1.php"); ?>
<br >
<table width="748" height="165" align="center" class="table table-striped table-bordered table-condensed">
<tr>
	  <td width="79" height="31" class="head-data">Laporan Pembayaran Per Siswa</td>
  </tr>
	<?php 
	error_reporting(0);	include "../config/inc.connection.php";

	
	echo "<tr><td class='td-data'>";
	
	
	$siswa			= isset($_POST['kab']) ? $_POST['kab'] : "";
	$pminjam		=mysql_query("SELECT * FROM pembayaran WHERE nama_siswa ='$siswa'");
	$pminjam_lkp	=mysql_fetch_array($pminjam);
	
	if ($siswa=="") {
		echo "<table class='table-data' width='100%'>
		<tr><td class='head-data' align='center' colspan='5'>Data Siswa Yang Sudah Bayar</td></tr>
		<tr><td class='td-data' align='center'colspan='5'>-->>Silakan Pilih Kelas dan Pilih Siswa Terlebih Dahulu<<--</td></tr></table>";
	} else {
		print "&nbsp;<table class='table table-striped   table-condensed'  >
			 
			<tr><td   class='pinggir-data' colspan='3'>NIS : <b>$pminjam_lkp[no_induk]</b></td>
			<td class='pinggir-data'   colspan='3'>Nama Lengkap : <b>$pminjam_lkp[nama_siswa]</b></td>
			<td class='pinggir-data'   colspan='3'>Kelas : <b>$pminjam_lkp[kelas]</b></td>
			</tr>
			 
			";
	?>

<tr>
<td class="head-data"  colspan="7"><b>Daftar Jenis Pembayaran</b></td>
  </tr>
<tr>
<td width="79" bgcolor="#F5F5F5"><strong>Kode Bayar</strong></td>
<td width="80" bgcolor="#F5F5F5"><strong>Periode Bulan &amp; Tahun</strong></td>
      <td width="120" bgcolor="#F5F5F5"><strong>Jenis Pembayaran</strong></td>
      <td width="63" align="left" bgcolor="#F5F5F5"><strong>Biaya (Rp)</strong></td>
      <td width="105" align="left" bgcolor="#F5F5F5"><strong>Uang Bayar (Rp)</strong></td>
       <td width="133" align="left" bgcolor="#F5F5F5"><strong>Tunggakan (Rp)</strong></td>
      <td width="136" align="center" bgcolor="#F5F5F5"><strong>Keterangan </strong></td>
 </tr>   
	<?php
	$jumlahbarang	= 0;

	$query=mysql_query("SELECT *from pembayaran_item  WHERE nama_siswa ='$siswa'") or die (mysql_error());
	$jum=mysql_num_rows($query);
	if ($jum==0) {
	echo "<tr><td class='td-data' colspan='4'>-- $siswa Tidak Ada Data Pembayaran--</td></tr>";
	} else {
	while ($hasil=mysql_fetch_array($query))	 {
		$subSotal 	= $hasil['uang_bayar'] - $hasil['biaya'];
	$totalBayar	= $totalBayar +  $hasil['biaya'];
	$totalBiaya	= $totalBiaya +  $subSotal;
	$jumlahbarang	= $jumlahbarang + ($hasil['uang_bayar']);
	echo "<tr><td class='td-data'>$hasil[kd_pembayaran]</td> <td class='td-data'>$hasil[periode_thn]</td><td class='td-data'>$hasil[jns_bayar]</td><td align='left' class='td-data'>$hasil[biaya]</td><td align='left'class='td-data'>$hasil[uang_bayar]</td><td align='left' class='td-data'>$subSotal</td><td align='center' class='td-data'>$hasil[ket]</td> </tr>
	
	";
	
	
	} echo "<tr>
       <td width='138' height='24'colspan='2' align='right' bgcolor='#F5F5F5'><strong>GRAND TOTAL : </strong></td>
      <td align='left'bgcolor='#F5F5F5'><b> </b></td>
      <td align='left'bgcolor='#F5F5F5'><b>$totalBayar</b></td>
      <td align='left'bgcolor='#F5F5F5'><b>$jumlahbarang</b></td>
        <td align='left'bgcolor='#F5F5F5'><b>$totalBiaya</b></td>
		<td align='right'bgcolor='#F5F5F5'>&nbsp;</td>
    </tr>";
	
	}
	}	
    ?>
</table></td></tr></table>			