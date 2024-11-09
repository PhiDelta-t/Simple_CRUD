<?php
// Mengimpor koneksi dan memulai session
include('koneksi.php');
session_start();

// Mengecek apakah pengguna sudah login sebagai dosen
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'dosen') {
    // Jika tidak login atau bukan dosen, redirect ke halaman login
    header("Location: login.html");
    exit();
}

// Mengambil ID, status, dan keterangan dari form
$id = $_POST['id'];
$status = $_POST['status'];
$keterangan = $_POST['keterangan'];

// Update status dan keterangan tugas akhir
$sql = "UPDATE tugas_akhir SET status = '$status', keterangan = '$keterangan' WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo "Status dan keterangan tugas akhir berhasil diupdate.";
    header("Location: dosen_dashboard.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

<?php
// Menutup koneksi
$conn->close();
?>
