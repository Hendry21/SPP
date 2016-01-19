 <script type="text/javascript">
	$(document).ready(function  () {
			$('#close').click(function 	 () {
				$('#info').fadeOut()
			})
	})
</script>
<section id="top"></section>
<div class="text-left">
<div id="info" class="alert alert-info">
<div class="pull-right">
	<a id="close" href="#top"><i class="fa fa-remove"></i></a>
</div>
<h4><i class="fa fa-info-circle"></i> TU SMK KORPRI Sumedang</h4>

TU SMK KORPRI Sumedang merupakan aplikasi yang digunakan untuk membantu petugas TU dalam Transaksi Pembayaran </div>
	<div class="col-xs-6 up">
	<?php 
	include_once "../config/inc.connection.php";

		$sql = "SELECT * FROM siswa";
		$data = mysql_query($sql);
		$jumlah_anggota=mysql_num_rows($data);
		$simpanan=mysql_query("SELECT    pembayaran.*,  pembayaran_item.uang_bayar,biaya,jns_bayar FROM pembayaran
			  LEFT JOIN pembayaran_item ON pembayaran.kd_pembayaran=pembayaran_item.kd_pembayaran");
		$jumlah_simpanan=mysql_num_rows($simpanan);
	;?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-user fa-5x"></i>
				<div class="pull-right">
					<h1><?php echo $jumlah_anggota;?></h1>
				</div>
				<br>
				<span>
					Jumlah Siswa
				</span>
				
			</div>
			<a href="?page=data_siswa12">
					<div class="panel-footer text-right">
						Lihat Detail <i class="fa fa-forward"></i>
					</div>
				</a>
		</div>
	</div>
    <div class="col-xs-6 up">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<i class="fa fa-bookmark fa-5x"></i>
				<div class="pull-right">
					<h1></h1>
				</div>
				<br>
				<span>
					Data Jenis Pembayaran
				</span>
				
			</div>
			<a class="up" href="?page=jns_bayar"  >
					<div class="panel-footer text-right">
						Lihat Detail <i class="fa fa-forward"></i>
					</div>
				</a>
		</div>
	</div>
    
	<div class="col-xs-6 up">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<i class="fa fa-credit-card fa-5x"></i>
				<div class="pull-right">
					<h1><?php echo $jumlah_simpanan;?></h1>
				</div>
				<br>
				<span>
					Data Transaksi Pembayaran</span>
				
			</div>
			<a  class="up" href="?page=bayar_tampil">
					<div class="panel-footer text-right">
						Lihat Detail <i class="fa fa-forward"></i>
					</div>
				</a>
		</div>
	</div>
	
	<div class="col-xs-6 up">
		<div class="panel panel-success">
			<div class="panel-heading">
				<i class="fa fa-money fa-5x"></i>
				<div class="pull-right">
					<h1></h1>
				</div>
				<br>
				<span>
					Pembayaran Tunggakan
				</span>
				
			</div>
			<a class="up" href="?page=bayar_tampil1"  >
					<div class="panel-footer text-right">
						Lihat Detail <i class="fa fa-forward"></i>
					</div>
				</a>
		</div>

	</div>
	
				
	</div>
</div>