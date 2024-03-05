<?php
include 'function/function.php';
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: login.php');
}
$data = query('SELECT * FROM tb_user');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penginfaq - Alert Infaq Masjid</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
</head>

<body class="bg-primary text-white">
    <div id="app">
        <?php
        include 'views/sidebar.php';
        ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Data Penginfaq</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Penginfaq</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>No.Telp</th>
                                        <th>Alamat</th>
                                        <th>Gambar Rumah</th>
                                        <th>Tgl Pemberian Celengan</th>
                                        <th>Badge</th>
                                        <th>Status Celengan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($data as $row):
                                        $no++;
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $no ?>
                                            </td>
                                            <td>
                                                <a style="color: black;"
                                                    href="maps-google.php?lat=<?= $row['latitude'] ?>&lng=<?= $row['longitude'] ?>">
                                                    <?= $row['nama'] ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?= $row['nik']; ?>
                                            </td>
                                            <td>
                                                <?= $row['telp']; ?>
                                            </td>
                                            <td>
                                                <?= $row['alamat'] ?>
                                            </td>
                                            <td>
                                                <img src="assets/images/lazy.png" data-src="uploads/<?= $row['gmbrRmh']; ?>"
                                                    alt="Gambar" loading="lazy" width="100">
                                            </td>
                                            <td>
                                                <?= $row['tgl_peng'] ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($row['status'] == 'Hijau') {
                                                    ?>
                                                    <span class="badge bg-success">Hijau</span>
                                                    <?php
                                                } elseif ($row['status'] == 'Kuning') {
                                                    ?>
                                                    <span class="badge bg-warning">Kuning</span>
                                                    <?php
                                                } elseif ($row['status'] == 'Merah') {
                                                    ?>
                                                    <span class="badge bg-danger">Merah</span>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($row['pembayaran'] == 'Bayar') {
                                                    ?>
                                                    Sudah Diambil
                                                    <?php
                                                } elseif ($row['pembayaran'] == 'Belum Bayar') {
                                                    ?>
                                                    <a class="btn btn-outline-primary"
                                                        href="update_data.php?id=<?= $row['id'] ?>">
                                                        Belum Diambil
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" href="function/hapus.php?id=<?= $row['id'] ?>"
                                                    onclick="return confirm('Data Ini Akan di Hapus?');">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
            </div>
            <footer>
                <?php include 'views/footer.php';
                ?>
            </footer>
        </div>
    </div>
</body>
<script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
<script src="assets/js/main.js"></script>

</html>