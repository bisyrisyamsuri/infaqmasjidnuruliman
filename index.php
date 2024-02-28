<?php
require 'config/config.php';
require 'function/function.php';
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: login.php');
}

$data = query('SELECT * FROM tb_user ORDER BY id DESC LIMIT 4');

$query = "SELECT 
COUNT(*) AS jumlah_penginfaq,
SUM(CASE WHEN status = 'Hijau' THEN 1 ELSE 0 END) AS jumlah_hijau,
SUM(CASE WHEN status = 'Kuning' THEN 1 ELSE 0 END) AS jumlah_kuning,
SUM(CASE WHEN status = 'Merah' THEN 1 ELSE 0 END) AS jumlah_merah
FROM tb_user";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total = $row['jumlah_penginfaq'];
    $hijau = $row['jumlah_hijau'];
    $kuning = $row['jumlah_kuning'];
    $merah = $row['jumlah_merah'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Alert Infaq Masjid</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
</head>

<body class="bg-primary text-white">
    <?php include 'views/sidebar.php';
    ?>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="iconly-boldPlay"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Jumlah Badge Hijau</h6>
                                            <h6 class="font-extrabold mb-0">
                                                <?= $hijau ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldDanger"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Jumlah Badge Kuning</h6>
                                            <h6 class="font-extrabold mb-0">
                                                <?= $kuning ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon">
                                                <i class="iconly-boldClose-Square"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Jumlah Badge Merah</h6>
                                            <h6 class="font-extrabold mb-0">
                                                <?= $merah ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldPaper-Plus"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Jumlah Data Pengifaq</h6>
                                            <h6 class="font-extrabold mb-0">
                                                <?= $total ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h4>Data Penginfaq</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-lg">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Badge</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $row) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-bold-500">
                                                            <?= $row['nama'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $row['alamat'] ?>
                                                        </td>
                                                        <td class="text-bold-500">
                                                            <?= $row['status'] ?>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td class="text-bold-500">...</td>
                                                    <td>...</td>
                                                    <td class="text-bold-500">...</td>

                                                </tr>

                                            </tbody>
                                        </table>
                                        <a class="btn btn-info" href="data-penginfaq.php">
                                            Klik Untuk Data Lengkap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer>
            <?php
            include 'views/footer.php';
            ?>
        </footer>
    </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>