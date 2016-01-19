<?php

include_once "../config/inc.connection.php";
$id = $_GET['id'];

$hasil = mysql_query("DELETE FROM tmp_pembayaran WHERE id = '$id'");

if ($hasil){
?><script>
document.location.href="?page=addpembayaran";</script><?php
} 
else
{
echo "gagal karena : ".mysql_error();
}
?>