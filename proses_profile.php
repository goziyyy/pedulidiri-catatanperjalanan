<?php
// proses_profile.php

session_start(); // Mulai sesi

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header('Location: login.php');
    exit; // Hentikan skrip karena pengguna belum login
}

require_once 'config.php'; // Sertakan file konfigurasi database

// Ambil data pengguna dari database
$nik = $_SESSION['nik'];
$sql = "SELECT * FROM user WHERE nik = '$nik'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();

// Proses pengiriman foto profil
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto_profil"])) {
    $foto_profil = $_FILES["foto_profil"];
    $target_dir = "uploads/"; // Direktori tempat menyimpan foto profil
    $target_file = $target_dir . basename($foto_profil["name"]);

    // Pindahkan file foto profil yang diunggah ke direktori target
    if (move_uploaded_file($foto_profil["tmp_name"], $target_file)) {
        // Simpan nama file foto profil ke dalam database
        $sql = "UPDATE user SET foto_profil = '$target_file' WHERE nik = '$nik'";
        $conn->query($sql);
        // Redirect ke halaman profile setelah berhasil menyimpan foto profil
        header('Location: profile.php');
        exit;
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}
?>
