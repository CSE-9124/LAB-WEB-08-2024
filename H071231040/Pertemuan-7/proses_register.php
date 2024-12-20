<?php
session_start(); // Mulai session untuk notifikasi
include 'conn.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah ada di database
    $query = $conn->prepare("SELECT * FROM users WHERE Username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    // Cek apakah name sudah ada di database
    $query1 = $conn->prepare("SELECT * FROM users WHERE Name = ?");
    $query1->bind_param("s",$name);
    $query1->execute();
    $result1 = $query1->get_result();

    if ($result->num_rows > 0) {
        // Jika username sudah ada, beri pesan error
        echo "Username sudah ada, coba buat yang lain!";
    } else if ($result1->num_rows > 0) {
            // Jika name sudah ada, beri pesan error
            echo "Name sudah ada, coba buat yang lain!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan data ke database
        $query = $conn->prepare("INSERT INTO users (Name, Username, Password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $name, $username, $hashed_password);

        if ($query->execute()) {
            // Jika berhasil, redirect ke halaman login
            $_SESSION['message'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
        } else {
            echo "Error: " . $query->error;
        }
    }

    $conn->close();
}
