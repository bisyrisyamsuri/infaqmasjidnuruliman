<?php
require 'config/config.php';

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

    $locationData = getLocationData($alamat);

    $sql = "INSERT INTO tb_user (nama, nik, telp, alamat, tgl_peng, gmbrRmh, longitude, latitude) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssdd", $username, $nik, $telp, $alamat, $tgl_peng, $gambar, $locationData['longitude'], $locationData['latitude']);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}

function getLocationData($address)
{
    $apiKey = "APIKEY";
    $encodedAddress = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encodedAddress}&key={$apiKey}";

    $response = file_get_contents($url);
    $responseData = json_decode($response, true);

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
    $file_ext = explode('.', $namaFile);
    $file_ext = strtolower(end($file_ext));

    if (!in_array($file_ext, $extensions)) {
        echo " <script>
            alert('Perhatikan Ekstensi!!');
        </script>";
        return false;
    }
    if ($file_size > 7340032) {
        echo " <script>
            alert('Ukuran Harus 7 Mb atau kurang');
        </script>";
        return false;
    }

    $namaFilebaru = uniqid() . '.' . $file_ext;

    if (move_uploaded_file($file_tmp, "uploads/" . $namaFilebaru)) {
        return $namaFilebaru;
    } else {
        return false;
    }
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

    $sql = "UPDATE tb_user SET nama = ?, tgl_peng = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $username, $tgl_peng, $id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}
?>
