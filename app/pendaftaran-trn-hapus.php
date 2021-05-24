<?php 
include '../config/connect.php';
$id_mr_pendaftaran = $_GET['id'];
$hapus=mysqli_query($koneksi,"DELETE FROM mr_pendaftaran WHERE id_mr_pendaftaran='$id_mr_pendaftaran'");
if($hapus){
	echo "<script>alert('Berhasil Dihapus!!!');document.location='pendaftaran.php'</script>";
}else{
	echo "<script>alert('Gagal Hapus!!!');document.location='pendaftaran.php'</script>";
}
?>