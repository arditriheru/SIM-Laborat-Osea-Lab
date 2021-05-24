<?php 
include '../config/connect.php';
$id_lab_trn_hasil = $_GET['id'];
$id_lab_trn = $_GET['no'];
$hapus=mysqli_query($koneksi,"DELETE FROM lab_trn_hasil WHERE id_lab_trn_hasil='$id_lab_trn_hasil'");
if($hapus){
	echo "<script>alert('Berhasil Dihapus!!!');document.location='trn-detail.php?id=$id_lab_trn'</script>";
}else{
	echo "<script>alert('Gagal Hapus!!!');document.location='trn-detail.php?id=$id_lab_trn'</script>";
}
?>