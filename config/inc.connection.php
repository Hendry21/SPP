<?php
# Konek ke Web Server Lokal
$myHost	= "localhost";
$myUser	= "root";
$myPass	= "";
$myDbs	= "tu71"; // nama database, disesuaikan dengan database di MySQL

# Konek ke Web Server Lokal
$koneksidb	= mysql_connect($myHost, $myUser, $myPass) or die ("Koneksi MySQL gagal !");

# Memilih database pd MySQL Server
mysql_select_db($myDbs, $koneksidb) or die ("Database $myDbs tidak ditemukan !");
?>