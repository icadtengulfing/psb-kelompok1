<?php
session_start();
if (!isset($_SESSION['nik'])) {
  header('Location: ../form-login.php');
  exit;
}

include '../koneksi.php';

$nama = $_SESSION['nama'] ?? 'Pengguna';
$nik = $_SESSION['nik'] ?? '';
$message = '';
$error = '';

$query = "SELECT * FROM pendaftar WHERE nik = '$nik'";
$result = mysqli_query($koneksi, $query);
$user_data = mysqli_fetch_assoc($result);

$foto_profil_path = (!empty($user_data['foto_profil']) && $user_data['foto_profil'] != 'default-profile.jpg') 
                   ? "../uploads/" . $user_data['foto_profil'] 
                   : "../../assets/img/default-profile.jpg";
if(isset($_POST['daftar_siswa'])) {
    
    // Escape data untuk mencegah SQL injection
    $nik = mysqli_real_escape_string($koneksi, $nik);

    $query_pendaftar = "SELECT id_pendaftar FROM pendaftar WHERE nik = '$nik'";
    $result_pendaftar = mysqli_query($koneksi, $query_pendaftar);

if (mysqli_num_rows($result_pendaftar) > 0) {
    $row_pendaftar = mysqli_fetch_assoc($result_pendaftar);
    $id_pendaftar = $row_pendaftar['id_pendaftar'];
} else {
    die("Error: Data pendaftar tidak ditemukan!");
}

$cek_jalur = mysqli_query($koneksi, "SELECT id_jalur FROM jalur_pendaftaran WHERE jenis_jalur = 'Prestasi' LIMIT 1");

if (mysqli_num_rows($cek_jalur) > 0) {
    $row = mysqli_fetch_assoc($cek_jalur);
    $id_jalur = $row['id_jalur'];
}

// Data siswa - escape semua input
$nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
$nama_lengkap_siswa = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap_siswa']);
$nik_siswa = mysqli_real_escape_string($koneksi, $_POST['nik_siswa']);
$nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
$asal_sekolah = mysqli_real_escape_string($koneksi, $_POST['asal_sekolah']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$tempat_lahir = mysqli_real_escape_string($koneksi, $_POST['tempat_lahir']);
$tanggal_lahir = $_POST['tanggal_lahir'];

$tanggal_lahir_mysql = NULL; 

if (!empty($tanggal_lahir)) {
    $timestamp = strtotime($tanggal_lahir);
    
    if ($timestamp !== false) {
        $tanggal_lahir_mysql = date('Y-m-d', $timestamp);
    }
} 

$query_siswa = "INSERT INTO siswa (nis, id_pendaftar, id_jalur, nama_lengkap_siswa, nik_siswa, nisn, asal_sekolah, alamat, tempat_lahir, tanggal_lahir) 
                VALUES ('$nis', '$id_pendaftar', '$id_jalur', '$nama_lengkap_siswa', '$nik_siswa', '$nisn', '$asal_sekolah', '$alamat', '$tempat_lahir', '$tanggal_lahir_mysql')";
$result = mysqli_query($koneksi, $query_siswa);

if ($result) {
    $input_files = [
        'kartuKeluarga' => 'Kartu Keluarga',
        'ijazahSmp' => 'Ijazah SMP', 
        'SKL' => 'Surat Keterangan Lulus',
        'akteLahir' => 'Akte Lahir',
        'pasFoto' => 'Pas Foto',
        'SKCK' => 'SKCK',
        'sertifikatPrestasi' => 'Sertifikat Prestasi',
        'rapor' => 'Rapor'
    ];

    $upload_errors = [];
    $upload_success = [];

    foreach ($input_files as $input_name => $jenis_dokumen) {
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] === 0) {

            $base_dir = "uploads/dokumen/";
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

            // DIPERBAIKI: Gunakan $input_name
            if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $file_path)) {
                // Escape data untuk database
                $nis_escaped = mysqli_real_escape_string($koneksi, $nis);
                $jenis_dokumen_escaped = mysqli_real_escape_string($koneksi, $jenis_dokumen);
                $file_path_escaped = mysqli_real_escape_string($koneksi, $file_path);
                
                // Insert ke database
                $query_dokumen = "INSERT INTO dokumen (nis, nik, jenis_dokumen, file_path, tanggal_upload, status_verifikasi, id_jalur) 
                            VALUES ('$nis_escaped', '$nik', '$jenis_dokumen_escaped', '$file_path_escaped', NOW(), 'Menunggu', $id_jalur)";
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
         $_SESSION['alert_message'] = '<div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 border border-green-300" role="alert">
 <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
   <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
 </svg>
 <span class="sr-only">Info</span>
 <div class="ms-3 text-sm font-medium">
   Data berhasil dikirim dan sedang dalam proses verifikasi. Silakan tunggu konfirmasi selanjutnya.
 </div>
 <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
   <span class="sr-only">Close</span>
   <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
   </svg>
 </button>
</div>';
header("Location: prestasi.php");
exit;
       }
   }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi Pendaftaran Murid Website SMK - PSB</title>

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="../../output.css" rel="stylesheet" />

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
                        <img src="../../assets/img/all-logo/logo-brand-teks-light.svg" class="h-8 me-3"
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
                    <a href="../index.php"
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
                    <a href="../pendaftaran.php"
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
                            <a href="../reguler.php"
                                class="flex items-center w-full py-2 px-4 text-base text-[var(--color-txt-primary2)] transition pl-6 duration-75 rounded-lg group hover:cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10">
                                <img src="../../assets/img/all-card-jalur/logo-reguler.svg" class="h-6 me-3"
                                    alt="Logo Jalur Pendaftaran">
                                REGULER</a>
                        </li>
                        <li>
                            <a href="../prestasi.php"
                                class="flex items-center w-full py-2 px-4 text-base text-[var(--color-txt-primary2)] transition pl-6 duration-75 rounded-lg group hover:cursor-pointer bg-[var(--bg-primary2)]/30 hover:bg-[var(--bg-primary2)]/20">
                                <img src="../../assets/img/all-card-jalur/logo-prestasi.svg" class="h-6 me-3"
                                    alt="Logo Jalur Pendaftaran">
                                PRESTASI</a>
                        </li>
                        <li>
                            <a href="../afirmasi.php"
                                class="flex items-center w-full py-2 px-4 text-base text-[var(--color-txt-primary2)] transition pl-6 duration-75 rounded-lg group hover:cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10">
                                <img src="../../assets/img/all-card-jalur/logo-afirmasi.svg" class="h-4 me-3"
                                    alt="Logo Jalur Pendaftaran">
                                AFIRMASI</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div
                class="absolute bottom-2 left-0 w-full border-t border-[var(--bg-primary)]/20 bg-transparent px-4 py-4">
                <hr class="h-px my-4 bg-[var(--txt-primary)]/20 border-0">
                <a href="../edit-profile.php"
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
                        Form Pendaftaran Calon Siswa
                    </h1>
                    <p class="text-lg lg:text-2xl text-[var(--txt-primary)] mt-0 lg:mt-2">
                        Pendaftaran Melalui Jalur <span class="font-bold">Prestasi</span>
                    </p>
                </div>
                <img src="../../assets/img/img-greet-ds.png"
                    class="w-full border border-[var(--bg-primary2)]/30 mx-auto lg:mx-0 flex items-center justify-center rounded-xl shadow-md"
                    alt="Image Greet Dashboard">
            </div>
            <div class="flex flex-col gap-8 mb-8">
            <form class="max-w-4xl" method="post" enctype="multipart/form-data">
                <div class="mb-5">
                        <label for="nis" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
                            NIS
                        </label>
                        <input type="number" id="nik" name="nis"
                            class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primray2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
                            placeholder="Masukkan NIS Calon Siswa" required />
                    </div>
                    <div class="mb-5">
                        <label for="namaLengkap"
                            class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
                            Nama Lengkap
                        </label>
                        <input type="text" id="namaLengkap" name="nama_lengkap_siswa"
                            class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primray2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
                            placeholder="Masukkan Nama Lengkap" required />
                    </div>
                    <div class="mb-5">
                        <label for="nik" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
                            NIK
                        </label>
                        <input type="number" id="nik" name="nik_siswa"
                            class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primray2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
                            placeholder="Masukkan NIK Calon Siswa" required />
                    </div>
                    <div class="mb-5">
                        <label for="nisn" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
                            NISN
                        </label>
                        <input type="number" id="nisn" name="nisn"
                            class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primray2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
                            placeholder="Masukkan NISN" required />
                    </div>
                    <div class="mb-5">
                        <label for="asalSekolah"
                            class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
                            Asal Sekolah
                        </label>
                        <input type="text" id="asalSekolah" name="asal_sekolah"
                            class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primray2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
                            placeholder="Masukkan Sekolah Asal" required />
                    </div>
                    <div class="mb-5">
                        <label for="alamat" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
                            Alamat
                        </label>
                        <textarea id="alamat" rows="3" name="alamat"
                            class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primray2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
                            placeholder="Masukkan Alamat Tempat Tinggal"></textarea>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="w-full">
                            <div>
                                <label for="tempatLahir"
                                    class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">Tempat
                                    Lahir</label>
                                <select id="tempatLahir" name="tempat_lahir"
                                    class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-sm rounded-lg focus:ring-[var(--bg-primary2)]/50 focus:border-[var(--bg-primary2)] block w-full p-3.5 cursor-pointer">
                                    <option selected>Pilih Tempat Lahir</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Tangerang">Tangerang</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Semarang">Semarang</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                </select>
                            </div>
                        </div>

                        <div class="w-full relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                                <svg class="w-4 h-4 mt-9 text-[var(--txt-primary)]/50" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <label for="countries"
                                class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">Tanggal
                                lahir</label>
                            <input datepicker id="default-datepicker" type="text" name="tanggal_lahir"
                                class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:border-[var(--bg-primary2)] block w-full ps-10 p-3"
                                placeholder="Select date">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-6">
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">Upload Kartu Keluarga</p>
                            <label for="kartuKeluarga"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="kartuKeluarga" type="file" name="kartuKeluarga" class="hidden"
                                    onchange="previewFileName('kartuKeluarga', 'previewKK')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewKK" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic"></p>
                        </div>
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">Upload Ijazah SMP</p>
                            <label for="ijazahSmp"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX.
                                        2MB)</p>
                                </div>
                                <input id="ijazahSmp" type="file" class="hidden" name="ijazahSmp"
                                    onchange="previewFileName('ijazahSmp', 'previewIjazah')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewIjazah" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic"></p>
                        </div>
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">Upload SKL</p>
                            <label for="SKL"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX.
                                        2MB)</p>
                                </div>
                                <input id="SKL" type="file" class="hidden" name="SKL"
                                    onchange="previewFileName('SKL', 'previewSKL')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewSKL" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-6">
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">Upload Akte Lahir</p>
                            <label for="akteLahir"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX.
                                        2MB)</p>
                                </div>
                                <input id="akteLahir" type="file" class="hidden" name="akteLahir"
                                    onchange="previewFileName('akteLahir', 'previewAkteLahir')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewAkteLahir" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic"></p>
                        </div>
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">Upload Pas Foto 3x4</p>
                            <label for="pasFoto"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX.
                                        2MB)</p>
                                </div>
                                <input id="pasFoto" type="file" class="hidden" name="pasFoto"
                                    onchange="previewFileName('pasFoto', 'previewPasFoto')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewPasFoto" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic"></p>
                        </div>
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">Upload SKCK</p>
                            <label for="SKCK"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX.
                                        2MB)</p>
                                </div>
                                <input id="SKCK" type="file" class="hidden" name="SKCK"
                                    onchange="previewFileName('SKCK', 'previewSKCK')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewSKCK" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic"></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-6">
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">
                                Upload Sertifikat
                                Prestasi
                            </p>
                            <label for="sertifikatPrestasi"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX.
                                        2MB)</p>
                                </div>
                                <input id="sertifikatPrestasi" type="file" class="hidden" name="sertifikatPrestasi"
                                    onchange="previewFileName('sertifikatPrestasi', 'previewSertifikatPrestasi')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewSertifikatPrestasi" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic">
                            </p>
                        </div>
                        <div class="flex flex-col items-start justify-center w-full">
                            <p class="font-semibold text-md mb-2">Upload Rapor</p>
                            <label for="rapor"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-[var(--bg-primary2)]/50 border-dashed rounded-lg cursor-pointer bg-transparent hover:bg-[var(--bg-primary2)]/10 transition duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-[var(--txt-primary)]/50" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-[var(--txt-primary)]/50"><span
                                            class="font-semibold">Klik untuk mengunggah</span></p>
                                    <p class="text-sm text-[var(--txt-primary)]/50">PNG, JPG or JPEG (MAX.
                                        2MB)</p>
                                </div>
                                <input id="rapor" type="file" class="hidden" name="rapor"
                                    onchange="previewFileName('rapor', 'previewRapor')" />
                            </label>
                            <!-- Penampil nama file -->
                            <p id="previewRapor" class="mt-2 text-sm text-[var(--txt-primary)]/70 italic"></p>
                        </div>
                    </div>

                    <div class="flex items-start mb-2">
                        <div class="flex items-center h-6">
                            <input id="S&K" type="checkbox" value=""
                                class="w-5 h-5 border border-[var(--txt-primary)]/50 rounded-sm bg-[var(--bg-primary2)]/10 focus:ring-3 focus:ring-[var(--bg-primary2)]/50 cursor-pointer"
                                required />
                        </div>
                        <label for="S&K"
                            class="ms-2 text-md font-medium text-[var(--txt-primary)]/80 cursor-pointer">Saya setuju
                            dengan <span class="text-[var(--bg-primary2)] hover:underline font-bold">Syarat &
                                Ketentuan</span></label>
                    </div>
                    <div class="flex items-start mb-6">
                        <div class="flex items-center h-6">
                            <input id="Reminder" type="checkbox" value=""
                                class="w-5 h-5 border border-[var(--txt-primary)]/50 rounded-sm bg-[var(--bg-primary2)]/10 focus:ring-3 focus:ring-[var(--bg-primary2)]/50 cursor-pointer"
                                required />
                        </div>
                        <label for="Reminder"
                            class="ms-2 text-md font-medium text-[var(--txt-primary)]/80 cursor-pointer">Sudah yakin
                            dengan data siswa ini</label>
                    </div>
                    <button type="submit" name="daftar_siswa"
                        class="text-white bg-[var(--bg-primary2)] hover:bg-[var(--bg-secondary)] focus:ring-3 focus:outline-none focus:ring-[var(--bg-primary3)] font-bold rounded-lg text-lg w-full px-5 py-2.5 text-center cursor-pointer shadow-lg transition duration-300">Kirim</button>
                </form>
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