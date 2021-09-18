
<?php 
include '../config/connect.php';
$id_lab_trn = $_GET['id'];
$update=mysqli_query($koneksi,"UPDATE lab_trn SET status_bayar='0', selesai='0' WHERE id_lab_trn='$id_lab_trn'");
header("location:kasir-bayar.php");
?>