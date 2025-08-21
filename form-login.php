<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])) {
    $nik = $_POST['nik'];
    $password = $_POST['password'];

    // SELECT data dari database
    $query = "SELECT * FROM pendaftar WHERE nik='$nik'";
    $cek = mysqli_query($koneksi, $query);
    $user = mysqli_fetch_array($cek);
    
    if($user && password_verify($password, $user['password'])) {
      $_SESSION['nik'] = $user['nik'];
      header("Location: dashboard/index.php"); 
      exit;
} else {
  echo "<script>alert('Username atau Password salah!'); window.history.back();</script>";
}
}
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

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
        <div class="flex items-center justify-center xl:justify-start bg-[var(--bg-primary)] p-4 xl:p-10">
            <form class="w-full max-w-xl bg-transparent ms-0 xl:ms-12" method="post" action="">
                <h1 class="mb-10 text-2xl md:text-4xl lg:text-5xl font-bold text-[var(--txt-primary)]">Hallo, <br>
                    Selamat Datang Kembali!</h1>
                <div class="mb-6">
                    <label class="block mb-2 text-xl text-[var(--txt-primary)]" for="nik">NIK</label>
                    <input
                        class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
                        type="number" name="nik" id="nik" placeholder="Masukkan NIK Kamu" required>
                </div>
                <div class="mb-12">
                    <label class="block mb-2 text-[var(--txt-primary)] text-xl" for="password">Password</label>
                    <input
                        class="text-lg w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-[var(--bg-primary2)] bg-transparent text-[var(--txt-primary)]"
                        type="password" name="password" id="password" placeholder="Maksimal 8 Karakter" required>
                </div>
                <div class="my-3">
                    <button name="login" type="submit"
                        class="block w-full text-center cursor-pointer py-3 px-4 bg-[var(--bg-primary2)] hover:bg-[var(--bg-secondary)] text-[var(--txt-secondary)] font-bold rounded-xl shadow-md text-xl transition-all duration-500">
                        MASUK
                    </button>
                </div>
                <hr class="h-px my-6 bg-[var(--bg-primary2)]">
                <div class="mt-0 text-center xl:text-start">
                    <span class="text-[var(--txt-primary)] text-md md:text-xl font-normal">Belum Punya Akun?</span>
                    <a class="text-[var(--txt-primary)] underline text-xl" href="form-daftar.php">Daftar</a>
                </div>
            </form>
        </div>

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