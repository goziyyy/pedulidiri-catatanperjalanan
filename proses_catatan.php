<?php
// Hubungkan ke database
session_start();
$nik = $_SESSION['nik'];
$nama = $_SESSION['nama'];
$koneksi = mysqli_connect("localhost", "username", "password", "db_catatan");

// Periksa koneksi
if (mysqli_connect_errno()) {
  echo "Koneksi database gagal: " . mysqli_connect_error();
  exit();
}

// Ambil nilai dari formulir
$nik = $_POST['nik'];
$nama = $_POST['nama'];
// Ambil nilai untuk kolom lainnya

// SQL untuk menyimpan data ke database
$sql = "INSERT INTO catatan (nik, nama, tanggal, waktu, lokasi, suhu) VALUES ('$nik', '$nama', '$tanggal', '$waktu', '$lokasi', '$suhu')";

// Eksekusi query
if (mysqli_query($koneksi, $sql)) {
  echo "Catatan berhasil ditambahkan.";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
