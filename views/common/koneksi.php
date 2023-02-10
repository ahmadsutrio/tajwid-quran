<?php
function koneksi()
{
    $servername = 'localhost';
    $database = 'qurandantajwid';
    $username = 'root';
    $password = '';

    $conn       = mysqli_connect($servername, $username, $password, $database);
    // mengecek koneksi
    if (!$conn) {
        die("connnection failed." . mysqli_connect_error());
        echo "gagal";
    }
    return $conn;
}
?>