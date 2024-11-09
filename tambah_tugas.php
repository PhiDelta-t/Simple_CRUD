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

// Proses pengiriman formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $abstrak = $_POST['abstrak'];
    $nim_mahasiswa = $_SESSION['username'];

    // Status dan Keterangan diatur NULL oleh default
    $status = NULL;
    $keterangan = NULL;

    // Menyimpan data tugas akhir ke database
    $sql = "INSERT INTO tugas_akhir (judul, abstrak, status, keterangan, nim_mahasiswa) 
            VALUES ('$judul', '$abstrak', NULL, NULL, '$nim_mahasiswa')";

    if ($conn->query($sql) === TRUE) {
        echo "Data tugas akhir berhasil ditambahkan.";
        header("Location: mahasiswa_dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Judul Tugas Akhir</title>
</head>

<body>

    <h2>Tambah Judul Tugas Akhir</h2>

    <form action="tambah_tugas.php" method="POST">
        <label for="judul">Judul:</label><br>
        <input type="text" id="judul" name="judul" required><br><br>

        <label for="abstrak">Abstrak:</label><br>
        <textarea id="abstrak" name="abstrak" required></textarea><br><br>

        <!-- Status dan Keterangan tidak perlu diisi oleh mahasiswa, biarkan NULL -->
        <input type="hidden" name="status" value="NULL">
        <input type="hidden" name="keterangan" value="NULL">

        <button type="submit">Simpan</button>
    </form>

    <a href="mahasiswa_dashboard.php">Kembali ke Dashboard</a>

</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>