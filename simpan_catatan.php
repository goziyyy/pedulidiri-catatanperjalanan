<?php
// Konfigurasi koneksi ke database
session_start();
$nik = $_SESSION['nik'];
$nama = $_SESSION['nama'];

$servername = "localhost"; // Ganti dengan nama host Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$dbname = "db-catatan"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menangkap data dari formulir HTML
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];
$lokasi = $_POST['lokasi'];
$suhu = $_POST['suhu'];

// Generate id_catatan secara acak
$idCatatan = rand(1, 1000);

// Memasukkan data ke dalam tabel kolom
$sql = "INSERT INTO catatan ( id_catatan, nik, nama, tanggal, waktu, lokasi, suhu) VALUES ( '$idCatatan', '$nik', '$nama', '$tanggal', '$waktu', '$lokasi', '$suhu')";

if ($conn->query($sql) === TRUE) {
    echo "Catatan berhasil disimpan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi ke database
$conn->close();
?>
