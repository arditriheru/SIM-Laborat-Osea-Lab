<?php include "views/header.php"; ?>
<nav>
  <div id="wrapper">
    <?php include "menu.php"; ?>
  </div><!-- /.navbar-collapse -->
</nav>
<?php 
$m = 31;
$n = 7;
$prevN = mktime(0, 0, 0, date("m"), date("d") - $n, date("Y"));
$mak   = date("Y-m-d");
$min   = date("Y-m-d", $prevN);

function format_mak($mak)
{
  $bulan = array (1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split = explode('-', $mak);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
function format_min($min)
{
  $bulan = array (1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split = explode('-', $min);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1>Kasir <small><?php include "../config/date-time.php";?></small></h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Kasir</li>
      </ol>  
      <?php include "../config/welcome.php"; ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped tablesorter">
              <thead>
                <tr>
                  <th><center>#</center></th>
                  <th><center>Status</center></th>
                  <th><center>No.Reg</center></th>
                  <th><center>Registrasi</center></th>
                  <th><center>No.RM</center></th>
                  <th><center>Nama Pasien</center></th>
                  <th><center>Unit</center></th>
                  <th><center>Dokter</center></th>
                  <th><center>Total</center></th>
                  <th colspan='2'><center>Action</center></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                $data = mysqli_query($koneksi,
                  "SELECT *, mr_pendaftaran.id_mr_pendaftaran, mr_pasien.nama_pasien, mr_dokter.nama_dokter, mr_unit.nama_unit, lab_trn.status_bayar AS status, lab_tarif.tarif
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
                  ORDER BY lab_trn.id_lab_trn ASC;");
                while($d = mysqli_fetch_array($data)){
                  $tanggal    = $d['tanggal'];
                  $tgl_lahir  = $d['tgl_lahir'];
                  ?>
                  <tr>
                    <td><center><?php echo $no++; ?></center></td>
                    <?php
                    if($d['status']=='1'){ ?>
                      <td><center><img class="img-responsive" src="../images/bayar1.png"></center></td>
                    <?php }else{ ?>
                      <td><center><img class="img-responsive" src="../images/bayar2.png"></center></td>
                    <?php }
                    ?>
                    <td><center><?php echo $d['id_mr_pendaftaran']; ?></center></td>
                    <td><center><?php echo date('d-m-Y', strtotime($tanggal)).' ('.$d['jam'].')'; ?></center></td>
                    <td><center><?php echo $d['id_catatan_medik']; ?></center></td>
                    <td><center><?php echo $d['nama_pasien']; ?></center></td>
                    <td><center><?php echo $d['nama_unit']; ?></center></td>
                    <td><center><?php echo $d['nama_dokter']; ?></center></td>
                    <td><center><?php echo number_format($d['total_bayar']); ?></center></td>
                    <?php
                    if($d['status_bayar']=='1'){ ?>
                      <td><center><a href="kasir-ubah-status-belum-bayar.php?id=<?php echo $d['id_lab_trn']; ?>"
                        <button type="button" class="btn btn-warning">Ubah</button></a></center></td>
                        <td><center><a href="kasir-print-nota.php?id=<?php echo $d['id_lab_trn']; ?>"
                          <button type="button" class="btn btn-primary"><i class='fa fa-print'></i></button></a></center></td>
                        <?php }else{ ?>
                          <td><center><a href="kasir-ubah-status-bayar.php?id=<?php echo $d['id_lab_trn']; ?>"
                            <button type="button" class="btn btn-warning">Ubah</button></a></center></td>
                            <td></td>
                          <?php }
                          ?>
                          </tr><?php } ?>
                        </tbody>
                      </table>
                    </div><!-- col-lg-12 -->
                  </div>
                </div>
              </div>
            </div><!-- /.row -->
          </div><!-- /#page-wrapper -->
          <?php include "views/footer.php"; ?>