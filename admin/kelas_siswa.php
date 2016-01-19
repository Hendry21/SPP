<?php
 mysql_connect('localhost', 'root', '');
 mysql_select_db('tu71');
?>

<html>
<head>

<script language="JavaScript" type="text/JavaScript">
 
 function showKab()
 {
 <?php
 
 // membaca semua propinsi
 $query = "SELECT kelas, COUNT(kelas) AS 'jumlah' FROM siswa GROUP BY kelas";
 $hasil = mysql_query($query);
 
 // membuat if untuk masing-masing pilihan propinsi beserta isi option untuk combobox kedua
 while ($data = mysql_fetch_array($hasil))
 {
   $idProp = $data[0];

   // membuat IF untuk masing-masing propinsi
   echo "if (document.demo.propinsi.value == \"".$idProp."\")";
   echo "{";

   // membuat option kabupaten untuk masing-masing propinsi
   $query2 = "SELECT * FROM siswa WHERE kelas = '$idProp'";
   $hasil2 = mysql_query($query2);
   $content = "document.getElementById('kabupaten').innerHTML = \"";

   while ($data2 = mysql_fetch_array($hasil2))
   {
       $content .= "<option value='".$data2['nama_siswa']."'>NIS :".$data2['no_induk']." Nama :".$data2['nama_siswa']."</option>";   
   }
   $content .= "\"";
   echo $content;
   echo "}\n";   
 }

 ?> 
 }
</script>

</head>
<body>
<table class='table-data' width='100%'>
<form name="demo"  method="post"  target="_blank" action="?page=lap_uas1">
<tr><td class="head-data">Pilih Kelas
          <select name="propinsi" onChange="showKab()">
          <option value="">Kelas</option>
          <?php
                 // query untuk menampilkan propinsi
                 $query = "SELECT kelas, COUNT(kelas) AS 'jumlah' FROM pembayaran GROUP BY kelas";
                 $hasil = mysql_query($query);
                 while ($data = mysql_fetch_array($hasil))
                 {
                    echo "<option value='".$data[0]."'>".$data[0]."</option>";
                 }
          ?>
          </select> Pilih Siswa : 
      <select name="kab" id="kabupaten">
      </select>&nbsp; <input type="submit" value="Tampil..">
      </td>	   
</tr>
</form>
</table>
</body>
</html>
