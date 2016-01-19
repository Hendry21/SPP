<!DOCTYPE html>
<html lang="en">
<head>
<title>Aplikasi Sistem Informasi TU</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="admin/lib/bootstrap/css/bootstrap.css">
<link href="css/loginstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript"> 
      $(document).ready(function(){
        	$("#container").bind("click keydown", function() {
        		$(this).expose({

			     // setting mask/penutup untuk background dengan CSS
			     maskId: 'mask',

			     // ketika form ter-expose, ganti warna background form
			     onLoad: function() {
				      this.getExposed().css({"background-color":"transfaran"});
			     },

			     // ketika form tidak ter-expose, kembalikan warna background ke warna semula
			     onClose: function() {
				      this.getExposed().css({"background-image": null});
			     },
			     api: true

		      }).load();
	        });
	    });
</script>

</head>
<body id="page1">
<div class="body1">
  <div class="main">
    <!-- header -->
    <header>
      
      <div class="wrapper">
        <h1><a href="index.html" id="logo">Learn Center</a></h1>
      </div>
      <div id="slogan">      Silahkan Login!!!</div>
      <ul class="banners">
        <li></li>
        <li></li>
        <li><form method="post" action="login_validasi.php">
            <div id="container">
              <div id="header">               
               <!-- end #header -->
              </div>
              <div id="mainContent">
                <div align="left">
                  <table width="469" height="237" border="0" cellpadding="2">
                    <tr>
                      <td width="187" rowspan="5"><div align="center"> <img src="images/user.png" width="173" height="177" /></div></td>
                      <td width="190">&nbsp;</td>
                      <td width="70">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="73" colspan="2"><div align="justify">
                        <label for="exampleInputPassword1">Nama Pengguna</label>
                        <div class="form-group">
                          <input type="text" class="form-control"  name="username" placeholder="Masukan Nama Pengguna">
                          </div>
                      </div></td>
                    </tr>
                    <tr>
                      <td height="73" colspan="2"><div align="justify">
                        <label for="exampleInputPassword1">Kata Sandi</label>
                        <div class="form-group">
                          <input type="password" class="form-control"  name="password" placeholder="Masukan Kata Sandi">
                          </div>
                      </div></td>
                    </tr>
                    <tr>
                      <td height="36"><a href="reset-password.html">Lupa Kata Sandi ?</a></td>
                      <td><div align="right"><button type="submit" class="btn btn-primary">Masuk..</button>
                        </div>
                      </td>
                    <td width="-4"></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font:12px Georgia, 'Times New Roman', Times, serif; color:#FF0000; font-style:normal; text-align:center;"><br>
                        <br>
                        <br>
                        <?php 
//kode php ini kita gunakan untuk menampilkan pesan eror
if (!empty($_GET['error'])) {
	if ($_GET['error'] == 1) {
		echo ("Nama Pengguna dan Kata Sandi belum diisi!");
	} else if ($_GET['error'] == 2) {
		echo ("Nama Pengguna belum diisi!");
	} else if ($_GET['error'] == 3) {
		echo ("Kata Sandi belum diisi!");
	} else if ($_GET['error'] == 4) {
		echo ("Pengguna ini tidak terdaftar !");
	}
}
?>
                      <div align="center"></div></td>
                    </tr>
                  </table>
                </div>
              </div>
              <div id="footer">
              
                <!-- end #footer -->
              </div>
              <!-- end #container -->
            </div>
        </form></li>
      </ul>
    </header>
    <!-- / header -->
  </div>
</div>
<div class="body2">
  
</div>
<script type="text/javascript">Cufon.now();</script>

</body>
</html>