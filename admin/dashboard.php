<?php
session_start();
if(!isset($_SESSION['username'])) {
    header('location: index.php');
    exit;
}
include '../koneksi.php';

$username = $_SESSION['username'];

$query = "SELECT * FROM admin WHERE username_admin='$username'";
$result = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result);

?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Website SMK - PSB</title>

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="../output.css" rel="stylesheet" />

    <!-- Website Pendaftaran Siswa icon -->
    <link rel="shortcut icon" href="../assets/img/all-logo/logo-brand-light.svg" type="image/x-icon" />

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="font-[inter] bg-[var(--bg-primary)]">

    <!-- Navbar -->

    <nav class="fixed top-0 z-50 w-full bg-[var(--bg-primary3)] border-b border-[var(--bg-primary2)]/20">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-[var(--txt-primary)]/50 rounded-lg sm:hidden hover:bg-[var(--txt-primary)]/10 focus:outline-none focus:ring-2 focus:ring-[var(--txt-primary)]/30">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="" class="flex ms-4 md:me-24">
                        <img src="../assets/img/all-logo/logo-brand-teks-light.svg" class="h-8 me-3"
                            alt="PSB Kelompok 1 Logo" />
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Tutup Navbar -->

    <!-- Sidebar -->

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-22 transition-transform-translate-x-full bg-[var(--bg-primary3)] border-r border-[var(--bg-primary2)]/20 sm:translate-x-0 shadow-xl"
        aria-label="Sidebar">
        <div class="h-full px-5 pb-4 overflow-y-auto bg-[var(--bg-primary3)]">
            <ul class="space-y-3 font-medium">
                <h1 class="text-lg md:text-xl font-bold text-[var(--txt-primary2)]">Menu Utama</h1>
                <li>
                    <a href="dashboard.php"
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg bg-[var(--bg-primary2)]/30 hover:bg-[var(--bg-primary2)]/20 group transition duration-200">
                        <svg class="w-6 h-6 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-md ms-3">Dashboard Admin</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-akun.php"
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/10 group transition duration-200">
                        <svg class="w-6 h-6 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-md ms-3">Daftar Akun</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-siswa.php"
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/10 group transition duration-200">
                        <svg class="w-6 h-6 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.4472 2.10557c-.2815-.14076-.6129-.14076-.8944 0L5.90482 4.92956l.37762.11119c.01131.00333.02257.00687.03376.0106L12 6.94594l5.6808-1.89361.3927-.13363-5.6263-2.81313ZM5 10V6.74803l.70053.20628L7 7.38747V10c0 .5523-.44772 1-1 1s-1-.4477-1-1Zm3-1c0-.42413.06601-.83285.18832-1.21643l3.49538 1.16514c.2053.06842.4272.06842.6325 0l3.4955-1.16514C15.934 8.16715 16 8.57587 16 9c0 2.2091-1.7909 4-4 4-2.20914 0-4-1.7909-4-4Z" />
                            <path
                                d="M14.2996 13.2767c.2332-.2289.5636-.3294.8847-.2692C17.379 13.4191 19 15.4884 19 17.6488v2.1525c0 1.2289-1.0315 2.1428-2.2 2.1428H7.2c-1.16849 0-2.2-.9139-2.2-2.1428v-2.1525c0-2.1409 1.59079-4.1893 3.75163-4.6288.32214-.0655.65589.0315.89274.2595l2.34883 2.2606 2.3064-2.2634Z" />
                        </svg>
                        <span class="text-md ms-3">Daftar Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-kuota.php"
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/10 group transition duration-200">
                        <svg class="w-6 h-6 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.484 9.166 15 7h5m0 0-3-3m3 3-3 3M4 17h4l1.577-2.253M4 7h4l7 10h5m0 0-3 3m3-3-3-3" />
                        </svg>
                        <span class="text-md ms-3">Daftar Kuota Jalur</span>
                    </a>
                </li>
                <li>
                    <a href="daftar-dokumen.php"
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/10 group transition duration-200">
                        <svg class="w-6 h-6 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-md ms-3">Daftar Dokumen</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Tutup Sidebar -->

    <!-- Main Content -->

    <section class="p-4 lg:p-8 sm:ml-64">
        <div class="mt-18 md:mt-14">
            <div class="grid grid-cols-1 xl:grid-cols-[3fr_1fr] gap-4 lg:gap-8 mb-8">
                <div
                    class="flex flex-col justify-center items-start p-6 lg:p-12 rounded-xl bg-[var(--bg-primary3)] border border-[var(--bg-primary2)]/30 shadow-md">
                    <h1 class="text-xl lg:text-4xl font-bold text-[var(--txt-primary)]">
                        Selamat Datang, <?php echo htmlspecialchars($username) ?>!
                    </h1>
                    <p class="text-lg lg:text-2xl text-[var(--txt-primary)] mt-0 lg:mt-2">
                        Pantau Data pendaftaran di sini!
                    </p>
                </div>
                <img src="../assets/img/img-greet-ds.png"
                    class="w-full border border-[var(--bg-primary2)]/30 mx-auto lg:mx-0 flex items-center justify-center rounded-xl shadow-md"
                    alt="Image Greet Dashboard">
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-end">
                    <div
                        class="flex flex-col bg-[var(--bg-primary3)] p-6 border lg:border-r-0 lg:border-t lg:border-l lg:border-b border-[var(--txt-primary)]/30 rounded-xl shadow-md mb-4 lg:mb-0">
                        <h1 class="txt-[var(--txt-primary2)] text-2xl font-bold">Lorem Ipsum</h1>
                        <h1 class="txt-[var(--txt-primary2)] text-xl font-semibold">Lorem Ipsum dolor sit amet</h1>

                        <!-- Line Chart -->
                        <div class="py-6" id="pie-chart"></div>
                    </div>
                    <div
                        class="ps-0 xl:ps-4 2xl:px-10 xl:p-0 flex flex-col items-center xl:items-start justify-center gap-10 bg-[var(--bg-primary3)] h-full lg:h-[90%] p-4 border lg:border-l-0 lg:border-t lg:border-r lg:border-b border-[var(--txt-primary)]/30 rounded-xl">
                        <div class="flex items-center justify-center gap-2 2xl:gap-6">
                            <div
                                class="bg-[var(--bg-primary2)] text-2xl 2xl:text-5xl font-bold text-[var(--txt-secondary)] px-8 py-3 rounded-xl">
                                57%
                            </div>
                            <p class="text-xl 2xl:text-3xl font-normal">Reguler</p>
                        </div>
                        <div class="flex items-center justify-center gap-2 2xl:gap-6">
                            <div
                                class="bg-[var(--bg-secondary)] text-2xl 2xl:text-5xl font-bold text-[var(--txt-secondary)] px-8 py-3 rounded-xl">
                                28%
                            </div>
                            <p class="text-xl 2xl:text-3xl font-normal">Prestasi</p>
                        </div>
                        <div class="flex items-center justify-center gap-2 2xl:gap-6">
                            <div
                                class="bg-[var(--bg-secondary2)] text-2xl 2xl:text-5xl font-bold text-[var(--txt-primary2)] px-8 py-3 rounded-xl">
                                15%
                            </div>
                            <p class="text-xl 2xl:text-3xl font-normal">Afirmasi</p>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col justify-center items-center rounded-xl bg-[var(--bg-primary3)] border border-[var(--bg-primary2)]/30 shadow-md">
                    <img src="../assets/img/kalender.png" alt="Kalender">
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8">
                <div
                    class="flex bg-[var(--bg-primary2)] p-6 items-center justify-center gap-2 lg:gap-6 rounded-2xl shadow">
                    <h1 class="text-4xl lg:text-8xl text-[var(--txt-secondary)] font-bold">153</h1>
                    <p class="text-2xl lg:text-4xl text-[var(--txt-secondary)]">Pendaftar</p>
                </div>

                <div
                    class="flex bg-[var(--bg-primary3)] border border-[var(--txt-primary)]/30 p-6 items-center justify-center gap-2 lg:gap-6 rounded-2xl shadow">
                    <h1 class="text-4xl lg:text-8xl text-[var(--txt-primary)] font-bold">500</h1>
                    <p class="text-2xl lg:text-4xl text-[var(--txt-primary)]">Akun Terdaftar</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutup Main Content -->

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <!-- Flowbite Script Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>

    <!-- Script Eksternal -->
    <script src="js/dashboard.js"></script>

</body>

</html>