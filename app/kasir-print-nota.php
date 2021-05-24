<html>
<head>
	<title>Print kwitansi {{kwitansiNo}}</title>
	<script>
		window.print();
	</script>
	<style type="text/css">
		.lead {
			font-family: "Verdana";
			font-weight: bold;
		}
		.value {
			font-family: "Verdana";
		}
		.value-big {
			font-family: "Verdana";
			font-weight: bold;
			font-size: large;
		}
		.td {
			valign : "top";
		}

		/* @page { size: with x height */
			/*@page { size: 20cm 10cm; margin: 0px; }*/
			@page {
				size: A4;
				margin : 0px;
			}
	/*		@media print {
			  html, body {
			  	width: 210mm;
			  }
			  }*/
			  /*body { border: 2px solid #000000;  }*/
			</style>
			<script type="text/javascript">
				var beforePrint = function() {
				};

				var afterPrint = function() {
					document.location.href = '../app/kasir-bayar.php';
				};

				if (window.matchMedia) {
					var mediaQueryList = window.matchMedia('print');
					mediaQueryList.addListener(function(mql) {
						if (mql.matches) {
							beforePrint();
						} else {
							afterPrint();
						}
					});
				}

				window.onbeforeprint = beforePrint;
				window.onafterprint = afterPrint;
			</script>
		</head>
		<body>
			<table border="1px">
				<td>
					<?php 
					function penyebut($nilai) {
						$nilai = abs($nilai);
						$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
						$temp = "";
						if ($nilai < 12) {
							$temp = " ". $huruf[$nilai];
						} else if ($nilai <20) {
							$temp = penyebut($nilai - 10). " belas";
						} else if ($nilai < 100) {
							$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
						} else if ($nilai < 200) {
							$temp = " seratus" . penyebut($nilai - 100);
						} else if ($nilai < 1000) {
							$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
						} else if ($nilai < 2000) {
							$temp = " seribu" . penyebut($nilai - 1000);
						} else if ($nilai < 1000000) {
							$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
						} else if ($nilai < 1000000000) {
							$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
						} else if ($nilai < 1000000000000) {
							$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
						} else if ($nilai < 1000000000000000) {
							$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
						}     
						return $temp;
					}

					function terbilang($nilai) {
						if($nilai<0) {
							$hasil = "minus ". trim(penyebut($nilai));
						} else {
							$hasil = trim(penyebut($nilai));
						}     		
						return $hasil;
					}

					include '../config/connect.php';
					date_default_timezone_set("Asia/Jakarta");
					$tanggalsekarang    =   date('Y-m-d');
					$jamsekarang        =   date("H:i:s");
					$id_lab_trn = $_GET['id'];
					$data = mysqli_query($koneksi,
						"SELECT *, mr_pendaftaran.id_mr_pendaftaran, mr_pasien.nama_pasien, mr_dokter.nama_dokter, mr_unit.nama_unit,
						lab_trn.status_bayar AS STATUS, lab_tarif.tarif, psdi_petugas.nama_petugas
						FROM lab_trn
						INNER JOIN mr_pendaftaran
						ON lab_trn.id_mr_pendaftaran = mr_pendaftaran.id_mr_pendaftaran
						INNER JOIN mr_pasien
						ON mr_pendaftaran.id_catatan_medik = mr_pasien.id_catatan_medik
						INNER JOIN mr_dokter
						ON mr_pendaftaran.id_dokter = mr_dokter.id_dokter
						INNER JOIN mr_unit
						ON mr_dokter.id_unit = mr_unit.id_unit
						INNER JOIN lab_tarif
						ON lab_trn.pemeriksaan = lab_tarif.id_lab_tarif
						INNER JOIN psdi_petugas
						ON lab_trn.id_petugas = psdi_petugas.id_petugas
						WHERE lab_trn.id_lab_trn = '$id_lab_trn'
						");
					while($d = mysqli_fetch_array($data)){
						$tanggal    = $d['tanggal'];
						$tgl_lahir  = $d['tgl_lahir'];
						?>
						<table cellpadding="4">
							<tr><img class="img-responsive" src="../images/logo.png" width="100%" alt="RS Permata"></tr><hr>
							<tr>
								<td width="200px"><div class="lead">No.Kwitansi:</td>
									<td><div class="value"><?php echo $d['id_lab_trn']; ?></div></td>
								</tr>
								<tr>
									<td><div class="lead">Telah terima dari:</div></td>
									<td><div class="value"><?php echo $d['nama_pasien']; ?></div></td>
								</tr>
								<tr>
									<td><div class="lead">Untuk pembayaran:</div></td>
									<td><div class="value">Pemeriksaan Laboratorium</div></td>
								</tr>
								<tr>
									<td><div class="lead">Tanggal:</div></td>
									<td><div class="value"><?php echo date('d/m/Y', strtotime($d['tanggal'])); ?></div></td>
								</tr>
								<tr>
									<td><div class="lead">Rupiah:</div></td>
									<td><div class="value-big">Rp. <?php echo number_format($d['total_bayar']); ?></div></td>
								</tr>
								<tr>
									<td><div class="lead">Uang sejumlah:</div></td>
									<td><div class="value"><?php echo terbilang($d['total_bayar']); ?> rupiah</div></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td><h3>LUNAS</h3></td>
								</tr>
								<tr>
									<td><div class="lead">Kasir:</div></td>
									<td><div class="value"><?php echo $d['nama_petugas']; ?></div></td>
								</tr>
								<tr>
									<td colspan="2"><center><p><small><?php echo $tanggalsekarang."/".$jamsekarang; ?></small></p></center></td>
								</tr>
							</table>
						<?php } ?>
					</td>
				</tr>
			</table>
			<hr>
			<script src="/js/jquery.min.js"></script>
			<script type="text/javascript">
				$(document).ready(function () {
					window.print();
				});
			</script>
		</body>
		</html>