<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];

    $sql = "INSERT INTO user (nik, nama) VALUES ('$nik', '$nama')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Registration successful!";
        header('Location: login.php');
    } else {
        $_SESSION['message'] = "Registration failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl mb-4">Register</h2>
        <form action="" method="post">
            <div class="mb-4">
                <label for="nik" class="block">Nik</label>
                <input type="text" name="nik" id="nik" class="form-input">
            </div>
            <div class="mb-4">
                <label for="nama" class="block">Nama</label>
                <input type="text" name="nama" id="nama" class="form-input">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Register</button>
        </form>
    </div>
</body>
</html>
