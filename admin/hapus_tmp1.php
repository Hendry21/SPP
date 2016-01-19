<?php

include_once "../config/inc.connection.php";
$kode_jenis = $_GET['id'];

$hasil = mysql_query("DELETE FROM  tmp_hutang WHERE id = '$kode_jenis'");

if ($hasil){
?><script>
document.location.href="javascript:history.back();";</script><?php
} 
else
{
echo "gagal karena : ".mysql_error();
}
?>