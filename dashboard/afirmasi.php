<?php
session_start();
if (!isset($_SESSION['nik'])) {
  header('Location: ../form-login.php');
  exit;
}
$nama = $_SESSION['nama'] ?? 'Pengguna';
$nik  = $_SESSION['nik'] ?? '';

include 'koneksi.php';

$query = "SELECT * FROM pendaftar WHERE nik = '$nik'";
$result = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result);

$query_dokumen = "SELECT * FROM dokumen WHERE nik = '{$user_data['nik']}'";
$result_dokumen = mysqli_query($koneksi, $query_dokumen);

$foto_profil_path = (!empty($user_data['foto_profil']) && $user_data['foto_profil'] != 'default-profile.jpg') 
                   ? "uploads/" . $user_data['foto_profil'] 
                   : "../assets/img/default-profile.jpg";
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afirmasi Pendaftaran Murid Website SMK - PSB</title>

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="../output.css" rel="stylesheet" />

    <!-- Website Pendaftaran Siswa icon -->
    <link rel="shortcut icon" href="../../assets/img/all-logo/logo-brand-light.svg" type="image/x-icon" />

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
                <!-- <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                    alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    Neil Sims
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    neil.sims@flowbite.com
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Settings</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Earnings</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
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
                    <a href="index.php"
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/10 group transition duration-200">
                        <svg class="w-6 h-6 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-lg ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="pendaftaran.php"
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/10 group transition duration-200">
                        <svg class="w-6 h-6 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-lg ms-3">Pendaftaran</span>
                    </a>
                </li>
            </ul>
            <ul class="space-y-3 font-medium mt-8">
                <h1 class="text-lg md:text-xl font-bold text-[var(--txt-primary2)]">Jalur Pendaftaran</h1>
                <li>
                    <button type="button"
                        class="flex items-center w-full py-2 px-4 text-base text-[var(--txt-primary)] transition duration-200 rounded-lg group hover:bg-[var(--bg-primary2)]/10 cursor-pointer"
                        aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <svg class="w-5 h-5 text-[var(--txt-primary)]/70 transition duration-75 group-hover:text-[var(--txt-primary)]"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 18">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pilih Jalur</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-example" class="py-2 space-y-2">
                        <li>
                            <a href="reguler.php"
                                class="flex items-center w-full py-2 px-4 text-base text-[var(--color-txt-primary2)] transition pl-6 duration-75 rounded-lg group hover:cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10">
                                <img src="../assets/img/all-card-jalur/logo-reguler.svg" class="h-6 me-3"
                                    alt="Logo Jalur Pendaftaran">
                                REGULER</a>
                        </li>
                        <li>
                            <a href="prestasi.php"
                                class="flex items-center w-full py-2 px-4 text-base text-[var(--color-txt-primary2)] transition pl-6 duration-75 rounded-lg group hover:cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10">
                                <img src="../assets/img/all-card-jalur/logo-prestasi.svg" class="h-6 me-3"
                                    alt="Logo Jalur Pendaftaran">
                                PRESTASI</a>
                        </li>
                        <li>
                            <a href="afirmasi.php"
                                class="flex items-center w-full py-2 px-4 text-base text-[var(--color-txt-primary2)] transition pl-6 duration-75 rounded-lg group hover:cursor-pointer bg-[var(--bg-primary2)]/30 hover:bg-[var(--bg-primary2)]/20">
                                <img src="../assets/img/all-card-jalur/logo-afirmasi.svg" class="h-4 me-3"
                                    alt="Logo Jalur Pendaftaran">
                                AFIRMASI</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div
                class="absolute bottom-2 left-0 w-full border-t border-[var(--bg-primary)]/20 bg-transparent px-4 py-4">
                <hr class="h-px my-4 bg-[var(--txt-primary)]/20 border-0">
                <a href="edit-profile.php"
                    class="cursor-pointer flex items-center w-full text-sm rounded-xl hover:shadow-md group hover:bg-[var(--bg-primary2)]/10 px-4 py-3 transition duration-400"
                    data-dropdown-toggle="dropdown-user-sidebar">
                    <img class="w-8 h-8 rounded-full me-3 shadow-md" src="<?php echo htmlspecialchars($foto_profil_path); ?>"
                        alt="user photo">
                    <div class="flex flex-col">
                        <span class="text-[var(--txt-primary)] font-bold"><?php echo htmlspecialchars($user_data['nama_lengkap_ortu']); ?></span>
                        <span class="text-[var(--txt-primary)] font-normal text-start"><?php echo htmlspecialchars($nik); ?></span>
                    </div>
                    <!-- <svg class="w-4 h-4 ms-auto text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.585l3.71-4.356a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg> -->
                </a>
                <!-- <div class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                    id="dropdown-user-sidebar">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownUserButton">
                        <li><a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li><a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li><a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign
                                out</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
    </aside>

    <!-- Tutup Sidebar -->

    <!-- Marquee -->

    <div
        class="fixed top-16 sm:top-14 w-full overflow-hidden whitespace-nowrap bg-[var(--bg-primary2)] text-[var(--txt-primary)]">
        <div class="animate-marquee px-6 py-2 text-md sm:text-base text-[var(--txt-secondary)]">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum reiciendis est corporis perspiciatis
            maxime unde atque temporibus inventore quibusdam architecto.
        </div>
    </div>

    <!-- Tutup Marquee -->

    <!-- Main Content -->

    <section class="p-4 lg:p-8 sm:ml-64">
        <div class="mt-26 lg:mt-24">
            <div class="grid grid-cols-1 xl:grid-cols-[3fr_1fr] gap-4 lg:gap-8 mb-8">
                <div
                    class="flex flex-col justify-center items-start p-6 lg:p-12 rounded-xl bg-[var(--bg-primary3)] border border-[var(--bg-primary2)]/30 shadow-md">
                    <h1 class="text-xl lg:text-4xl font-bold text-[var(--txt-primary)]">
                        Selamat Datang, <?php echo htmlspecialchars($user_data['nama_lengkap_ortu']); ?>!
                    </h1>
                    <p class="text-lg lg:text-2xl text-[var(--txt-primary)] mt-0 lg:mt-2">
                        Pantau Proses Pendaftaranmu di sini!
                    </p>
                </div>
                <img src="../assets/img/img-greet-ds.png"
                    class="w-full border border-[var(--bg-primary2)]/30 mx-auto lg:mx-0 flex items-center justify-center rounded-xl shadow-md"
                    alt="Image Greet Dashboard">
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-[1fr_2fr] gap-8 mb-8">
                <div
                    class="flex flex-col justify-center items-start p-4 lg:p-10 rounded-xl bg-[var(--bg-secondary2)] border border-[var(--bg-primary2)]/30 shadow-md">
                    <div class="flex items-center">
                        <img src="../assets/img/logo-afirmasi-daftar-ds.png" class="h-15 2xl:h-auto"
                            alt="Image Daftar Reguler Dashboard">
                        <h1
                            class="text-xl lg:text-2xl xl:text-4xl font-semibold text-[var(--txt-primary2)] ms-3 lg:ms-8">
                            Daftar Melalui Jalur Afirmasi!
                        </h1>
                    </div>
                    <a href="form-pendaftaran/afirmasi.php"
                        class="text-center w-full text-[var(--txt-secondary)] bg-[var(--bg-primary2)] hover:bg-[var(--bg-secondary)] transition duration-300 focus:ring-3 focus:ring-[var(--bg-secondary)] font-bold rounded-lg text-lg lg:text-xl px-5 py-2.5 mt-6 focus:outline-none cursor-pointer">Daftar</a>
                </div>
                <div
                    class="relative flex flex-col justify-center items-center p-6 lg:p-12 rounded-xl bg-[var(--bg-primary3)] border border-[var(--bg-primary2)]/30 shadow-md">
                    <div
                        class="absolute top-0 left-0 bg-[var(--bg-primary2)] px-6 py-2 text-md md:text-lg text-semibold rounded-tl-lg rounded-br-xl shadow-lg text-[var(--txt-secondary)]">
                        Info Pendaftaran</div>
                        <div
                    class="overflow-x-auto sm:rounded-lg border border-[var(--txt-primary)]/30 bg-[var(--bg-primary3)] shadow-md mt-2">
                    <table class="w-full text-md text-left rtl:text-right text-[var(--txt-primary)] ">
                        <thead class="text-md text-[var(--txt-primary)] uppercase bg-[var(--bg-primary2)]/10">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NIS
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ID Jalur
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jenis Dokumen
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Verifikasi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Upload
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Catatan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result_dokumen) > 0) {
                            while ($row = mysqli_fetch_assoc($result_dokumen)) {
                                    $jalur_mapping = [1 => 'Reguler', 2 => 'Afirmasi', 3 => 'Prestasi'];

                                echo '<tr class="border-t border-[var(--txt-primary)]/10">
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['nis']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($jalur_mapping[$row['id_jalur']]) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['jenis_dokumen']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['status_verifikasi']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['tanggal_upload']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['catatan_admin']) . '
                                </td>
                            </tr>';
                            }
                        } else {
                            echo '<tr class="border-t border-[var(--txt-primary)]/10">
                            <td colspan="7" class="px-6 py-4 text-center text-[var(--txt-primary)]">Tidak ada data</td>
                            </tr>';
                        }
                            ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </section>

    <!-- Tutup Main Content -->

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <script>
        function previewFileName(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (input.files.length > 0) {
                preview.textContent = `File dipilih: ${input.files[0].name}`;
            } else {
                preview.textContent = '';
            }
        }
    </script>

</body>

</html>