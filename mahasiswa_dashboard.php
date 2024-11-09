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

// Mengambil data tugas akhir dari database
$sql = "SELECT * FROM tugas_akhir WHERE nim_mahasiswa = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);

// Menampilkan dashboard mahasiswa
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
</head>

<body>

    <h2>Dashboard Mahasiswa</h2>

    <!-- Tombol untuk Menambahkan Judul Tugas Akhir -->
    <a href="tambah_tugas.php">
        <button>Tambah Judul</button>
    </a>

    <!-- Tabel Daftar Tugas Akhir -->
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Abstrak</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    $status = $row['status'] ? $row['status'] : 'Diajukan';
                    $keterangan = $row['keterangan'] ? $row['keterangan'] : 'Tidak Ada Keterangan';

                    // Menampilkan data tugas akhir
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['judul']}</td>
                        <td>{$row['abstrak']}</td>
                        <td>{$status}</td>
                        <td>{$keterangan}</td>
                        <td>";

                    // Jika status tugas akhir adalah 'Diterima' dan belum ada bukti pembayaran
                    if ($status == 'Diterima') {
                        if (empty($row['bukti_pembayaran'])) {
                            // Tampilkan tombol upload bukti pembayaran
                            echo "<a href='upload_pembayaran.php?id={$row['id']}'>Upload Bukti Pembayaran</a>";
                        } else {
                            // Tampilkan status jika bukti pembayaran sudah ada
                            echo "Bukti Pembayaran Sudah Diupload";
                        }
                    } else {
                        // Jika status bukan diterima, tampilkan tombol edit dan hapus
                        echo "<a href='edit_tugas.php?id={$row['id']}'>Edit</a> | 
                            <a href='hapus_tugas.php?id={$row['id']}'>Hapus</a>";
                    }

                    echo "</td></tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data tugas akhir.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Logout -->
    <a href="logout.php">Logout</a>

</body>

</html>

<?php
$conn->close();
?>