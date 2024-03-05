<?php
include 'function/function.php';
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: login.php');
}

if (isset($_POST['submit'])) {
    if (tambah($_POST) > 0) {
        ?>
        <script>
            alert("Data berhasil masuk")
            window.location = "data-penginfaq.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Data tidak masuk, mohon di cek kembali!")
            window.location = "form-warga.php";
        </script>
        <?php
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penginfaq - Alert Infaq Masjid</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/summernote/summernote-lite.min.css">

    <link rel="stylesheet" href="assets/vendors/toastify/toastify.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>

    <!-- Special version of Bootstrap that is isolated to content wrapped in .bootstrap-iso -->
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <script
        src="https://maps.googleapis.com/maps/api/js?key=APIKEY&libraries=places"></script>

    <!--Font Awesome (added because you use icons in your prepend/append)-->
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
                            <h3>Form Data Penginfaq</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Form Penginfaq</li>
                                </ol>
                            </nav>
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
                                                <form class="form form-vertical" action="form-warga.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group has-icon-left">
                                                                    <label for="first-name-icon">Nama</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Masukkan Nama Lengkap"
                                                                            name="username" required>
                                                                        <div class="form-control-icon">
                                                                            <i class="bi bi-person"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group has-icon-left">
                                                                    <label for="first-name-icon">NIK</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Masukkan NIK" name="nik"
                                                                            value="-">
                                                                        <div class="form-control-icon">
                                                                            <i class="bi bi-credit-card"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group has-icon-left">
                                                                    <label for="first-name-icon">No. Telepon(WA)</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Masukkan No.Telp" name="telp"
                                                                            required>
                                                                        <div class="form-control-icon">
                                                                            <i class="bi bi-telephone"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group has-icon-left">
                                                                    <label for="first-name-icon">Alamat
                                                                        Penginfaq</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Masukkan Alamat Penginfaq"
                                                                            name="alamat" id="alamat" required>
                                                                        <div class="form-control-icon">
                                                                            <i class="bi bi-geo"></i>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary mt-1"
                                                                        onclick="getCurrentLocation()">Ambil Lokasi
                                                                        Saya</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="first-name-icon">Gambar Rumah</label>
                                                                    <small class="text-danger">jpg | jpeg | png</small>
                                                                    <div class="position-relative">
                                                                        <input type="file" class="form-control"
                                                                            placeholder="Masukkan Gambar Rumah"
                                                                            name="grumah">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group has-icon-left">
                                                                    <label for="first-name-icon">Tgl Awal Infaq</label>
                                                                    <div class="position-relative">
                                                                        <input type="date" class="form-control"
                                                                            placeholder="Masukkan Tgl Awal Infaq"
                                                                            name="tgl_peng" required>
                                                                        <div class="form-control-icon">
                                                                            <i class="bi bi-calendar-event"></i>
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
    </div>
    <script>
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        document.getElementById('alamat').value = results[0].formatted_address;
                    } else {
                        alert('Alamat tidak ditemukan');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        }
    </script>
</body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/vendors/jquery/jquery.min.js"></script>
    <script src="assets/js/main.js"></script>
</html>