<?php
session_start();
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";
define('BASEPATH','TEST');
// Baca Jam pada Komputer
date_default_timezone_set("Asia/Jakarta");
$dataTanggal 	=  date('d-m-Y');

if(isset($_SESSION['SES_LOGIN']))
{
   
?>
<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>Aplikasi Keuangan</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.11.1.min.js" type="text/javascript"></script>

        <script src="lib/jQuery-Knob/js/jquery.knob.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $(".knob").knob();
        });
    </script>



    <link rel="stylesheet" type="text/css" href="stylesheets/temahendry.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/hendry.css">

</head>
<body class=" theme-blue">

    <!-- Demo page code -->

    <script type="text/javascript">
        $(function() {
            var match = document.cookie.match(new RegExp('color=([^;]+)'));
            if(match) var color = match[1];
            if(color) {
                $('body').removeClass(function (index, css) {
                    return (css.match (/\btheme-\S+/g) || []).join(' ')
                })
                $('body').addClass('theme-' + color);
            }

            $('[data-popover="true"]').popover({html: true});
            
        });
    </script>
    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover { 
            color: #fff;
        }
    </style>

    <script type="text/javascript">
        $(function() {
            var uls = $('.sidebar-nav > ul > *').clone();
            uls.addClass('visible-xs');
            $('#main-menu').append(uls.clone());
        });
    </script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  

 

    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="" href="index.html"><img src="../images/logo1.png" width="239" height="54"></span></a></div>

        <div class="navbar-collapse collapse" style="height: 1px;">
          <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="../images/logo yayasan.gif" alt="User Image" width="30" height="30" class="img-polaroid" /> </span> <?php echo $_SESSION['SES_LOGIN']; ?>
                <i class="fa fa-caret-down"></i>
                </a>

              <ul class="dropdown-menu">
              <li class="divider"></li>
                <li><a href="#">Pengaturan Akun</a></li>
                
                
                <li class="divider"></li>
                <li><a href='../logout.php' tabindex="-1" title='Keluar' onClick="if (confirm(&quot;Apakah anda yakin ingin keluar aplikasi ini ?&quot;)) { return true; } return false;" >Keluar</a></li>
              </ul>
            </li>
          </ul>

        </div>
      </div>
    </div>
    

    <div class="sidebar-nav">
    <ul>
    <li><a href="#" data-target=".dashboard-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-fw fa-dashboard"></i> Data Master<i class="fa fa-collapse"></i></a></li>
    <li><ul class="dashboard-menu nav nav-list collapse in">
            <li><a href="?page=awal"><span class="fa fa-caret-right"></span> Beranda</a></li>
            <li ><a href="?page=data_siswa12"><span class="fa fa-caret-right"></span> Data Siswa</a></li>
            
          
            
            <li ><a href="?page=bayar_tampil"><span class="fa fa-caret-right"></span> Data Transaksi Pembayaran</a></li>

             <li ><a href="?page=jns_bayar"><span class="fa fa-caret-right"></span> Data Jenis Pembayaran</a></li>
    </ul></li>

    <a href="#" data-target=".premium-menu" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-fw fa-money"></i> Transaksi Pembayaran<i class="fa fa-collapse"></i></a></li>
        <li><ul class="premium-menu nav nav-list collapse">
               
            <li ><a href="?page=addpembayaran"><span class="fa fa-caret-right"></span> Tambah Pembayaran</a></li>
            <li ><a href="?page=bayar_tampil"><span class="fa fa-caret-right"></span> Data Pembayaran</a></li>
            <li ><a href="?page=bayar_tampil1"><span class="fa fa-caret-right"></span> Data Pembayaran Tunggakan</a></li>
           
            
    </ul></li>

        <li><a href="#" data-target=".accounts-menu" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-fw fa-list-alt"></i> Laporan <i class="fa fa-collapse"></i></a></li>
        <li><ul class="accounts-menu nav nav-list collapse">
            <li ><a href="?page=cari_nota"><span class="fa fa-caret-right"></span> Laporan Nota Pembayaran Siswa </a></li>
            <li ><a href="?page=cari_data_pembayaran"><span class="fa fa-caret-right"></span> Laporan Bayar Per Jenis Bayar </a></li>
            <li ><a href="?page=lap_peminjaman1"><span class="fa fa-caret-right"></span> Laporan Bayar Per Nama</a></li>
            <li ><a href="?page=kelas_siswa1"><span class="fa fa-caret-right"></span> Laporan Bayar Per Kelas</a></li>
			<li ><a href="?page=laporan_periode"><span class="fa fa-caret-right"></span> Laporan Periode</a></li>
            <li ><a href="?page=laporan_bayar_periode11"><span class="fa fa-caret-right"></span> Laporan Bayar Per Periode</a></li>
            <li ><a href="?page=tunggakan"><span class="fa fa-caret-right"></span> Laporan Tunggakan</a></li>
			<li ><a href="?page=laporan_periode_hari"><span class="fa fa-caret-right"></span> Laporan Harian</a></li>
			<li ><a href="?page=lap_uts"><span class="fa fa-caret-right"></span> Laporan Tunggakan Per UTs</a></li>
            <li ><a href="?page=lap_uas"><span class="fa fa-caret-right"></span> Laporan Tunggakan Per UAS</a></li>
    </ul></li>

            </ul>
    </div>

    <div class="content">
        
           <?php include "switch.php";?>
                    

       
        <div class="main-content">
          <div class="row"></div>

<div class="row"></div>


            <footer>
                <hr>

                <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
                <p class="pull-right">All rights reserved.</p>
                <p>© <?php echo date("Y");?> <a href="#" target="_blank">SMK KORPRI SUMEDANG</a></p>
          </footer>
      </div>
    </div>


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  
</body>
</html>
<?php 
}
else
{
	 header("Location:../index.php");
}

?>