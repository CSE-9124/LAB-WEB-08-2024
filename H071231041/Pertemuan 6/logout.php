<?php
session_start();

// Hapus semua session
session_unset();  // Menghapus semua variabel session
session_destroy();  // Menghancurkan session

// Redirect ke halaman login setelah logout
header("Location: login.php");
exit();