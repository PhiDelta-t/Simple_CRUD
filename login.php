<?php
// Mengimpor file koneksi.php
include('koneksi.php');
session_start(); // Mulai sesi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];  // Bisa berupa NIM atau PID
    $password = $_POST['password'];

    // Cek login mahasiswa
    $sql_mahasiswa = "SELECT * FROM mahasiswa WHERE nim = '$username' AND password = '$password'";
    $result_mahasiswa = $conn->query($sql_mahasiswa);

    if ($result_mahasiswa->num_rows > 0) {
        // Jika ditemukan di tabel mahasiswa
        $user = $result_mahasiswa->fetch_assoc();
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['nim'];  // NIM untuk mahasiswa
        $_SESSION['role'] = 'mahasiswa';      // Role mahasiswa
        $_SESSION['username'] = $user['nim']; // Username (NIM)

        header("Location: mahasiswa_dashboard.php"); // Ganti dengan halaman dashboard mahasiswa
        exit();
    } else {
        // Jika bukan mahasiswa, cek di tabel pegawai
        $sql_pegawai = "SELECT * FROM pegawai WHERE pid = '$username' AND password = '$password'";
        $result_pegawai = $conn->query($sql_pegawai);

        if ($result_pegawai->num_rows > 0) {
            $user = $result_pegawai->fetch_assoc();

            // Cek peran pengguna
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['pid'];   // PID untuk pegawai
            $_SESSION['role'] = $user['role'];     // Role (dosen/staff)
            $_SESSION['username'] = $user['pid'];  // Username (PID)

            if ($user['role'] == 'dosen') {
                header("Location: dosen_dashboard.php"); // Ganti dengan halaman dashboard dosen
                exit();
            } elseif ($user['role'] == 'staff') {
                header("Location: staff_dashboard.php"); // Ganti dengan halaman dashboard staff
                exit();
            }
        } else {
            // Login gagal
            header("Location: login.html?error=true");
            exit();
        }
    }
}

// Menutup koneksi
$conn->close();
