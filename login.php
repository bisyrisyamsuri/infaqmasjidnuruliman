<?php
include 'config/config.php';
session_start();
$login_msg = '';

if (isset($_SESSION['is_login'])) {
    header('Location: index.php');
}

if (isset($_POST['submit'])) {
    mysqli_query($conn, "UPDATE tb_user SET pembayaran = 'Bayar', status = 'Hijau' WHERE DATEDIFF(NOW(), tgl_peng) <= 15");


    mysqli_query($conn, "UPDATE tb_user SET pembayaran = 'Belum Bayar', status = 'Kuning' WHERE DATEDIFF(NOW(), tgl_peng) BETWEEN 16 AND 29");


    mysqli_query($conn, "UPDATE tb_user SET pembayaran = 'Belum Bayar', status = 'Merah' WHERE DATEDIFF(NOW(), tgl_peng) >= 30");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM tb_login WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['is_login'] = true;
        ?>
        <script>
            alert("Anda Berhasil Login!")
            window.location = "index.php";
        </script>
        <?php
    } else {
        $login_msg = 'Data yang anda masukkan salah';
    }
    $conn->close();
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

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>Login</h3>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="row">
                    <!-- // Basic Vertical form layout section end -->
                </div>
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-vertical" action="login.php" method="post">
                                                <div class="form-body">
                                                    <i class="text-danger">
                                                        <?= $login_msg ?>
                                                    </i>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="first-name-icon">Username</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukkan Username" name="username"
                                                                        required>
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-person"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="first-name-icon">Password</label>
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Masukkan Password" name="password"
                                                                        required>
                                                                    <div class="form-control-icon">
                                                                        <i class="bi bi-key"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1"
                                                                name="submit">Submit</button>
                                                            <button type="reset"
                                                                class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer>
            <?php include 'views/footer.php';
            ?>
        </footer>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>