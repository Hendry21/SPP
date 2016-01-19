<?php
include_once "../config/inc.connection.php";


$kd_pembayaran = $_GET['kd_pembayaran'];

$hasil = mysql_query("DELETE FROM pembayaran WHERE kd_pembayaran = '$kd_pembayaran'");

if ($hasil){
?><script>alert ("Data Berhasil di hapus !");
document.location.href="index.php?page=bayar_tampil";</script><?php
} 
else
{
echo "gagal karena : ".mysql_error();
}
?>