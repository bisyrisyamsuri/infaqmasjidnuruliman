<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db_name = 'db_infaq';

$conn = mysqli_connect($hostname, $username, $password, $db_name);

if ($conn->connect_error){
    echo mysqli_error($conn);
    die();
}

?>