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

// Mengambil ID tugas dari URL
if (isset($_GET['id'])) {
    $id_tugas = $_GET['id'];
} else {
    header("Location: mahasiswa_dashboard.php");
    exit();
}

// Proses upload bukti pembayaran
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["bukti_pembayaran"])) {
    $file_name = $_FILES["bukti_pembayaran"]["name"];
    $file_tmp = $_FILES["bukti_pembayaran"]["tmp_name"];
    $file_type = $_FILES["bukti_pembayaran"]["type"];
    $file_size = $_FILES["bukti_pembayaran"]["size"];

    // Tentukan folder upload
    $upload_dir = "uploads/";
    $upload_file = $upload_dir . basename($file_name);

    // Validasi file
    if ($file_size > 0 && $file_size < 5000000 && ($file_type == "image/jpeg" || $file_type == "image/png")) {
        // Pindahkan file ke folder upload
        if (move_uploaded_file($file_tmp, $upload_file)) {
            // Update database dengan bukti pembayaran
            $sql = "UPDATE tugas_akhir SET bukti_pembayaran = '$upload_file', status_pembayaran = 'sudah bayar' WHERE id = '$id_tugas'";

            if ($conn->query($sql) === TRUE) {
                echo "Bukti pembayaran berhasil di-upload dan status pembayaran diperbarui.";
                header("Location: mahasiswa_dashboard.php");
                exit();
            } else {
                echo "Gagal memperbarui status pembayaran: " . $conn->error;
            }
        } else {
            echo "Gagal meng-upload file. Pastikan ukuran dan format file sesuai.";
        }
    } else {
        echo "File tidak valid. Harap upload file dengan format JPG/PNG dan ukuran maksimal 5MB.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran</title>
</head>

<body>

    <h2>Upload Bukti Pembayaran</h2>

    <form action="upload_pembayaran.php?id=<?php echo $id_tugas; ?>" method="POST" enctype="multipart/form-data">
        <label for="bukti_pembayaran">Pilih Bukti Pembayaran:</label>
        <input type="file" name="bukti_pembayaran" required><br><br>

        <button type="submit">Upload</button>
    </form>

    <a href="mahasiswa_dashboard.php">Kembali ke Dashboard</a>

</body>

</html>

<?php
$conn->close();
?>