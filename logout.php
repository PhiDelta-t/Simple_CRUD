<?php
// Mulai session dan hapus semua session
session_start();
session_unset();  // Menghapus semua session
session_destroy(); // Menghancurkan session

// Redirect ke halaman login
header("Location: index.php");
exit();
