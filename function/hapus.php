<?php
// Perbaikan include path
include 'C:/xampp/htdocs/alertmasjid/function/function.php';

// Pastikan variabel $id telah didefinisikan dan bukan empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Lakukan sanitasi input ID
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Panggil fungsi hapus dengan parameter ID
    if (hapus($id) > 0) {
        echo "<script>alert('Data Berhasil Dihapus'); window.location = '../data-penginfaq.php';</script>";
    } else {
        echo "<script>alert('Data Gagal Dihapus'); window.location = '../data-penginfaq.php';</script>";
    }
} else {
    // Jika ID tidak ada atau kosong, tampilkan pesan kesalahan
    echo "<script>alert('ID tidak valid'); window.location = '../data-penginfaq.php';</script>";
}
?>
