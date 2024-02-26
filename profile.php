<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';

// Tangani pengunggahan foto profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_profile'])) {
    $nik = $_SESSION['nik'];
    $foto_profil = $_FILES['foto_profile'];

    // Periksa apakah file yang diunggah adalah gambar
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($foto_profil['type'], $allowed_types)) {
        echo "Hanya file gambar JPEG, PNG, atau GIF yang diizinkan.";
        exit;
    }

    // Simpan file gambar di server
    $upload_dir = 'uploads/';
    $foto_profile_path = $upload_dir . basename($foto_profil['name']);
    move_uploaded_file($foto_profil['tmp_name'], $foto_profile_path);

    // Simpan path foto profil ke dalam basis data
    $sql = "UPDATE user SET foto_profile = ? WHERE nik = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $foto_profile_path, $nik);
    $stmt->execute();
    $stmt->close();

    // Redirect kembali ke halaman profile setelah berhasil mengunggah foto profil
    header('Location: profile.php');
    exit;
}

// Ambil data pengguna dari database
$nik = $_SESSION['nik'];
$sql = "SELECT * FROM user WHERE nik = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $nik);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();
?>

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
            margin-left: 170px;
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
            transition: left 0.6s ease;
            background-color: #4b5563;
            padding: 10px;
            border-radius: 30%;
        }

        /* Mengubah warna ikon hamburger menjadi sesuai dengan latar belakang */
        .hamburger-icon svg {
            fill: #fff;
        }
        
        /* Style untuk foto profil */
        .profile-picture {
            width: 150px;
            height: 150px;
            padding: 5px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
        }
        
        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .upload-btn {
            background-color: #4b5563;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }
        
        .upload-btn:hover {
            background-color: #4b5585;
        }
        
        .upload-btn .icon {
            margin-right: 5px;
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
        <!-- component -->
        <section class="pt-16 bg-blueGray-50">
            <div class="w-full lg:w-4/12 px-4 mx-auto">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg mt-16">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full px-4 flex justify-center">
                                <div class="relative profile-picture">
                                    <?php if (!empty($userData['foto_profile'])): ?>
                                        <img alt="Foto Profil" src="<?php echo $userData['foto_profile']; ?>" class="shadow-xl rounded-full h-auto align-middle border-none">
                                    <?php else: ?>
                                        <center><p>Foto Profil<br> Tidak Tersedia</p></center>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <h3 class="text-xl font-semibold leading-normal mb-1 text-blueGray-700 mb-2">
                                <?php echo $userData['nik']; ?>
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
                                <?php echo $userData['nama']; ?>
                            </div>
                            <div class="flex items-center justify-center mt-2">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="file" name="foto_profile" id="foto_profile" class="hidden">
                                    <label for="foto_profile" class="upload-btn cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </span>
                                        Pilih Foto
                                    </label>
                                    <button type="submit" class="upload-btn ml-2 cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                        Edit Foto
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <p class="text-sm text-gray-500"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="relative pt-8 pb-6 mt-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-center md:justify-between justify-center">
                    <div class="w-full md:w-6/12 px-4 mx-auto text-center">
                        <div class="text-sm text-blueGray-500 font-semibold py-1">
                            Made with <a href="https://www.creative-tim.com/product/notus-js" class="text-blueGray-500 hover:text-gray-800" target="_blank">Gozi Logic</a> by <a href="https://www.creative-tim.com" class="text-blueGray-500 hover:text-blueGray-800" target="_blank"> Yeoji</a>.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script>
            const hamburgerIcon = document.getElementById('hamburgerIcon');
            const sidebar = document.querySelector('.sidenav');
            const content = document.getElementById('content');

            hamburgerIcon.addEventListener('click', function() {
                const sidebarWidth = sidebar.offsetWidth;

                sidebar.classList.toggle('sidenav-closed');

                if (sidebar.classList.contains('sidenav-closed')) {
                    content.style.marginLeft = '0px';
                    hamburgerIcon.style.left = '20px';
                } else {
                    content.style.marginLeft = sidebarWidth + '170px';
                    hamburgerIcon.style.left = sidebarWidth  + '190px';
                }
            });
        </script>
    </body>
</html>
