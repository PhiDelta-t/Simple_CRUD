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

// Mengambil data tugas akhir berdasarkan ID
$sql = "SELECT * FROM tugas_akhir WHERE id = '$id' AND nim_mahasiswa = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);

// Mengecek apakah data ditemukan
if ($result->num_rows == 0) {
    echo "Data tugas akhir tidak ditemukan.";
    exit();
}

$row = $result->fetch_assoc();

// Proses pengiriman formulir (update tugas akhir)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $abstrak = $_POST['abstrak'];

    // Update data tugas akhir
    $sql = "UPDATE tugas_akhir SET judul = '$judul', abstrak = '$abstrak' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data tugas akhir berhasil diupdate.";
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
    <title>Edit Tugas Akhir</title>
</head>

<body>

    <h2>Edit Tugas Akhir</h2>

    <form action="edit_tugas.php?id=<?php echo $id; ?>" method="POST">
        <label for="judul">Judul:</label><br>
        <input type="text" id="judul" name="judul" value="<?php echo $row['judul']; ?>" required><br><br>

        <label for="abstrak">Abstrak:</label><br>
        <textarea id="abstrak" name="abstrak" required><?php echo $row['abstrak']; ?></textarea><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="mahasiswa_dashboard.php">Kembali ke Dashboard</a>

</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>