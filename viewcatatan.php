<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peduli Diri</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom CSS styles */
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .sidenav {
            width: 170px;
            transition: all 0.6s ease;
        }

        .content {
            transition: margin-left 0.6s ease;
            margin-left: 170px; /* Menggeser konten ke kanan sejauh lebar sidenavbar */
        }

        .sidenav-closed {
            width: 0px;
        }

        .sidenav-closed .menu-text {
            display: none;
        }

        .hamburger-icon {
            position: absolute;
            top: 20px;
            left: 190px;
            cursor: pointer;
            transition: left 0.6s ease; /* Transisi untuk menggerakkan ikon hamburger */
            background-color: #4b5563; /* Warna biru dongker */
            padding: 10px;
            border-radius: 30%; /* Memberikan sudut bulat */
        }

        /* Mengubah warna ikon hamburger menjadi sesuai dengan latar belakang */
        .hamburger-icon svg {
            fill: #fff; /* Warna biru dongker */
        }
        .sehat {
            color: green;
        }

        .periksa {
            color: red;
        }

        /* Styling untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Hamburger Icon -->
    <div id="hamburgerIcon" class="hamburger-icon">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </div>

    <!-- Sidebar -->
    <div class="bg-gray-800 text-white h-screen fixed top-0 left-0 overflow-y-auto sidenav">
        <div class="p-4">
            <h1 class="text-2xl font-semibold menu-text">Peduli Diri</h1>
            <ul class="mt-4">
                <li><a href="dashboard.php" class="block py-2 menu-text">Home</a></li>
                <li><a href="tambah_catatan.html" class="block py-2 menu-text">Tambah Catatan</a></li>
                <li><a href="viewcatatan.php" class="block py-2 menu-text">View Catatan</a></li>
                <li><a href="profile.php" class="block py-2 menu-text">Profile</a></li>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <li><a href="logout.php" class="block py-2 menu-text">Logout</a></li>
            </ul>
        </div>
    </div>
    

    <!-- Content -->
    <div id="content" class="content p-8">
        <?php
        session_start(); // Mulai sesi

        // Periksa apakah pengguna sudah login
        if (!isset($_SESSION['nik'])) {
            header('Location: login.php');
            exit; // Hentikan skrip karena pengguna belum login
        }

        require_once 'config.php'; // Sertakan file konfigurasi database

        // Query untuk mengambil catatan dari database
        $sql = "SELECT * FROM catatan WHERE nik = '{$_SESSION['nik']}'"; // Ganti sesuai dengan nama kolom pada tabel catatan

        $result = $conn->query($sql);

        // Inisialisasi variabel untuk menyimpan catatan
        $catatan = [];

        if ($result->num_rows > 0) {
            // Loop melalui hasil query dan simpan catatan ke dalam array
            while ($row = $result->fetch_assoc()) {
                $catatan[] = $row;
            }
        }
        ?>

<br>
        <div class="container mx-auto mt-8">
            <h2 class="text-xl font-semibold mb-4">View Catatan</h2>
            <?php if (!empty($catatan)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Catatan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Keterangan Suhu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($catatan as $data): ?>
                    <tr>
                        <td><?php echo $data['id_catatan']; ?></td>
                        <td><?php echo $data['tanggal']; ?></td>
                        <td><?php echo $data['waktu']; ?></td>
                        <td><?php echo $data['lokasi']; ?></td>
                        <td class="<?php echo ($data['suhu'] >= 36.5 && $data['suhu'] <= 37.6) ? 'sehat' : 'periksa'; ?>">
                            <?php
                                if ($data['suhu'] >= 36.5 && $data['suhu'] <= 37.6) {
                                    echo $data['suhu'] . ' &deg;C - Sehat';
                                } else {
                                    echo $data['suhu'] . ' &deg;C - Segera periksa ke dokter';
                                }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Tidak ada catatan yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const hamburgerIcon = document.getElementById('hamburgerIcon');
        const sidebar = document.querySelector('.sidenav');
        const content = document.getElementById('content');

        hamburgerIcon.addEventListener('click', function() {
            const sidebarWidth = sidebar.offsetWidth;

            sidebar.classList.toggle('sidenav-closed');

            if (sidebar.classList.contains('sidenav-closed')) {
                content.style.marginLeft = '0px'; // Ketika sidenavbar ditutup, kembalikan margin kiri ke 0
                hamburgerIcon.style.left = '20px'; // Geser ikon hamburger ke posisi awal
            } else {
                content.style.marginLeft = sidebarWidth + '170px'; // Ketika sidenavbar dibuka, geser konten sejauh lebar sidenavbar
                hamburgerIcon.style.left = sidebarWidth  + '190px'; // Geser ikon hamburger sesuai dengan lebar sidenavbar
            }
        });
    </script>
</body>
</html>
