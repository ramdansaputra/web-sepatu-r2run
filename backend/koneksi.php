<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "r2run";


$koneksi = mysqli_connect($server, $username, $password, $database);

if ($koneksi) {
    echo "";
} else {
    echo "gagal terkoneksi ke database";
}
