<?php
include_once "../config/inc.connection.php";


$no_induk = $_GET['no_induk'];

$hasil = mysql_query("DELETE FROM siswa WHERE no_induk = '$no_induk'");

if ($hasil){
?><script>alert ("Data Siswa Berhasil di hapus !");
document.location.href="?page=data_siswa12";</script><?php
} 
else
{
echo "gagal karena : ".mysql_error();
}
?>