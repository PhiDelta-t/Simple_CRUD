<?php
// Koneksi ke database
$host = "localhost";  // Host database
$username = "root";   // Username database (default untuk localhost)
$password = "";       // Password database (default kosong untuk localhost)
$database = "Kampus"; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
