<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kampus</title>
</head>

<body>

    <h2>Login Kampus</h2>

    <form action="login.php" method="POST">
        <label for="username">NIM / PID:</label><br>
        <input type="text" id="username" name="username" placeholder="Masukkan NIM (Mahasiswa) atau PID (Pegawai)" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <?php
    // Menampilkan pesan error jika login gagal
    if (isset($_GET['error']) && $_GET['error'] == 'true') {
        echo "<p style='color:red;'>Username atau password salah.</p>";
    }
    ?>

</body>

</html>