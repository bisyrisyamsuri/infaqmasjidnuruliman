<?php
require 'function/function.php';
session_start();
if (!isset($_SESSION['is_login'])) {
  header('Location: login.php');
}

$data = query('SELECT nama, alamat,status, latitude, longitude FROM tb_user');

$latitude = -8.9163742;
$longitude = 116.7478714;

// Periksa apakah parameter lat dan lng telah diberikan dalam URL
if (isset($_GET['lat']) && isset($_GET['lng'])) {
    // Jika iya, gunakan nilai yang diberikan dalam URL
    $latitude = $_GET['lat'];
    $longitude = $_GET['lng'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maps - Alert Infaq Masjid</title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.css">

  <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
  <style type="text/css">
    #map {
      float: right;
      width: 100%;
      height: 730px;
      border-radius: 10px;
    }

    #data tr td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
      cursor: pointer;
    }

    #data tr td:hover {
      background-color: #f5f5f5;
    }
  </style>
</head>

<body class="bg-primary text-white">
  <div id="app">
    <?php
    include 'views/sidebar.php'
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
              <h3>Maps Data Penginfaq</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
              <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Maps</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
        <section class="section">
          <div class="row">
            <div id="data" class="col-md-4"> <!-- Lebar data diatur di sini -->
              <div class="card">
                <div class="card-body">
                  <table class="table table-striped" id="table1">
                    <tbody>
                      <?php foreach ($data as $index => $key): ?>
                        <tr onclick="selectMarker(<?php echo $index; ?>)">
                          <td>
                            <?php echo $key['nama'] . '</br>' ?>
                            <?php if ($key['status'] == 'Hijau') {
                              ?>
                              <span class="badge bg-success">Hijau</span>
                              <?php
                            } elseif ($key['status'] == 'Kuning') {
                              ?>
                              <span class="badge bg-warning">Kuning</span>
                              <?php
                            } elseif ($key['status'] == 'Merah') {
                              ?>
                              <span class="badge bg-danger">Merah</span>
                              <?php
                            }
                            ; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-8"> <!-- Lebar peta diatur di sini -->
              <div id="map">
                <script async defer
                  src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initMap"></script>
                <script>
                  var map, markers, infoWindow;

                  var urlParams = new URLSearchParams(window.location.search);
                  var latitude = urlParams.get('lat');
                  var longitude = urlParams.get('lng');

                  function createMarker(data) {
                    var iconUrl;
                    switch (data.status.toLowerCase()) {
                      case 'hijau':
                        iconUrl = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
                        break;
                      case 'merah':
                        iconUrl = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
                        break;
                      case 'kuning':
                        iconUrl = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                        break;
                      default:
                        iconUrl = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'; // Default to blue
                        break;
                    }
                    var marker = new google.maps.Marker({
                      position: new google.maps.LatLng(data.latitude, data.longitude),
                      map: map,
                      title: data.alamat,
                      icon: iconUrl
                    });

                    marker.addListener("click", function () {
                      infoWindow.setContent(data.alamat + '<br><a href="javascript:void(0);" onclick="openInGoogleMaps(' + data.latitude + ',' + data.longitude + ')">Buka di Google Maps</a>');
                      infoWindow.open(map, marker);
                    });

                    return marker;
                  }

                  function openInGoogleMaps(lat, lng) {
                    window.open('https://www.google.com/maps/search/?api=1&query=' + lat + ',' + lng, '_blank');
                  }

                  function initMap() {
                    var defaultCenter = new google.maps.LatLng(-8.9163742, 116.7478714);
                    var defaultZoom = 12;

                    // Gunakan nilai default jika tidak ada latitude dan longitude dari URL
                    var center = latitude && longitude ? new google.maps.LatLng(latitude, longitude) : defaultCenter;
                    var zoom = latitude && longitude ? 18 : defaultZoom;

                    map = new google.maps.Map(document.getElementById("map"), {
                      center: center,
                      zoom: zoom
                    });

                    infoWindow = new google.maps.InfoWindow();

                    markers = [];
                    <?php foreach ($data as $d): ?>
                      markers.push(createMarker(<?php echo json_encode($d); ?>));
                    <?php endforeach; ?>
                  }

                  function selectMarker(index) {
                    var selectedMarker = markers[index];
                    map.setCenter(selectedMarker.getPosition());
                    map.setZoom(18);
                    google.maps.event.trigger(selectedMarker, 'click');
                  }

                  initMap();
                </script>
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

  <script src="assets/js/main.js"></script>
  <script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
  <script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
  </script>
</body>

</html>