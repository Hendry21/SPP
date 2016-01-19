<?php
include_once "../config/inc.connection.php";


$kode_jenis = $_GET['kode_jenis'];

$hasil = mysql_query("DELETE FROM jns_bayar WHERE kode_jenis = '$kode_jenis'");

if ($hasil){
?><script>alert ("Data Berhasil di hapus !");
document.location.href="index.php?page=jns_bayar";</script><?php
} 
else
{
echo "gagal karena : ".mysql_error();
}
?>