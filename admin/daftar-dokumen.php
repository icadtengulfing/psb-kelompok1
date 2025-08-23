<?php
session_start();
include '../koneksi.php';
if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit;
}

//verifikasi
if (isset($_POST['verifikasi'])) {
    $id_dokumen = mysqli_real_escape_string($koneksi, $_POST['id_dokumen']);
    $status = mysqli_real_escape_string($koneksi, $_POST['verifikasi']);

    $query_status = "UPDATE dokumen SET status_verifikasi = '$status' WHERE id_dokumen = '$id_dokumen'";
    $result = mysqli_query($koneksi, $query_status);
}
$order_by = "";
$search_query = "";
if (isset($_GET['cari']) && !empty($_GET['cari'])) {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $search_query =  " WHERE id_dokumen LIKE '%" . $cari . "%' OR jenis_dokumen LIKE '%" . $cari . "%' OR tanggal_upload LIKE '%" . $cari . "%'";
}

if (isset($_GET['sort']) && !empty($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'id_dok_asc':
            $order_by = "ORDER BY id_dokumen ASC";
            break;
        case 'id_dok_desc':
            $order_by = " ORDER BY id_dokumen DESC";
            break;
        case 'nis_asc':
            $order_by = " ORDER BY nis ASC";
            break;
        case 'nis_desc':
            $order_by = " ORDER BY nis DESC";
            break;
        case 'tanggal_asc':
            $order_by = " ORDER BY tanggal_upload ASC";
            break;
        case 'tanggal_desc':
            $order_by = " ORDER BY tanggal_upload DESC";
            break;
        default:
            // Tidak ada pengurutan atau nilai tidak valid
            $order_by = "";
            break;
    }
}
$query = "SELECT * FROM dokumen";
if (!empty($search_query)) {
    $query .= " " . $search_query;
}
if (!empty($order_by)) {
    $query .= " " . $order_by;
}
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die('SQL Error: ' . mysqli_error($koneksi));
}

if (isset($_POST['submit_tambah'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);

    // cek dulu di tabel
    $cek = mysqli_query($koneksi, "SELECT nis FROM siswa WHERE nis='$nis' LIMIT 1");

    if (mysqli_num_rows($cek) == 0) {
        // baru insert kalau belum ada
        $query_pendaftar = "INSERT INTO siswa (nis) VALUES ('$nis')";
        mysqli_query($koneksi, $query_pendaftar);
    }
    $input_files = [
        'kartuKeluarga' => 'Kartu Keluarga',
        'ijazahSmp' => 'Ijazah SMP',
        'SKL' => 'Surat Keterangan Lulus',
        'akteLahir' => 'Akte Lahir',
        'pasFoto' => 'Pas Foto 3x4',
        'SKCK' => 'SKCK',
        'KPIP' => 'KPIP',
        'SKTM' => 'SKTM',
        'disablitias' => 'Disabilitas'
    ];

    $upload_errors = [];
    $upload_success = [];

    foreach ($input_files as $input_name => $jenis_dokumen) {
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] === 0) {

            $base_dir = "../dashboard/form-pendaftaran/uploads/dokumen/";
            $jenis_folder = strtolower(str_replace(' ', '_', $jenis_dokumen));
            $target_dir = $base_dir . $jenis_folder . "/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            // DIPERBAIKI: Gunakan $input_name, bukan 'dokumen'
            $file_ext = strtolower(pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION));

            // Validasi ekstensi file
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
            if (!in_array($file_ext, $allowed_extensions)) {
                $upload_errors[] = "Format file $jenis_dokumen tidak valid.";
                continue;
            }

            // Validasi ukuran file (max 2MB)
            if ($_FILES[$input_name]['size'] > 2 * 1024 * 1024) {
                $upload_errors[] = "Ukuran file $jenis_dokumen terlalu besar.";
                continue;
            }

            $new_filename = $nis . '_' . $input_name . '_' . time() . '.' . $file_ext;
            $file_path = $target_dir . $new_filename;

            // uopload file
            if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $file_path)) {
                // Insert ke database
                $query_dokumen = "INSERT INTO dokumen (nis, jenis_dokumen, file_path, tanggal_upload, status_verifikasi, catatan_admin) 
                VALUES ('$nis', '$jenis_dokumen', '$file_path', NOW(), 'Menunggu', '$catatan_admin')";
                $result_dokumen = mysqli_query($koneksi, $query_dokumen);

                if ($result_dokumen) {
                    $upload_success[] = $jenis_dokumen;
                } else {
                    $upload_errors[] = "Gagal menyimpan data $jenis_dokumen: " . mysqli_error($koneksi);
                }
            } else {
                $upload_errors[] = "Gagal mengupload file $jenis_dokumen!";
            }
        }
    }
}
if ( isset($_GET['edit']) )
{
  mysqli_query( $koneksi, "DELETE FROM dokumen WHERE id_dokumen ='$_GET[edit]'" );

  echo "<script>
  alert('Data Berhasil di Hapus!');
  window.location.href = 'daftar-dokumen.php';
  </script>";
}
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dokumen Admin Website SMK - PSB</title>

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
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/10 group transition duration-200 ">
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
                        class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg bg-[var(--bg-primary2)]/30 hover:bg-[var(--bg-primary2)]/20 group transition duration-200">
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
                        Daftar Dokumen Pendaftaran
                    </h1>
                    <p class="text-lg lg:text-2xl text-[var(--txt-primary)] mt-0 lg:mt-2">
                        List Dokumen Pendaftaran yang Tersedia
                    </p>
                </div>
                <img src="../assets/img/img-greet-ds.png"
                    class="w-full border border-[var(--bg-primary2)]/30 mx-auto lg:mx-0 flex items-center justify-center rounded-xl shadow-md"
                    alt="Image Greet Dashboard">
            </div>
            <div class="grid grid-cols-1">

                <div class="flex items-center justify-center flex-column flex-col md:flex-row pb-4 gap-3 lg:gap-4">
                    <div>
                        <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                            class="inline-flex items-center text-[var(--txt-secondary)] bg-[var(--bg-primary2)] border border-[var(--txt-primary)]/30 focus:outline-none hover:bg-[var(--bg-primary2)]/90 hover:cursor-pointer font-normal rounded-lg shadow-md text-lg px-3 py-1.5"
                            type="button">
                            <span class="sr-only">Action button</span>
                            Action
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownAction" class="z-10 hidden bg-[var(--bg-primary2)] rounded-lg shadow-sm w-42">
                            <ul class="py-1 text-sm text-[var(--txt-secondary)]" aria-labelledby="dropdownActionButton">
                                <li>
                                    <a href="?sort=id_dok_asc" class="block px-4 py-2 hover:bg-[var(--bg-primary3)]/10">
                                        Awal ke akhir (ID)
                                    </a>
                                </li>
                                <li>
                                    <a href="?sort=id_dok_desc" class="block px-4 py-2 hover:bg-[var(--bg-primary3)]/10">
                                        Akhir ke awal (ID)
                                    </a>
                                </li>
                                <li>
                                    <a href="?sort=nis_asc" class="block px-4 py-2 hover:bg-[var(--bg-primary3)]/10">
                                        Awal ke akhir (NIS)
                                    </a>
                                </li>
                                <li>
                                    <a href="?sort=nis_desc" class="block px-4 py-2 hover:bg-[var(--bg-primary3)]/10">
                                        Akhir ke awal (NIS)
                                    </a>
                                </li>
                                <li>
                                    <a href="?sort=tanggal_asc" class="block px-4 py-2 hover:bg-[var(--bg-primary3)]/10">
                                        Tanggal terlama
                                    </a>
                                </li>
                                <li>
                                    <a href="?sort=tanggal_desc" class="block px-4 py-2 hover:bg-[var(--bg-primary3)]/10">
                                        Tanggal terbaru
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <form action="" method="GET">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-[var(--txt-primary)]" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="table-search-users" name="cari"
                                class="block p-2 ps-10 text-md text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 bg-[var(--bg-primary3)] rounded-lg w-full lg:w-100 focus:ring-0"
                                placeholder="Cari Jenis Dokumen">
                        </div>
                    </form>
                    <button type="button" data-modal-target="modalTambah" data-modal-toggle="modalTambah"
                        class="w-full sm:w-auto focus:outline-none text-[var(--txt-secondary)] bg-[var(--bg-primary2)] hover:bg-[var(--bg-primary2)]/90 hover:cursor-pointer transition duration-500 shadow-md font-medium rounded-lg text-sm px-5 py-2.5">Tambah
                        +</button>
                </div>

                <div
                    class="overflow-x-auto sm:rounded-lg border border-[var(--txt-primary)]/30 bg-[var(--bg-primary3)] shadow-md mt-2">
                    <table class="w-full text-md text-left rtl:text-right text-[var(--txt-primary)] ">
                        <thead class="text-md text-[var(--txt-primary)] uppercase bg-[var(--bg-primary2)]/10">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    id_dokumen
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    id_admin
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    NIS
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jenis Dokumen
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    File Path
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Upload
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Catatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Verifikasi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr class="border-t border-[var(--txt-primary)]/10">
                                <td class="w-4 p-4" align="center">
                                    ' . htmlspecialchars($row['id_dokumen']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['id_admin']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['nis']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['jenis_dokumen']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['file_path']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['tanggal_upload']) . '
                                </td>
                                <td class="px-6 py-4">
                                    ' . htmlspecialchars($row['catatan_admin']) . '
                                </td>
                                <td class="px-6 py-4">
                                <form method="POST"> 
                                <input type="hidden" name="id_dokumen" value="'.htmlspecialchars($row['id_dokumen']).'">
                                    <button type="submit" name="verifikasi" value="Terverifikasi"
                                        class="hover:cursor-pointer font-medium text-green-600 dark:text-green-500 hover:underline">
                                        YA
                                    </button>
                                    <button type="submit" name="verifikasi" value="Ditolak"
                                        class="hover:cursor-pointer ms-2 font-medium text-red-600 dark:text-red-500 hover:underline">
                                        TIDAK
                                    </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <a type="button" href="edit_dokumen.php?edit='.htmlspecialchars($row['id_dokumen']).'"
                                        class="hover:cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        EDIT
                                    </a>
                                    <a type="button" href="?edit='.htmlspecialchars($row['id_dokumen']).'" onclick="return confirm("Yakin ingin menghapus data ini?");"
                                        class="hover:cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline">
                                        DELETE
                                    </a>
                                </td>
                            </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal - Tambah Data -->
        <div id="modalTambah" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-60 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-[var(--bg-primary)] rounded-lg shadow-sm">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[var(--txt-primary)]/50">
                        <h3 class="text-xl font-semibold text-[var(--txt-primary)]">
                            Tambah Data Dokumen
                        </h3>
                        <button type="button"
                            class="text-[var(--txt-primary)]/50 bg-transparent hover:bg-[var(--bg-primary2)]/20 hover:text-[var(--txt-primary)] rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:cursor-pointer"
                            data-modal-hide="modalTambah">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <form method="POST" enctype="multipart/form-data" class="w-full">
                            <!-- NIS Input -->
                            <div class="mb-4">
                                <label for="nis" class="block mb-2 text-lg font-medium text-[var(--txt-primary)]">
                                    NIS Siswa (isi)
                                </label>
                                <input type="text" id="nis" name="nis"
                                    class="bg-transparent border border-[var(--txt-primary)]/30 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)] block w-full p-2 ps-3"
                                    placeholder="Masukkan NIS Siswa" required />
                            </div>
                            <!-- Upload dokumen -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-[var(--txt-primary)] mb-4">Upload Dokumen</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Kartu Keluarga -->
                                    <div class="mb-4">
                                        <label for="kartuKeluarga" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            Kartu Keluarga
                                        </label>
                                        <input type="file" id="kartuKeluarga" name="kartuKeluarga" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>
                                    <!-- Ijazah SMP -->
                                    <div class="mb-4">
                                        <label for="ijazahSmp" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            Ijazah SMP
                                        </label>
                                        <input type="file" id="ijazahSmp" name="ijazahSmp" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>
                                    <!-- Surat Keterangan Lulus -->
                                    <div class="mb-4">
                                        <label for="SKL" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            Surat Keterangan Lulus
                                        </label>
                                        <input type="file" id="SKL" name="SKL" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>

                                    <!-- Akte Lahir -->
                                    <div class="mb-4">
                                        <label for="akteLahir" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            Akte Lahir
                                        </label>
                                        <input type="file" id="akteLahir" name="akteLahir" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>

                                    <!-- Pas Foto 3x4 -->
                                    <div class="mb-4">
                                        <label for="pasFoto" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            Pas Foto 3x4
                                        </label>
                                        <input type="file" id="pasFoto" name="pasFoto" accept=".jpg,.jpeg,.png"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG (Max. 2MB)</p>
                                    </div>

                                    <!-- SKCK -->
                                    <div class="mb-4">
                                        <label for="SKCK" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            SKCK
                                        </label>
                                        <input type="file" id="SKCK" name="SKCK" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>

                                    <!-- KPIP -->
                                    <div class="mb-4">
                                        <label for="KPIP" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            KPIP
                                        </label>
                                        <input type="file" id="KPIP" name="KPIP" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>

                                    <!-- SKTM -->
                                    <div class="mb-4">
                                        <label for="SKTM" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            SKTM
                                        </label>
                                        <input type="file" id="SKTM" name="SKTM" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>

                                    <!-- Surat Disabilitas -->
                                    <div class="mb-4">
                                        <label for="disablitias" class="block mb-2 text-md font-medium text-[var(--txt-primary)]">
                                            Surat Disabilitas
                                        </label>
                                        <input type="file" id="disablitias" name="disablitias" accept=".jpg,.jpeg,.png,.pdf"
                                            class="block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none">
                                        <p class="mt-1 text-sm text-[var(--txt-primary)]/60">JPG, PNG, PDF (Max. 2MB)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Admin -->
                            <div class="mb-4">
                                <label for="catatan" class="block mb-2 text-lg font-medium text-[var(--txt-primary)]">
                                    Catatan Admin
                                </label>
                                <textarea id="catatan" name="catatan_admin" rows="3"
                                    class="bg-transparent border border-[var(--txt-primary)]/30 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)] block w-full p-2 ps-3"
                                    placeholder="Masukkan catatan tambahan (opsional)"></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end mt-8">
                                <button data-modal-hide="modalTambah" type="button"
                                    class="py-2 px-5 text-md hover:cursor-pointer font-medium text-gray-900 focus:outline-none bg-transparent rounded-lg border border-[var(--txt-primary)]/50 hover:bg-[var(--bg-primary2)]/10 focus:z-10 focus:ring-3 focus:ring-[var(--txt-primary)]/20">
                                    Batal
                                </button>
                                <button type="submit" name="submit_tambah"
                                    class="text-[var(--txt-secondary)] ms-2 bg-[var(--bg-primary2)] hover:bg-[var(--bg-primary2)]/90 focus:ring-3 focus:outline-none focus:ring-[var(--bg-secondary)] font-bold rounded-lg text-md hover:cursor-pointer px-5 py-2 text-center">
                                    Tambah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal - Ubah Data -->
        <div id="modalUbah" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-60 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-[var(--bg-primary)] rounded-lg shadow-sm">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[var(--txt-primary)]/50">
                        <h3 class="text-xl font-semibold text-[var(--txt-primary)]">
                            Ubah Data Dokumen
                        </h3>
                        <button type="button"
                            class="text-[var(--txt-primary)]/50 bg-transparent hover:bg-[var(--bg-primary2)]/20 hover:text-[var(--txt-primary)] rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:cursor-pointer"
                            data-modal-hide="modalUbah">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-3">
                        <form class="w-full">
                            <div class="mb-4">
                                <label for="id_dokumen"
                                    class="block mb-2 text-lg font-medium text-[var(--txt-primary)]">
                                    id_dokumen:
                                </label>
                                <input type="number" id="id_dokumen"
                                    class="bg-[var(--bg-primary2)]/20 hover:bg-[var(--bg-primary2)]/30 border border-[var(--txt-primary)]/30 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)] block w-full p-2 ps-3 cursor-not-allowed"
                                    placeholder="id_dokumen" required value="1" disabled />
                            </div>
                            <div class="mb-4">
                                <label for="jenisDokumen"
                                    class="block mb-2 text-lg font-medium text-[var(--txt-primary)]">
                                    Jenis Dokumen:
                                </label>
                                <input type="number" id="jenisDokumen"
                                    class="bg-transparent border border-[var(--txt-primary)]/30 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)] block w-full p-2 ps-3"
                                    placeholder="Masukkan Jenis Dokumen" required value="Foto Pas 3x4" />
                            </div>
                            <div class="mb-4">
                                <label for="filePath" class="block mb-2 text-lg font-medium text-[var(--txt-primary)]">
                                    File Path:
                                </label>
                                <input type="file" id="filePath" name="filePath"
                                    class="mt-2 block w-full text-sm text-[var(--txt-primary)] border border-[var(--txt-primary)]/30 rounded-lg cursor-pointer bg-transparent focus:outline-none focus:ring-1 focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)]"
                                    required value="PNG">
                            </div>
                            <div class="mb-4">
                                <label for="tanggalUpload"
                                    class="block mb-2 text-lg font-medium text-[var(--txt-primary)]">
                                    Tanggal Upload
                                </label>
                                <input type="date" id="tanggalUpload"
                                    class="bg-transparent border border-[var(--txt-primary)]/30 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)] block w-full p-2 ps-3"
                                    placeholder="Masukkan Tanggal Upload" required value="5 Januari 2025" />
                            </div>
                            <div class="mb-4">
                                <label for="catatan" class="block mb-2 text-lg font-medium text-[var(--txt-primary)]">
                                    Catatan
                                </label>
                                <input type="text" id="catatan"
                                    class="bg-transparent border border-[var(--txt-primary)]/30 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)] block w-full p-2 ps-3"
                                    placeholder="Masukkan Catatan" required
                                    value="Lorem Ipsum Dolor sit Amet Consectur Lorem Ipsum Dolor sit Amet Consectur Lorem Ipsum Dolor sit Amet Consectur" />
                            </div>
                            <div class="flex items-center justify-end mt-8">
                                <button data-modal-hide="modalUbah" type="button"
                                    class="py-2 px-5 text-md hover:cursor-pointer font-medium text-gray-900 focus:outline-none bg-transparent rounded-lg border border-[var(--txt-primary)]/50 hover:bg-[var(--bg-primary2)]/10 focus:z-10 focus:ring-3 focus:ring-[var(--txt-primary)]/20">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="text-[var(--txt-secondary)] ms-2 bg-[var(--bg-primary2)] hover:bg-[var(--bg-primary2)]/90 focus:ring-3 focus:outline-none focus:ring-[var(--bg-secondary)] font-bold rounded-lg text-md hover:cursor-pointer px-5 py-2 text-center">
                                    Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal - Hapus Data -->
        <div id="modalHapus" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-[var(--bg-primary2)]/60 backdrop-blur-md rounded-lg shadow-sm">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-[var(--txt-secondary)]/60 bg-transparent hover:bg-[var(--bg-primary)]/10 hover:cursor-pointer hover:text-[var(--txt-secondary)] rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="modalHapus">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-[var(--txt-secondary)] w-12 h-12" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-[var(--txt-secondary)]/60">
                            Yakin ingin menghapus data ini?
                        </h3>

                        <button data-modal-hide="modalHapus" type="button"
                            class="py-2 px-5 text-md font-medium text-[var(--txt-secondary)]/80 hover:cursor-pointer focus:outline-none bg-transparent rounded-lg border border-[var(--txt-secondary)]/30 hover:bg-[var(--bg-primary)]/10 hover:text-[var(--txt-secondary)] focus:z-10 focus:ring-3 focus:ring-[var(--txt-secondary)]">
                            Batal
                        </button>
                        <button data-modal-hide="modalHapus" type="button"
                            class="ms-1 text-[var(--txt-secondary)] bg-red-600 hover:bg-red-800 focus:ring-3 focus:outline-none focus:ring-red-300 hover:cursor-pointer font-medium rounded-lg text-md inline-flex items-center px-5 py-2 text-center">
                            Hapus
                        </button>
                    </div>
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