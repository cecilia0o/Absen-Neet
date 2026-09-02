<?php
$conn = mysqli_connect("localhost", "root", "", "neet");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>