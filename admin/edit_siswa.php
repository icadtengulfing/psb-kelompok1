<?php
session_start();
include '../koneksi.php';
if (!isset($_SESSION['username'])) {
  header('location: index.php');
  exit;
}

$query_data = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$_GET[edit]'");
$data = mysqli_fetch_array($query_data);

if (isset($_POST['ubah_akun'])) {
  $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
  $nama_lengkap_siswa = mysqli_real_escape_string($koneksi, $_POST['namaLengkapEdit']);
  $id_pendaftar = mysqli_real_escape_string($koneksi, $_POST['id_pendaftar']);
  $id_jalur = mysqli_real_escape_string($koneksi, $_POST['id_jalur']);
  $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
  $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
  $asal_sekolah = mysqli_real_escape_string($koneksi, $_POST['asal_sekolah']);
  $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
  $tempat_lahir = mysqli_real_escape_string($koneksi, $_POST['tempat_lahir']);
  // hash password
  $query_edit = "UPDATE siswa 
                                   SET nama_lengkap_siswa = '$nama_lengkap_siswa',
                                       id_jalur = '$id_jalur',
                                       nisn = '$nisn',
                                       nik_siswa = '$nik',
                                       asal_sekolah = '$asal_sekolah',
                                       alamat = '$alamat',
                                       tempat_lahir = '$tempat_lahir'
                                   WHERE nis = '$nis'";

  $result_edit = mysqli_query($koneksi, $query_edit);

  if ($result_edit) {
    echo "<script>
                                alert('Data berhasil diubah!');
                                window.location.href = 'daftar-siswa.php';
                              </script>";
  } else {
    echo "<script>
                                alert('Gagal mengubah data!');
                                window.location.href = 'edit-siswa.php';
                              </script>";
  }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Akun Admin Website SMK - PSB</title>

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
            class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg hover:bg-[var(--bg-primary2)]/20 group transition duration-200">
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
            class="flex items-center py-2 px-4 text-[var(--txt-primary)] rounded-lg bg-[var(--bg-primary2)]/30 hover:bg-[var(--bg-primary2)]/10 group transition duration-200">
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
  <section class="p-4 lg:p-8 sm:ml-64">
    <div class="mt-26 lg:mt-24">
      <div class="grid grid-cols-1 xl:grid-cols-[3fr_1fr] gap-4 lg:gap-8 mb-8">
        <div
          class="flex flex-col justify-center items-start p-6 lg:p-12 rounded-xl bg-[var(--bg-primary3)] border border-[var(--bg-primary2)]/30 shadow-md">
          <h1 class="text-xl lg:text-4xl font-bold text-[var(--txt-primary)]">
            Edit Akun Admin
          </h1>
          <p class="text-lg lg:text-2xl text-[var(--txt-primary)] mt-0 lg:mt-2">
            Ubah informasi akun administrator
          </p>
        </div>
        <img src="../assets/img/img-greet-ds.png"
          class="w-full border border-[var(--bg-primary2)]/30 mx-auto lg:mx-0 flex items-center justify-center rounded-xl shadow-md"
          alt="Image Greet Dashboard">
      </div>

      <div class="flex flex-col gap-8 mb-8">
        <form class="max-w-4xl" method="post" enctype="multipart/form-data">
          <input type="hidden" name="nis" value="<?php echo htmlspecialchars($data['nis']); ?>">
          <div class="mb-5">
            <label for="namaLengkap" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              Nama Lengkap
            </label>
            <input type="text" id="namaLengkap" name="namaLengkapEdit"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
              placeholder="Masukkan Nama Lengkap" value="<?php echo $data['nama_lengkap_siswa']; ?>" />
          </div>

          <div class="mb-5">
            <label for="id_pendaftar" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              ID Pendaftar
            </label>
            <input type="text" id="id_pendaftar" name="id_pendaftar"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
            value="<?php echo $data['id_pendaftar']; ?>" disabled/>
            </div>

          <div class="mb-5">
            <label for="id_jalur" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              ID Jalur
            </label>
            <input type="number" id="id_jalur" name="id_jalur"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
              placeholder="Masukkan ID Jalur" value="<?php echo $data['id_jalur']; ?>" />
          </div>

          <div class="mb-5">
            <label for="nisn" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              NISN
            </label>
            <input type="number" id="nisn" name="nisn"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
              placeholder="Masukkan NISN" value="<?php echo $data['nisn']; ?>" />
          </div>

          <div class="mb-5">
            <label for="nik" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              NIK
            </label>
            <input type="number" id="nik" name="nik"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
              placeholder="Masukkan NIK" value="<?php echo $data['nik_siswa']; ?>" />
          </div>

          <div class="mb-5">
            <label for="asal_sekolah" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              Asal Sekolah
            </label>
            <input type="text" id="asal_sekolah" name="asal_sekolah"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
              placeholder="Masukkan Asal Sekolah" value="<?php echo $data['asal_sekolah']; ?>" />
          </div>

          <div class="mb-5">
            <label for="alamat" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              Alamat
            </label>
            <input type="text" id="alamat" name="alamat"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
              placeholder="Masukkan alamat" value="<?php echo $data['alamat']; ?>" />
          </div>

          <div class="mb-5">
            <label for="tempat_lahir" class="block mb-2 text-md md:text-lg font-medium text-[var(--txt-primary)]">
              Tenpat Lahir
            </label>
            <input type="tempat_lahir" id="tempat_lahir" name="tempat_lahir"
              class="bg-transparent border border-[var(--txt-primary)]/50 text-[var(--txt-primary)] text-md rounded-lg focus:ring-[var(--bg-primary2)] focus:bg-[var(--bg-primary2)]/10 focus:border-[var(--bg-primary2)] block w-full py-2.5 px-3.5"
              placeholder="Masukkan Tempat Lahir" value="<?php echo $data['tempat_lahir']; ?>" />
          </div>

          <div class="flex items-center justify-end mt-8 gap-3">
            <button type="button" onclick="history.back()"
              class="py-2.5 px-5 text-md hover:cursor-pointer font-medium text-gray-900 focus:outline-none bg-transparent rounded-lg border border-[var(--txt-primary)]/50 hover:bg-[var(--bg-primary2)]/10 focus:z-10 focus:ring-3 focus:ring-[var(--txt-primary)]/20 transition duration-300">
              Batal
            </button>
            <button type="submit" name="ubah_akun"
              class="text-[var(--txt-secondary)] bg-[var(--bg-primary2)] hover:bg-[var(--bg-primary2)]/90 focus:ring-3 focus:outline-none focus:ring-[var(--bg-secondary)] font-bold rounded-lg text-md hover:cursor-pointer px-5 py-2.5 text-center transition duration-300 shadow-lg">
              Ubah Akun
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- Tutup Main Content -->
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

  <!-- Flowbite Script Chart -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>

  <!-- Script Eksternal -->
  <script src="js/dashboard.js"></script>

</body>

</html>