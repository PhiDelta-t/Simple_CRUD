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

// Proses upload surat pengantar pembimbing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["surat_pengantar"])) {
    $file_name = $_FILES["surat_pengantar"]["name"];
    $file_tmp = $_FILES["surat_pengantar"]["tmp_name"];
    $file_type = $_FILES["surat_pengantar"]["type"];
    $file_size = $_FILES["surat_pengantar"]["size"];

    // Tentukan folder upload
    $upload_dir = "uploads/surat_pengantar/";

    // Cek jika folder uploads/surat_pengantar tidak ada, buat folder tersebut
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);  // Membuat folder dengan izin penuh
    }

    $upload_file = $upload_dir . basename($file_name);

    // Validasi file
    if ($file_size > 0 && $file_size < 5000000 && ($file_type == "application/pdf" || $file_type == "application/msword" || $file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
        // Pindahkan file ke folder upload
        if (move_uploaded_file($file_tmp, $upload_file)) {
            // Insert data surat pengantar ke database
            $sql = "INSERT INTO surat_pengantar (file_path, uploaded_by, upload_date) VALUES ('$upload_file', '$_SESSION[user_id]', NOW())";
            if ($conn->query($sql) === TRUE) {
                echo "Surat Pengantar Pembimbing berhasil di-upload.";
                header("Location: staff_dashboard.php"); // Redirect ke halaman dashboard staff
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Gagal meng-upload file. Pastikan folder upload memiliki izin yang benar.";
        }
    } else {
        echo "File tidak valid. Pastikan file berupa PDF atau DOC/DOCX dan ukuran sesuai.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Surat Pengantar Pembimbing</title>
</head>

<body>

    <h2>Upload Surat Pengantar Pembimbing</h2>

    <form action="upload_surat_pengantar.php" method="POST" enctype="multipart/form-data">
        <label for="surat_pengantar">Pilih Surat Pengantar (PDF/DOC/DOCX):</label>
        <input type="file" name="surat_pengantar" required><br><br>

        <button type="submit">Upload</button>
    </form>

    <a href="staff_dashboard.php">Kembali ke Dashboard</a>

</body>

</html>

<?php
$conn->close();
?>