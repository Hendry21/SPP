 
<h2> CARI NOTA TRANSAKSI PEMBAYARAN </h2>
<br />
<div class="main-content">
<div class="btn-toolbar list-toolbar">

<table class="table table-striped  table-condensed" cellspacing="0" cellpadding="0">
  <tr>
    <td> <form class="form-inline" method="post" style="margin-top:0px; "  action="?page=cari_nota">
                    <input class="input-xlarge form-control" placeholder="Cari Nama Siswa ..." id="appendedInputButton" name="search" type="text">
                    <button class="btn btn-default" name="submit" type="submit "><i class="fa fa-search"></i> Cari</button>
                </form></td>
    </tr>
</table>

 <div class="btn-group">
 
                
</div></div>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="72" align="left" bgcolor="#CCCCCC"><strong>NIS</strong></td>
    <td width="48" align="center" bgcolor="#CCCCCC"><strong>Nama Siswa</strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Kelas</strong></td>
    <td width="85" bgcolor="#CCCCCC"><strong>Tanggal Bayar</strong></td>
    <td width="106" bgcolor="#CCCCCC"><strong>Kode Bayar </strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
    </tr>
 <?php
 error_reporting(0);
	  if ((isset($_POST['submit'])) AND ($_POST['search'] <> ""))
{
	
	$search = $_POST['search'];
	$sql1 = mysql_query("SELECT * FROM pembayaran WHERE nama_siswa LIKE '%$search%'  " ) or die(mysql_error());
	}
	
	{
	$no=0;
	   while ($myData = mysql_fetch_array($sql1)){
	  $nomor++;
  
 
		 ?>
    
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="left"><?php echo $myData['no_induk']; ?></td>
    <td align="left"><?php echo $myData['nama_siswa']; ?></td>
    <td align="right"><?php echo $myData['kelas']; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_bayar']); ?></td>
    <td><?php echo $myData['kd_pembayaran']; ?></td>
    <td width="43" align="center"><a href="bayar_nota.php?noNota=<?php echo $myData ['kd_pembayaran'];?>" target="_blank">Nota</a></td>
    </tr>
  <?php }} ?>
  </table>
<p>&nbsp;</p>
</div>
</div>