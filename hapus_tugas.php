<?php
// Mengimpor koneksi dan memulai session
include('koneksi.php');
session_start();

// Mengecek apakah pengguna sudah login sebagai mahasiswa
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'mahasiswa') {
    // Jika tidak login atau bukan mahasiswa, redirect ke halaman login
    header("Location: login.html");
    exit();
}

// Mengambil ID tugas akhir dari URL
$id = $_GET['id'];

// Menghapus data tugas akhir berdasarkan ID
$sql = "DELETE FROM tugas_akhir WHERE id = '$id' AND nim_mahasiswa = '" . $_SESSION['username'] . "'";

if ($conn->query($sql) === TRUE) {
    echo "Tugas akhir berhasil dihapus.";
    header("Location: mahasiswa_dashboard.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

<?php
// Menutup koneksi
$conn->close();
?>
