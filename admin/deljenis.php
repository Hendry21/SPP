
<?php
error_reporting(0);
include "koneksi.php";

$kode_bayar = $_GET['kode_bayar'];

$hasil = mysql_query("DELETE FROM jns_bayar WHERE kode_bayar = '$kode_bayar'");

if ($hasil){
?><script>alert ("Data Berhasil di hapus !");
document.location.href="?page=jns_bayar";</script><?php
} 
else
{
echo "gagal karena : ".mysql_error();
}
?>