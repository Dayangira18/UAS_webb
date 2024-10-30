<?php
$host = 'localhost'; // replace with your host
$db   = 'uas_webb'; // replace with your database name
$user = 'root'; // replace with your database username
$pass = ''; // replace with your database password

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
