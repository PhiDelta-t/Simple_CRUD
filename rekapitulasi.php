<?php
// Mengimpor koneksi dan memulai session
include('koneksi.php');
session_start();

// Mengecek apakah pengguna sudah login sebagai staff prodi
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'staff') {
    // Jika tidak login atau bukan staff, redirect ke halaman login
    header("Location: login.html");
    exit();
}

// Mengambil jumlah tugas akhir yang diterima
$sql_terima = "SELECT COUNT(*) AS diterima FROM tugas_akhir WHERE status = 'Diterima'";
$result_terima = $conn->query($sql_terima);
if ($result_terima) {
    $terima = $result_terima->fetch_assoc();
} else {
    echo "Error executing query for diterima: " . $conn->error;
}

// Mengambil jumlah tugas akhir yang sudah bayar
$sql_bayar = "SELECT COUNT(*) AS bayar FROM tugas_akhir WHERE status_pembayaran = 'sudah bayar'";
$result_bayar = $conn->query($sql_bayar);
if ($result_bayar) {
    $bayar = $result_bayar->fetch_assoc();
} else {
    echo "Error executing query for bayar: " . $conn->error;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Pengajuan Judul</title>
</head>

<body>

    <h2>Rekapitulasi Pengajuan Judul dan Pembayaran</h2>

    <!-- Menampilkan Rekapitulasi -->
    <table border="1">
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Judul Diterima</td>
                <td><?php echo $terima['diterima']; ?></td>
            </tr>
            <tr>
                <td>Judul Sudah Melakukan Pembayaran</td>
                <td><?php echo $bayar['bayar']; ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Tombol untuk Kembali ke Dashboard Staff -->
    <a href="staff_dashboard.php">
        <button>Kembali ke Dashboard</button>
    </a>

</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>