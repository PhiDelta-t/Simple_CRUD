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

// Mengambil data tugas akhir yang diajukan mahasiswa
$sql = "SELECT * FROM tugas_akhir WHERE status IS NULL OR status != 'Diterima'";  // Menampilkan tugas akhir yang statusnya belum ditentukan atau belum diterima
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen</title>
</head>

<body>

    <h2>Dashboard Dosen</h2>

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
            // Menampilkan data tugas akhir dalam tabel
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    // Menangani jika Status atau Keterangan bernilai NULL
                    $status = $row['status'] ? $row['status'] : 'Belum Ditentukan';
                    $keterangan = $row['keterangan'] ? $row['keterangan'] : 'Tidak Ada Keterangan';

                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['judul']}</td>
                        <td>{$row['abstrak']}</td>
                        <td>{$status}</td>
                        <td>{$keterangan}</td>
                        <td>
                            <form action='update_status_keterangan.php' method='POST'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <select name='status'>
                                    <option value='Belum Diajukan' " . ($row['status'] == 'Belum Diajukan' ? 'selected' : '') . ">Belum Diajukan</option>
                                    <option value='Diajukan' " . ($row['status'] == 'Diajukan' ? 'selected' : '') . ">Diajukan</option>
                                    <option value='Diterima' " . ($row['status'] == 'Diterima' ? 'selected' : '') . ">Diterima</option>
                                    <option value='Ditolak' " . ($row['status'] == 'Ditolak' ? 'selected' : '') . ">Ditolak</option>
                                </select>
                                <textarea name='keterangan' placeholder='Masukkan keterangan'>{$row['keterangan']}</textarea>
                                <button type='submit'>Update Status dan Keterangan</button>
                            </form>
                        </td>
                      </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada tugas akhir untuk diperiksa.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Logout -->
    <a href="logout.php">Logout</a>

</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>