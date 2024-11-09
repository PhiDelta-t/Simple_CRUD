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

// Mengambil data surat pengantar dari database
$sql = "SELECT * FROM surat_pengantar";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff Prodi</title>
</head>

<body>

    <h2>Dashboard Staff Prodi</h2>
    <!-- Tombol untuk Rekapitulasi -->
    <a href="rekapitulasi.php">
        <button>Rekapitulasi Pengajuan Judul</button>
    </a>
    <h3>Daftar Surat Pengantar Pembimbing</h3>

    <!-- Tabel Daftar Surat Pengantar -->
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>File Surat Pengantar</th>
                <th>Di-upload Oleh</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td><a href='{$row['file_path']}' target='_blank'>Lihat Surat</a></td>
                        <td>{$row['uploaded_by']}</td>
                        <td>{$row['upload_date']}</td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4'>Belum ada surat pengantar yang di-upload.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="upload_surat_pengantar.php">Upload Surat Pengantar Baru</a>

    <!-- Logout -->
    <a href="logout.php">Logout</a>

</body>

</html>

<?php
$conn->close();
?>