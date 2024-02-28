<?php
include 'C:/xampp/htdocs/alertmasjid/config/config.php';

function query($data)
{
    global $conn;
    $result = mysqli_query($conn, $data);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;

    $username = htmlspecialchars($data['username']);
    $nik = htmlspecialchars($data['nik']);
    $telp = htmlspecialchars($data['telp']);
    $alamat = htmlspecialchars($data['alamat']);
    $tgl_peng = htmlspecialchars($data['tgl_peng']);

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // Mengambil data longitude dan latitude dari fungsi geocoder
    $locationData = getLocationData($alamat);

    // Menyimpan data ke dalam database
    $sql = "INSERT INTO tb_user (nama, nik, telp, alamat, tgl_peng, gmbrRmh, longitude, latitude) 
            VALUES ('$username', '$nik','$telp', '$alamat', '$tgl_peng','$gambar', '{$locationData['longitude']}', '{$locationData['latitude']}')";
    
    mysqli_query($conn, $sql);

    // Mengembalikan jumlah baris yang terpengaruh oleh operasi insert
    return mysqli_affected_rows($conn);
}

// Fungsi untuk mendapatkan data longitude dan latitude dari alamat menggunakan Google Geocoding API
function getLocationData($address)
{
    $apiKey = "AIzaSyA3bsDl1xddiU_w38hA-fsGea8kWsp5uJM"; // Ganti dengan kunci API Google Maps Anda
    $encodedAddress = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encodedAddress}&key={$apiKey}";

    $response = file_get_contents($url);
    $responseData = json_decode($response, true);

    // Menangani respons dari Google Geocoding API
    $locationData = array();
    if ($responseData['status'] === 'OK') {
        $location = $responseData['results'][0]['geometry']['location'];
        $locationData['latitude'] = $location['lat'];
        $locationData['longitude'] = $location['lng'];
    }

    return $locationData;
}



function upload()
{
    $namaFile = $_FILES['grumah']['name'];
    $file_size = $_FILES['grumah']['size'];
    $file_error = $_FILES['grumah']['error'];
    $file_tmp = $_FILES['grumah']['tmp_name'];

    if ($file_error === 4) {
        echo " <script>
            alert('Pilih gambar terlebih dahulu');
        </script>";
        return false;
    }

    $extensions = ["jpeg", "jpg", "png"];
    $file_ext = strtolower(end(explode('.', $namaFile)));

    if (!in_array($file_ext, $extensions)) {
        echo " <script>
            alert('Perhatikan Ekstensi!!');
        </script>";
        return false;
    }
    if ($file_size > 2097152) {
        echo " <script>
            alert('Ukuran Harus 2 Mb');
        </script>";
        return false;
    }

    $namaFilebaru = uniqid();
    $namaFilebaru .= '.';
    $namaFilebaru .= $file_ext;

    move_uploaded_file($file_tmp, "uploads/" . $namaFilebaru);

    return $namaFilebaru;

}


function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_user WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;

    $id = $data['id'];
    $username = htmlspecialchars($data['username']);
    $tgl_peng = htmlspecialchars($data['tgl_peng']);
    // $status = $data['xbayar'];

    $sql = "UPDATE tb_user SET nama = '$username', tgl_peng = '$tgl_peng' WHERE id = $id";
    mysqli_query($conn, $sql);



    return mysqli_affected_rows($conn);

}
?>