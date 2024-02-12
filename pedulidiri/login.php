<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];

    $sql = "SELECT * FROM user WHERE nik='$nik'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($nama === $row['nama']) {
            $_SESSION['nik'] = $nik;
            header('Location: dashboard.php');
        } else {
            $_SESSION['message'] = "Nama Anda Salah / Tidak Ada!";
        }
    } else {
        $_SESSION['message'] = "NIK Tidak Ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl mb-4">Login</h2>
        <form action="" method="post">
            <div class="mb-4">
                <label for="nik" class="block">Nik</label>
                <input type="text" name="nik" id="nik" class="form-input">
            </div>
            <div class="mb-4">
                <label for="nama" class="block">Nama</label>
                <input type="text" name="nama" id="nama" class="form-input">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
        </form>
    </div>
</body>
</html>
