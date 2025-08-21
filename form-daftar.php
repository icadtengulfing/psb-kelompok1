<?php
    include 'koneksi.php';
    
    if(isset($_POST['daftar']))
    {
      $namaLengkap = $_POST['namaLengkap'];
      $nik = $_POST['nik'];
      $password = $_POST['password'];
      $konfirmasiPassword = $_POST['konfirmasiPassword'];
      $email = $_POST['email'];
      $noHp = $_POST['noHp'];
      $terms = $_POST['terms'];

      if($password !== $konfirmasiPassword) {
        echo "<script>alert('Password dan konfirmasi tidak cocok'); window.history.back();</script>";
        exit;
      }
      
      $hash_password = password_hash($password, PASSWORD_DEFAULT);

      $kueri = "INSERT INTO pendaftar (nama_lengkap_ortu, nik, password, email, no_hp)
VALUES ('$namaLengkap', '$nik', '$hash_password', '$email', '$noHp')";

      if(mysqli_query($koneksi, $kueri)) {
        header('location:form-login.php');
        exit;
      } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
        exit;
      }
    }
?>     
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="./output.css" rel="stylesheet" />

    <!-- Website Pendaftaran Siswa icon -->
    <link rel="shortcut icon" href="assets/img/all-logo/logo-brand-light.svg" type="image/x-icon" />

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="font-[inter]">

    <!-- Form Login -->

    <section class="h-screen grid grid-cols-1 xl:grid-cols-2">
        <!-- Left: Login Form -->
        <div class="mb-4">
            <label
              class="block mb-2 text-xl text-[var(--txt-primary)]"
              for="namaLengkap"
              >Nama Lengkap</label
            >
            <input
              name="namaLengkap"
              class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
              type="text"
              id="namaLengkap"
              placeholder="Nama Lengkap Kamu"
              required
            />
          </div>
          <div class="mb-6">
            <label
              class="block mb-2 text-xl text-[var(--txt-primary)]"
              for="nik"
              >NIK</label
            >
            <input
              name="nik"
              class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
              type="text"
              autocomplete="username"
              id="nik"
              placeholder="Masukkan NIK Kamu"
              required
            />
          </div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="mb-6">
              <label
                class="block mb-2 text-xl text-[var(--txt-primary)]"
                for="email"
                >Email</label
              >
              <input
                name="email"
                class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
                type="email"
                id="email"
                placeholder="Masukkan Email Kamu"
                required
              />
            </div>
            <div class="mb-6">
              <label
                class="block mb-2 text-xl text-[var(--txt-primary)]"
                for="noHp"
                >No. HP</label
              >
              <input
                name="noHp"
                class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
                type="number"
                id="noHp"
                placeholder="Masukkan Nomor Hp Kamu"
                required
              />
            </div>
          </div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="mb-6">
              <label
                class="block mb-2 text-xl text-[var(--txt-primary)]"
                for="password"
                >Password</label
              >
              <input
                name="password"
                class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
                type="password"
                id="password"
                placeholder="Masukkan Nomor Hp Kamu"
                required
              />
            </div>
            <div class="mb-6">
              <label
                class="block mb-2 text-xl text-[var(--txt-primary)]"
                for="konfirmasiPassword"
                >Konfirmasi Password</label
              >
              <input
                name="konfirmasiPassword"
                class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
                type="password"
                id="konfirmasiPassword"
                placeholder="Masukkan Nomor Hp Kamu"
                required
              />
            </div>
          </div>
          <div class="flex items-start">
            <div class="flex items-center h-5">
              <input
                name="terms"
                id="terms"
                type="checkbox"
                value=""
                class="w-5 h-5 border border-[var(--bg-primary2)] cursor-pointer rounded-sm bg-[var(--bg-primary)] focus:ring-3 focus:ring-blue-800"
                required
              />
            </div>
            <label
              for="terms"
              class="ms-3 text-sm font-medium text-[var(--txt-primary)]"
              >Saya setuju dengan
              <a href="#" class="text-blue-700 font-bold hover:underline"
                >Syarat & Ketentuan</a
              ></label
            >
          </div>
          <button
            name="daftar"
            type="submit"
            class="mt-8 cursor-pointer w-full py-3 px-4 bg-[var(--bg-primary2)] hover:bg-[var(--bg-secondary)] text-[var(--txt-secondary)] font-bold rounded-xl shadow-md text-xl transition-all duration-500"
          >
            DAFTAR
          </button>

          <hr class="h-px my-6 bg-[var(--bg-primary2)]" />
          <div class="mt-0 text-center xl:text-start">
            <span
              class="text-[var(--txt-primary)] text-md md:text-xl font-normal"
              >Sudah Punya Akun?</span
            >
            <a
              class="text-[var(--txt-primary)] underline text-xl"
              href="form-login.php"
              >Masuk</a
            >
          </div>
        </form>
      </div>

      <!-- Right: Carousel -->
      <div class="hidden xl:block relative w-full h-full overflow-hidden">
        <div class="relative h-full w-full">
          <div
            class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
          >
            <img
              src="assets/img/img-carousel-1.png"
              class="object-cover w-full h-full"
              alt="Image 1"
            />
          </div>
          <!-- Tambahkan lebih banyak slide jika ingin -->
          <!-- Buat script carousel dinamis jika mau -->
        </div>
      </div>
    </section>

        <!-- Right: Carousel -->
        <div class="hidden xl:block relative w-full h-full overflow-hidden">
            <div class="relative h-full w-full">
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out">
                    <img src="assets/img/img-carousel-1.png" class="object-cover w-full h-full" alt="Image 1">
                </div>
                <!-- Tambahkan lebih banyak slide jika ingin -->
                <!-- Buat script carousel dinamis jika mau -->
            </div>
        </div>
    </section>

    <!-- Tutup Form Login -->

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>