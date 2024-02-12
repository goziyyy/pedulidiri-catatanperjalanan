<?php
session_start();

if (!isset($_SESSION['nik'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';

$nik = $_SESSION['nik'];

// Query database untuk mendapatkan nama berdasarkan nik
$sql = "SELECT nama FROM user WHERE nik='$nik'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
} else {
    $nama = "Pengguna";
}

// Query database untuk mendapatkan jumlah catatan yang telah dibuat oleh pengguna
$sql_count_notes = "SELECT COUNT(*) AS total FROM catatan WHERE nik='$nik'";
$result_count_notes = $conn->query($sql_count_notes);
$total_notes = $result_count_notes->fetch_assoc()['total'];
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

        [x-cloak] {
        display: none;
    }
    .line {
        background: repeating-linear-gradient(
            to bottom,
            #eee,
            #eee 1px,
            #fff 1px,
            #fff 8%
        );
    }
	.tick {
        background: repeating-linear-gradient(
            to right,
            #eee,
            #eee 1px,
            #fff 1px,
            #fff 5%
        );
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
                <li><a href="#" class="block py-2 menu-text">Home</a></li>
                <li><a href="#" class="block py-2 menu-text">Tambah Catatan</a></li>
                <li><a href="#" class="block py-2 menu-text">View Catatan</a></li>
                <li><a href="#" class="block py-2 menu-text">Profile</a></li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div id="content" class="content p-8">
        <br><br>
        <h2 class="text-2xl mb-4">Home</h2>
        <div class="max-w-lg">
        <div class="bg-gray-800 p-5 rounded-lg shadow mb-4">
            <h3 class="text-white dark:text-white text-lg font-semibold">Welcome, <?php echo $nama; ?>!</h3>
            <p class="text-white dark:text-white mt-2">Anda telah membuat <?php echo $total_notes; ?> catatan.</p>
        </div>
</div>
        <div class="flex flex-wrap justify-start mt-10">

    <!-- card 1 -->
    <div class="p-4 max-w-sm">
        <div class="flex rounded-lg h-full dark:bg-gray-800 bg-gray-800 p-8 flex-col">
            <div class="flex items-center mb-3">
                <div
                    class="w-8 h-8 mr-3 inline-flex items-center justify-center rounded-full dark:bg-indigo-500 bg-indigo-500 text-white flex-shrink-0">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                    </svg>
                </div>
                <h2 class="text-white dark:text-white text-lg font-medium">Feature 1</h2>
            </div>
            <div class="flex flex-col justify-between flex-grow">
                <p class="leading-relaxed text-base text-white dark:text-gray-300">
                    Blue bottle crucifix vinyl post-ironic four dollar toast vegan taxidermy. Gastropub indxgo juice poutine.
                </p>
                <a href="#" class="mt-3 text-white dark:text-white hover:text-blue-600 inline-flex items-center">Learn More
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>

<body class="antialiased sans-serif bg-gray-200">
  <div x-data="app()" x-cloak class="px-4">
    <div class="p-4 max-w-xl"> <!-- Mengubah max-w-lg menjadi max-w-xl -->
      <div class="shadow p-6 rounded-lg bg-white">
        <div class="md:flex md:justify-between md:items-center">
          <div>
            <h2 class="text-xl text-gray-800 font-bold leading-tight">Product Sales</h2>
            <p class="mb-2 text-gray-600 text-sm">Monthly Average</p>
          </div>

          <!-- Legends -->
          <div class="mb-4">
            <div class="flex items-center">
              <div class="w-2 h-2 bg-blue-600 mr-2 rounded-full"></div>
              <div class="text-sm text-gray-700">Sales</div>
            </div>
          </div>
        </div>

        <div class="line my-8 relative">
          <!-- Tooltip -->
          <template x-if="tooltipOpen == true">
            <div x-ref="tooltipContainer" class="p-0 m-0 z-10 shadow-lg rounded-lg absolute h-auto block" :style="`bottom: ${tooltipY}px; left: ${tooltipX}px`">
              <div class="shadow-xs rounded-lg bg-white p-2">
                <div class="flex items-center justify-between text-sm">
                  <div>Sales:</div>
                  <div class="font-bold ml-2">
                    <span x-html="tooltipContent"></span>
                  </div>
                </div>
              </div>
            </div>
          </template>


          <!-- Bar Chart -->
          <div class="flex -mx-2 items-end mb-2">
            <template x-for="data in chartData">

              <div class="px-2 w-1/6">
                <div :style="`height: ${data}px`" class="transition ease-in duration-200 bg-blue-600 hover:bg-blue-400 relative" @mouseenter="showTooltip($event); tooltipOpen = true" @mouseleave="hideTooltip($event)">
                  <div x-text="data" class="text-center absolute top-0 left-0 right-0 -mt-6 text-gray-800 text-sm"></div>
                </div>
              </div>

            </template>
          </div>

          <!-- Labels -->
          <div class="border-t border-gray-400 mx-auto" :style="`height: 1px; width: ${ 100 - 1/chartData.length*100 + 3}%`"></div>
          <div class="flex -mx-2 items-end">
            <template x-for="data in labels">
              <div class="px-2 w-1/6">
                <div class="bg-red-600 relative">
                  <div class="text-center absolute top-0 left-0 right-0 h-2 -mt-px bg-gray-400 mx-auto" style="width: 1px"></div>
                  <div x-text="data" class="text-center absolute top-0 left-0 right-0 mt-3 text-gray-700 text-sm"></div>
                </div>
              </div>
            </template>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    function app() {
      return {
        chartData: [112, 10, 225, 134, 101, 80, 50, 100, 200],
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        tooltipContent: '',
        tooltipOpen: false,
        tooltipX: 0,
        tooltipY: 0,
        showTooltip(e) {
          console.log(e);
          this.tooltipContent = e.target.textContent
          this.tooltipX = e.target.offsetLeft - e.target.clientWidth;
          this.tooltipY = e.target.clientHeight + e.target.clientWidth;
        },
        hideTooltip(e) {
          this.tooltipContent = '';
          this.tooltipOpen = false;
          this.tooltipX = 0;
          this.tooltipY = 0;
        }
      }
    }
  </script>
</body>



<!-- card 2 -->
<div class="p-4 max-w-sm">
        <div class="flex rounded-lg h-full dark:bg-gray-800 bg-gray-800 p-8 flex-col">
            <div class="flex items-center mb-3">
                <div
                    class="w-8 h-8 mr-3 inline-flex items-center justify-center rounded-full dark:bg-indigo-500 bg-indigo-500 text-white flex-shrink-0">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                    </svg>
                </div>
                <h2 class="text-white dark:text-white text-lg font-medium">Feature 1</h2>
            </div>
            <div class="flex flex-col justify-between flex-grow">
                <p class="leading-relaxed text-base text-white dark:text-gray-300">
                    Blue bottle crucifix vinyl post-ironic four dollar toast vegan taxidermy. Gastropub indxgo juice poutine.
                </p>
                <a href="#" class="mt-3 text-white dark:text-white hover:text-blue-600 inline-flex items-center">Learn More
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>


</body>
    
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
