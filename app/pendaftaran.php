<?php include "views/header.php"; ?>
<nav>
  <div id="wrapper">
    <?php include "menu.php"; ?>
  </div><!-- /.navbar-collapse -->
</nav>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1>Pendaftaran <small><?php include "../config/date-time.php";?></small></h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-check-square-o"></i> Pendaftaran</li>
      </ol>  
      <?php include "../config/welcome.php"?>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <ul class="nav nav-pills" style="margin-bottom: 15px;">
        <li class="active"><a href="#1" data-toggle="tab">Pasien Lama</a></li>
        <li><a href="#2" data-toggle="tab">Pasien Baru</a></li>
      </ul>
    </div><br>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="1">
        <div class="col-lg-4">
          <form method="post" action="" role="form">
            <div class="form-group">
              <label>Nomor Rekam Medik</label>
              <input class="form-control" type="text" onkeyup="isi_otomatis()" id="id_catatan_medik"
              placeholder="Silahkan Masukkan.." name="id_catatan_medik" required="">
            </div>
            <div class="form-group">
              <label>Nama Pasien</label>
              <input class="form-control" type="text" id="nama_pasien" name="nama_pasien" 
              placeholder="Nama Pasien" readonly>
            </div>
            <div class="form-group">
              <label>Nama Dokter</label>
              <select class="form-control" type="text" name="id_dokter"
              value="<?php echo $d['id_dokter']; ?>" required="">
              <option value="">Pilih</option>
              <?php 
              $data = mysqli_query($koneksi,
                "SELECT id_dokter, nama_dokter FROM mr_dokter;");
              while($d = mysqli_fetch_array($data)){
                echo "<option value='".$d['id_dokter']."'>".$d['nama_dokter']."</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" name="tambahlamasubmit" class="btn btn-primary">Daftar</button>
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript">
          function isi_otomatis(){
            var id_catatan_medik = $("#id_catatan_medik").val();
            $.ajax({
              url: 'pendaftaran-con.php',
              data:"id_catatan_medik="+id_catatan_medik ,
            }).success(function (data) {
              var json = data,
              obj = JSON.parse(json);
              $('#nama_pasien').val(obj.nama_pasien);
            });
          }
        </script>
        <?php
        if(isset($_POST['tambahlamasubmit'])){
          $id_catatan_medik = $_POST['id_catatan_medik'];
          $id_dokter        = $_POST['id_dokter'];
          $selesai          = 0;

          $cek = mysqli_query($koneksi,
            "SELECT COUNT(id_catatan_medik) AS cek FROM mr_pasien WHERE id_catatan_medik = '$id_catatan_medik'");
          while($d = mysqli_fetch_array($cek)){
            $cek    = $d['cek'];
          }

          if($cek>0){
            $simpan=mysqli_query($koneksi,"INSERT INTO mr_pendaftaran (id_mr_pendaftaran, id_catatan_medik, id_dokter, tanggal, jam, selesai)VALUES('','$id_catatan_medik','$id_dokter','$tanggalsekarang','$jamsekarang','$selesai')");
            if($simpan){
              echo '<script>
              setTimeout(function() {
                swal({
                  title: "Sukses",
                  text: "Mendaftarkan Pasien",
                  type: "success"
                  }, function() {
                    window.location = "pendaftaran.php";
                    });
                    }, 10);
                    </script>';
                  }else{
                    echo '<script>
                    setTimeout(function() {
                      swal({
                        title: "Upss..",
                        text: "Coba Sekali Lagi",
                        type: "error"
                        }, function() {
                          window.location = "pendaftaran.php";
                          });
                          }, 10);
                          </script>';
                        }
                      }else{
                       echo '<script>
                       setTimeout(function() {
                        swal({
                          title: "Upss..",
                          text: "Nomor RM Tidak Ditemukan",
                          type: "error"
                          }, function() {
                            window.location = "pendaftaran.php";
                            });
                            }, 10);
                            </script>';
                          }

                        }
                        ?>
                      </div>
                    </div>
                    <div class="tab-pane fade in" id="2">
                      <div class="col-lg-4">
                        <?php
                        if(isset($_POST['tambahbarusubmit'])){
                          $a=mysqli_query($koneksi,"SELECT MAX(id_catatan_medik) AS max FROM mr_pasien");
                          while($b = mysqli_fetch_array($a)){
                            $id_catatan_medik = $b['max']+1;
                          }
                          $nama_pasien        = $_POST['nama_pasien'];
                          $tempat             = $_POST['tempat'];
                          $tgl_lahir          = $_POST['tgl_lahir'];
                          $sex                = $_POST['sex'];
                          $alamat             = $_POST['alamat'];
                          $kelurahan          = $_POST['kelurahan'];
                          $kecamatan          = $_POST['kecamatan'];
                          $kabupaten          = $_POST['kabupaten'];
                          $telp               = $_POST['telp'];
                          $email              = $_POST['email'];

                          if (empty($id_catatan_medik))
                            exit;

                        //menampilkan file image barcode
                          echo '<img src="../vendors/barcode/barcode.php?text=' . $id_catatan_medik . '&print=true&size=65" />';

                        //buat folder untuk simpan file image
                          $tempdir = "../images/imagesbarcode/";
                          if (!file_exists($tempdir))
                            mkdir($tempdir, 0755);

                          $target_path = $tempdir . $id_catatan_medik . ".png";

                        //cek apakah server menggunakan http atau https
                          $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';

                        //url file image barcode 
                          $fileImage = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../vendors/barcode/barcode.php?text=" . $id_catatan_medik . "&print=true&size=65";

                        //ambil gambar barcode dari url diatas
                          $content = file_get_contents($fileImage);

                        //simpan gambar
                          file_put_contents($target_path, $content);

                          $simpan=mysqli_query($koneksi,"INSERT INTO mr_pasien (id_pasien, id_catatan_medik, nama_pasien, sex, tempat, tgl_lahir, alamat, kabupaten, kecamatan, kelurahan, telp, email)VALUES('','$id_catatan_medik','$nama_pasien','$sex','$tempat','$tgl_lahir','$alamat','$kabupaten','$kecamatan','$kelurahan','$telp','$email')");
                          if($simpan){
                            echo '<script>
                            setTimeout(function() {
                              swal({
                                title: "Sukses",
                                text: "Menambah Pasien Baru",
                                type: "success"
                                }, function() {
                                  window.location = "pendaftaran.php";
                                  });
                                  }, 10);
                                  </script>';
                                }else{
                                  echo '<script>
                                  setTimeout(function() {
                                    swal({
                                      title: "Upss..",
                                      text: "Coba Sekali Lagi",
                                      type: "error"
                                      }, function() {
                                        window.location = "pendaftaran.php";
                                        });
                                        }, 10);
                                        </script>';
                                      }
                                    }
                                    ?>
                                    <form method="post" action="" role="form">
                                      <?php 
                                      $a = mysqli_query($koneksi,
                                        "SELECT MAX(id_catatan_medik) AS maxrm FROM mr_pasien;");
                                        while($b = mysqli_fetch_array($a)){ ?>
                                          <div class="form-group">
                                            <label>Nomor Rekam Medik</label>
                                            <input class="form-control" type="text" name="id_catatan_medik" value="<?php echo $b['maxrm']+1; ?>" readonly="">
                                            </div><?php } ?>
                                            <div class="form-group">
                                              <label>Nama Pasien</label>
                                              <input class="form-control" type="text" name="nama_pasien" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Tempat Lahir</label>
                                              <input class="form-control" type="text" name="tempat" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Tanggal Lahir</label>
                                              <input class="form-control" type="date" name="tgl_lahir" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Jenis Kelamin</label>
                                              <select class="form-control" type="text" name="sex" required="">
                                                <option value="">Pilih</option>
                                                <option value='1'>Laki-laki</option>
                                                <option value='2'>Perempuan</option>"
                                              </select>
                                            </div>
                                            <div class="form-group">
                                              <label>Alamat</label>
                                              <input class="form-control" type="text" name="alamat" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Kelurahan</label>
                                              <input class="form-control" type="text" name="kelurahan" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Kecamatan</label>
                                              <input class="form-control" type="text" name="kecamatan" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Kabupaten</label>
                                              <input class="form-control" type="text" name="kabupaten" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Kontak</label>
                                              <input class="form-control" type="number" name="telp" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <div class="form-group">
                                              <label>Email</label>
                                              <input class="form-control" type="text" name="email" placeholder="Silahkan Masukkan.." required="">
                                            </div>
                                            <button type="submit" name="tambahbarusubmit" class="btn btn-primary">Tambah</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-lg-8">
                                      <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped tablesorter">
                                          <thead>
                                            <tr>
                                              <th><center>#</center></th>
                                              <th><center>No.Reg</center></th>
                                              <th><center>No.RM</center></th>
                                              <th><center>Nama Pasien</center></th>
                                              <th><center>Unit</center></th>
                                              <th><center>Dokter</center></th>
                                              <th colspan='2'><center>Action</center></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php 
                                            $no = 1;
                                            $data = mysqli_query($koneksi,
                                              "SELECT *, mr_pendaftaran.selesai AS stsprint, mr_pasien.nama_pasien, mr_pasien.tempat, mr_pasien.tgl_lahir, mr_dokter.nama_dokter, mr_unit.nama_unit
                                              FROM mr_pendaftaran
                                              INNER JOIN mr_pasien
                                              ON mr_pendaftaran.id_catatan_medik=mr_pasien.id_catatan_medik
                                              INNER JOIN mr_dokter
                                              ON mr_pendaftaran.id_dokter=mr_dokter.id_dokter
                                              INNER JOIN mr_unit
                                              ON mr_dokter.id_unit=mr_unit.id_unit
              -- WHERE mr_pendaftaran.selesai='0'
              ORDER BY mr_pendaftaran.id_mr_pendaftaran ASC;");
                                            while($d = mysqli_fetch_array($data)){
                                              $tanggal    = $d['tanggal'];
                                              $tgl_lahir  = $d['tgl_lahir'];
                                              ?>
                                              <tr>
                                                <td><center><?php echo $no++; ?></center></td>
                                                <td><center><?php echo $d['id_mr_pendaftaran']; ?></center></td>
                                                <td><center><?php echo $d['id_catatan_medik']; ?></center></td>
                                                <td><center><?php echo $d['nama_pasien']; ?></center></td>
                                                <td><center><?php echo $d['nama_unit']; ?></center></td>
                                                <td><center><?php echo $d['nama_dokter']; ?></center></td>
                                                <td>
                                                  <div align="center">
                                                    <a href="laborat-tambah-form.php?id=<?php echo $d['id_mr_pendaftaran']; ?>"
                                                      <button type="button" class="btn btn-success"><i class='fa fa-edit'></i></button></a>
                                                    </div>
                                                  </td>
                                                  </tr><?php } ?>
                                                </tbody>
                                              </table>
                                            </div><!-- col-lg-12 -->
                                          </div>
                                        </div>
                                      </div><!-- /#page-wrapper -->
                                      <?php include "views/footer.php"; ?>