<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website SMK - PSB</title>

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

    <!-- Navbar -->

    <nav
        class="z-50 bg-[var(--bg-primary)]/60 backdrop-blur-md border-b border-[var(--bg-secondary)] fixed w-full start-0 end-0 top-0">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <!-- Logo -->
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="assets/img/all-logo/logo-brand-teks-light.svg" class="h-10 lg:h-16" alt="Web PSB Logo" />
            </a>

            <!-- Tombol (DESKTOP) -->
            <div class="hidden sm:flex sm:order-2 space-x-4 rtl:space-x-reverse">
                <a href="form-daftar.php"
                    class="text-[var(--txt-primary)] focus:ring-3 ring ring-[var(--bg-primary2)] font-medium rounded-lg text-md lg:text-lg px-4 py-2 lg:px-6 lg:py-2.5 text-center dark:bg-transparent hover:bg-[var(--bg-primary2)]/20 hover:cursor-pointer transition hover:shadow-lg">
                    Daftar
                </a>
                <a href="form-login.php"
                    class="focus:ring-3 ring ring-[var(--bg-secondary3)] font-medium rounded-lg text-md lg:text-lg px-4 py-2 lg:px-6 lg:py-2.5 text-center text-[var(--txt-secondary)] bg-[var(--bg-primary2)] hover:bg-[var(--bg-primary2)]/90 hover:cursor-pointer transition shadow-lg">
                    Masuk
                </a>
            </div>

            <!-- HAMBURGER MENU (MOBILE) -->
            <button data-collapse-toggle="navbar-cta" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-600 rounded-lg sm:hidden focus:outline-none focus:ring-2 focus:ring-gray-200 hover:bg-[var(--bg-primary2)]/10 cursor-pointer dark:focus:ring-gray-600"
                aria-controls="navbar-cta" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <!-- NAVIGATION LINKS + TOMBOL DAFTAR/MASUK (MOBILE) -->
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
                <ul
                    class="text-lg flex flex-col font-light p-4 md:p-0 mt-4 md:bg-transparent border border-[var(--bg-primary2)] bg-transparent rounded-lg sm:space-x-10 rtl:space-x-reverse sm:flex-row sm:mt-0 sm:border-0">

                    <!-- TOMBOL DAFTAR & MASUK (MOBILE SAJA) -->
                    <li class="block sm:hidden mt-10 space-y-3">
                        <a href="form-daftar.php"
                            class="block w-full text-[var(--txt-primary)] border border-[var(--bg-primary2)]/10 focus:ring-3 ring ring-[var(--bg-primary2)] font-medium rounded-lg text-md px-4 py-2 text-center bg-transparent hover:bg-[var(--bg-primary2)]/20 hover:cursor-pointer transition">
                            Daftar
                        </a>
                        <a href="form-login.php"
                            class="block w-full text-[var(--txt-primary)] border border-[var(--bg-primary2)]/10 focus:ring-3 ring ring-[var(--bg-primary2)] font-medium rounded-lg text-md px-4 py-2 text-center bg-transparent hover:bg-[var(--bg-primary2)]/20 hover:cursor-pointer transition">
                            Masuk
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Tutup Navbar -->

    <!-- Marquee -->


    <!-- Tutup Marquee -->

    <!-- Hero Section -->

    <section class="pt-20 bg-[var(--bg-primary)] h-screen flex items-center justify-center">
        <div
            class="z-50 fixed top-18 lg:top-23 w-full overflow-hidden whitespace-nowrap bg-[var(--bg-primary2)] text-[var(--txt-primary)]">
            <div class="animate-marquee px-6 py-2 text-md sm:text-base text-[var(--txt-secondary)]">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum reiciendis est corporis perspiciatis maxime unde atque temporibus inventore quibusdam architecto. Inventore minima doloremque praesentium iste ipsam incidunt quia. Sed dolores magni quaerat voluptatibus, fugit nemo natus architecto corrupti, ullam dolorem cupiditate assumenda, minima aperiam esse corporis labore sit quod fugiat exercitationem iusto deleniti magnam eius tempore hic. Explicabo corporis minus consequuntur voluptatem! Reprehenderit nulla assumenda quo quos. Aut nemo omnis adipisci, doloribus assumenda iure repudiandae at in iusto consectetur expedita necessitatibus perferendis praesentium quia dignissimos rerum vitae, ea fugiat earum saepe ducimus? Est cupiditate unde quisquam officia nostrum ad iste?
            </div>
        </div>
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16">
            <div class="flex flex-col justify-center">
                <h1 class="mb-2 lg:mb-4 text-4xl font-bold md:text-5xl lg:text-7xl text-[var(--txt-primary2)]">
                    Daftarkan Anak Anda di Sini!</h1>
                <h1 class="mb-2 lg:mb-4 text-xl font-semibold md:text-2xl lg:text-4xl text-[var(--txt-primary2)]">
                    di Sekolah Terpercaya Global</h1>
                <p class="mb-8 text-start lg:text-justify text-lg font-normal text-[var(--txt-primary2)] lg:text-xl">
                    Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor sit amet
                    consectur Lorem Ipsum dolor sit amet consectur</p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0">
                    <a href="#jadwal"
                        class="shadow-lg inline-flex justify-center items-center py-3 px-5 text-base text-md font-medium text-center text-[var(--txt-secondary)] rounded-lg bg-[var(--bg-primary2)] focus:ring-4 focus:ring-blue-300 border border-transparent hover:border-[var(--bg-primary2)] hover:bg-transparent hover:text-[var(--txt-primary)] hover:shadow-none transition duration-300">
                        Lihat Jadwal
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                    <a href="#statistik"
                        class="flex items-center justify-center py-3 px-6 sm:ms-4 text-md font-medium text-[var(--txt-primary)] focus:outline-none bg-transparent rounded-lg border border-[var(--bg-primary2)] hover:bg-[var(--bg-primary2)]/20 focus:z-10 focus:ring-3 focus:ring-gray-100 transition duration-300 shadow-lg hover:shadow-none">
                        Lihat Jalur
                    </a>
                </div>
            </div>
            <div>
                <img src="assets/img/img-hero.png" class="rounded-xl shadow-lg hidden sm:block" alt="Image Hero">
            </div>
        </div>
    </section>

    <!-- Tutup Hero Section -->

    <!-- About Section -->

    <section class="py-12 bg-[var(--bg-primary)]" id="tentang">
        <div class="w-full max-w-screen-xl px-4 md:px-5 lg:px-5 mx-auto">
            <div class="w-full justify-start items-center gap-10 lg:gap-16 grid lg:grid-cols-2 grid-cols-1">
                <img class="lg:mx-0 mx-auto rounded-xl shadow-lg" src="assets/img/img-about-1.png"
                    alt="about Us image" />
                <div class="w-full flex-col justify-start lg:items-start items-start gap-6 inline-flex">
                    <div class="w-full flex-col justify-start lg:items-start gap-4 flex">
                        <h2
                            class="text-[var(--txt-primary2)] text-xl md:text-3xl lg:text-4xl font-bold leading-normal text-center md:text-center">
                            Standar Internasional</h2>
                        <p
                            class="text-[var(--txt-primary2)] text-md sm:text-lg md:text-xl font-normal md:text-start lg:text-start">
                            Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor
                            sit amet consectur Lorem Ipsum dolor sit amet consectur. Lorem Ipsum dolor sit amet
                            consectur Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor sit amet consectur Lorem
                            Ipsum dolor sit amet consectur sit amet consectur
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="w-full justify-center items-center mt-10 lg:mt-22 gap-10 lg:gap-16 grid lg:grid-cols-2 grid-cols-1">
                <div class="w-full flex-col justify-start lg:items-start items-start gap-6 inline-flex">
                    <div class="w-full flex-col justify-start lg:items-start gap-4 flex">
                        <h2
                            class="text-[var(--txt-primary2)] text-xl md:text-3xl lg:text-4xl font-bold leading-normal text-center md:text-center">
                            Edukasi Masa Depan</h2>
                        <p
                            class="text-[var(--txt-primary2)] text-md sm:text-lg md:text-xl font-normal md:text-start lg:text-start">
                            Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor
                            sit amet consectur Lorem Ipsum dolor sit amet consectur. Lorem Ipsum dolor sit amet
                            consectur Lorem Ipsum dolor sit amet consectur Lorem Ipsum dolor sit amet consectur Lorem
                            Ipsum dolor sit amet
                        </p>
                    </div>
                </div>
                <div class="ms-0 lg:ms-8 flex items-center justify-center gap-10">
                    <img class="lg:mx-0 mx-auto rounded-xl shadow-lg w-xs" src="assets/img/img-about-2.png"
                        alt="about Us image" />
                    <img class="lg:mx-0 mx-auto rounded-xl shadow-lg w-xs hidden xl:block"
                        src="assets/img/img-about-2.png" alt="about Us image" />
                </div>
            </div>
        </div>
    </section>

    <!-- Tutup About Section -->

    <!-- Statistik Pendaftaran -->

    <section class="py-28 bg-[var(--bg-primary)]" id="statistik">
        <div class="w-full max-w-screen-xl px-4 md:px-5 lg:px-5 mx-auto">
            <div class="w-full grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-10 lg:gap-16 items-start">
                <div class="flex flex-col justify-start items-center lg:items-start gap-6">
                    <h1
                        class="text-[var(--txt-primary2)] text-xl md:text-3xl lg:text-4xl font-bold leading-normal mx-auto md:mx-0">
                        Jalur Pendaftaran</h1>
                    <div class="flex flex-col items-start justify-center gap-4">
                        <img class="lg:mx-0 mx-auto w-2/3 rounded-xl shadow-lg"
                            src="assets/img/all-card-jalur/jalur-reguler.svg" alt="Jalur Reguler" />
                        <img class="lg:mx-0 mx-auto w-2/3 rounded-xl shadow-lg"
                            src="assets/img/all-card-jalur/jalur-prestasi.svg" alt="Jalur Prestasi" />
                        <img class="lg:mx-0 mx-auto w-2/3 rounded-xl shadow-lg"
                            src="assets/img/all-card-jalur/jalur-afirmasi.svg" alt="Jalur Afirmasi" />
                    </div>
                </div>
                <div class="flex flex-col justify-start items-center lg:items-start gap-6">
                    <h1
                        class="text-[var(--txt-primary2)] text-xl md:text-3xl lg:text-4xl font-bold leading-normal mx-auto lg:mx-0">
                        Statistik Pendaftaran</h1>
                    <div class="flex flex-col items-start justify-center gap-4">
                        <img class="lg:mx-0 mx-auto w-full rounded-xl shadow-lg"
                            src="assets/img/statistik-pendaftaran.png" alt="Statistik Pendaftaran" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutup Statistik Pendaftaran -->

    <!-- Jadwal Pendaftaran -->

    <section class="py-24 px-4 bg-[var(--bg-primary)]" id="jadwal">
        <div class="w-full max-w-screen-xl px-4 md:px-5 lg:px-5 mx-auto">
            <h1
                class="text-[var(--txt-primary)] text-xl md:text-3xl lg:text-5xl font-bold leading-normal text-center lg:text-start">
                Jadwal Pendaftaran PPDB Online</h1>
            <h1
                class="text-[var(--txt-primary)] text-lg md:text-xl lg:text-3xl mb-10 font-normal leading-normal text-center lg:text-start">
                Jadwal Pendaftaran Peserta Didik Baru School</h1>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Item Agenda -->
                <div class="space-y-5">
                    <h2 class="text-xl md:text-3xl lg:text-4xl font-bold text-[var(--txt-primary2)] mb-10">Agenda
                        Terkait</h2>
                    <div class="flex items-start gap-4 border-b pb-3">
                        <div class="w-16 h-16 bg-[var(--bg-secondary)] rounded-md"></div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-[var(--txt-primary)]">Agenda 1 Lorem Ipsum D</h3>
                            <p class="text-sm text-[var(--txt-primary)]/60">Lorem Ipsum Dolor Sit</p>
                        </div>
                        <div class="flex items-center text-sm text-[var(--txt-primary)]/60">
                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z" />
                            </svg>
                            1 Juni 2025
                        </div>
                    </div>
                    <div class="flex items-start gap-4 border-b pb-3">
                        <div class="w-16 h-16 bg-[var(--bg-secondary)] rounded-md"></div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-[var(--txt-primary)]">Agenda 1 Lorem Ipsum D</h3>
                            <p class="text-sm text-[var(--txt-primary)]/60">Lorem Ipsum Dolor Sit</p>
                        </div>
                        <div class="flex items-center text-sm text-[var(--txt-primary)]/60">
                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z" />
                            </svg>
                            1 Juni 2025
                        </div>
                    </div>
                    <div class="flex items-start gap-4 border-b pb-3">
                        <div class="w-16 h-16 bg-[var(--bg-secondary)] rounded-md"></div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-[var(--txt-primary)]">Agenda 1 Lorem Ipsum D</h3>
                            <p class="text-sm text-[var(--txt-primary)]/60">Lorem Ipsum Dolor Sit</p>
                        </div>
                        <div class="flex items-center text-sm text-[var(--txt-primary)]/60">
                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z" />
                            </svg>
                            1 Juni 2025
                        </div>
                    </div>
                    <div class="flex items-start gap-4 border-b pb-3">
                        <div class="w-16 h-16 bg-[var(--bg-secondary)] rounded-md"></div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-[var(--txt-primary)]">Agenda 2 Lorem Ips</h3>
                            <p class="text-sm text-[var(--txt-primary)]/60">Lorem Ipsum Dolor Sit MAet</p>
                        </div>
                        <div class="flex items-center text-sm text-[var(--txt-primary)]/60">
                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z" />
                            </svg>
                            1 Juni 2025
                        </div>
                    </div>
                    <div class="flex items-start gap-4 border-b pb-3">
                        <div class="w-16 h-16 bg-[var(--bg-secondary)] rounded-md"></div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-[var(--txt-primary)]">Agenda 2 Lorem Ips</h3>
                            <p class="text-sm text-[var(--txt-primary)]/60">Lorem Ipsum Dolor Sit MAet</p>
                        </div>
                        <div class="flex items-center text-sm text-[var(--txt-primary)]/60">
                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z" />
                            </svg>
                            1 Juni 2025
                        </div>
                    </div>

                    <!-- Tambahkan item agenda lainnya sesuai kebutuhan -->
                </div>
                <div class="w-full rounded-2xl">
                    <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-5">
                        <div class="flex items-center gap-4">
                            <h5 class="text-xl leading-8 font-semibold text-gray-900">Juli 2025</h5>
                            <div class="flex items-center">
                                <button
                                    class="text-indigo-600 p-1 rounded transition-all duration-300 hover:text-white hover:bg-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                        fill="none">
                                        <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentcolor"
                                            stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                                <button
                                    class="text-indigo-600 p-1 rounded transition-all duration-300 hover:text-white hover:bg-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                        fill="none">
                                        <path d="M6.00236 3.99707L10.0025 7.99723L6 11.9998" stroke="currentcolor"
                                            stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="border border-indigo-200 rounded-xl">
                        <div class="grid grid-cols-7 rounded-t-3xl border-b border-indigo-200">
                            <div
                                class="py-3.5 border-r rounded-tl-xl border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                Minggu</div>
                            <div
                                class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                Senin</div>
                            <div
                                class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                Selasa</div>
                            <div
                                class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                Rabu</div>
                            <div
                                class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                Kamis</div>
                            <div
                                class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                Jumat</div>
                            <div
                                class="py-3.5 rounded-tr-xl bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                Sabtu</div>
                        </div>
                        <div class="grid grid-cols-7 rounded-b-xl">
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50">
                                <span class="text-xs font-semibold text-gray-400">27</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">28</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">29</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">30</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">31</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">1</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">2</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 relative bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">3</span>
                                <div
                                    class="absolute top-9 bottom-1 left-3.5 p-1.5 xl:px-2.5 h-max rounded bg-purple-50 ">
                                    <p class="hidden xl:block text-xs font-medium text-purple-600 mb-px">Gel. 1</p>
                                    <span
                                        class="hidden xl:block text-xs font-normal text-purple-600 whitespace-nowrap">00:00
                                        - 23:59</span>
                                    <p class="xl:hidden w-2 h-2 rounded-full bg-purple-600"></p>
                                </div>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">4</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">5</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">6</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white relative border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">7</span>
                                <div
                                    class="absolute top-9 bottom-1 left-3.5 p-1.5 xl:px-2.5 h-max rounded bg-emerald-50 ">
                                    <p
                                        class="hidden xl:block text-xs font-medium text-emerald-600 mb-px whitespace-nowrap">
                                        Gel. 2</p>
                                    <span
                                        class="hidden xl:block text-xs font-normal text-emerald-600 whitespace-nowrap">00:00
                                        - 23:59</span>
                                    <p class="xl:hidden w-2 h-2 rounded-full bg-emerald-600"></p>
                                </div>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">8</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">9</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">10</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">11</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">12</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">13</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">14</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">15</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">16</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">17</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">18</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 relative bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">19</span>
                                <div class="absolute top-9 bottom-1 left-3.5 p-1.5 xl:px-2.5 h-max rounded bg-sky-50 ">
                                    <p class="hidden xl:block text-xs font-medium text-sky-600 mb-px whitespace-nowrap">
                                        Gel. 3</p>
                                    <span
                                        class="hidden xl:block text-xs font-normal text-sky-600 whitespace-nowrap">00:00
                                        - 23:59</span>
                                    <p class="xl:hidden w-2 h-2 rounded-full bg-sky-600"></p>
                                </div>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">20</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">21</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">22</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">23</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">24</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">25</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">26</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">27</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">28</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">29</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-b border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">30</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-white border-r border-indigo-200 rounded-bl-xl transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-900">31</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">1</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">2</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">3</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 relative bg-gray-50 border-r border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">4</span>
                                <div
                                    class="absolute top-9 bottom-1 left-3.5 p-1.5 xl:px-2.5 h-max rounded bg-red-100">
                                    <p
                                        class="hidden xl:block text-xs font-medium text-red-600 mb-px whitespace-nowrap">
                                        Gel. Esktra</p>
                                    <span
                                        class="hidden xl:block text-xs font-normal text-red-600 whitespace-nowrap">00:00
                                        - 23:59</span>
                                    <p class="xl:hidden w-2 h-2 rounded-full bg-red-600"></p>
                                </div>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-r border-indigo-200 transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">5</span>
                            </div>
                            <div
                                class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 bg-gray-50 border-indigo-200 rounded-br-xl transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                <span class="text-xs font-semibold text-gray-400">6</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutup Jadwal Pendaftaran -->

    <!-- Footer -->

    <footer class="bg-[var(--bg-primary2)]">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <div class="md:flex md:justify-between">
                <div class="mb-6 md:mb-0">
                    <a href="#" class="flex items-center">
                        <img src="assets/img/all-logo/logo-brand-teks-dark.svg" class="h-12 lg:h-20"
                            alt="FlowBite Logo" />
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-8 sm:gap-18 sm:grid-cols-3">
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-[var(--txt-secondary)] uppercase">Our School</h2>
                        <ul class="text-[var(--txt-secondary)]/60 font-medium">
                            <li class="mb-4">
                                <a href="" class="hover:underline">Blog</a>
                            </li>
                            <li class="mb-4">
                                <a href="" class="hover:underline">Podcast</a>
                            </li>
                            <li>
                                <a href="" class="hover:underline">Lorem</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-[var(--txt-secondary)] uppercase">Follow us</h2>
                        <ul class="text-[var(--txt-secondary)]/60 font-medium">
                            <li class="mb-4">
                                <a href="" class="hover:underline ">Lorem Ipsum</a>
                            </li>
                            <li class="mb-4">
                                <a href="" class="hover:underline ">Dolor Sit</a>
                            </li>
                            <li class="mb-4">
                                <a href="" class="hover:underline ">Amet</a>
                            </li>
                            <li>
                                <a href="" class="hover:underline">Piye Loubb</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-[var(--txt-secondary)] uppercase">Legal</h2>
                        <ul class="text-[var(--txt-secondary)]/60 font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">When</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Lorem Ipsum</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Dolor</a>
                            </li>
                            <li class="">
                                <a href="#" class="hover:underline">Instagram</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-[var(--txt-secondary)]/80 sm:text-center">© Copyright Group 1
                    2025. All Rights Reserved.
                </span>
                <div class="flex mt-4 sm:justify-center sm:mt-0">
                    <!-- Instagram -->
                    <a href="#" class="text-gray-500 hover:text-[var(--txt-secondary)]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5Zm4.25 3.25a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm5.25-.75a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5Z" />
                        </svg>
                        <span class="sr-only">Instagram</span>
                    </a>

                    <!-- YouTube -->
                    <a href="#" class="text-gray-500 hover:text-[var(--txt-secondary)] ms-5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 576 512"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M549.7 124.1c-6.3-23.7-24.9-42.4-48.6-48.6C456.5 64 288 64 288 64s-168.5 0-213.1 11.4c-23.7 6.2-42.3 24.9-48.6 48.6C16 168.7 16 256 16 256s0 87.3 10.3 131.9c6.3 23.7 24.9 42.4 48.6 48.6C119.5 448 288 448 288 448s168.5 0 213.1-11.4c23.7-6.2 42.3-24.9 48.6-48.6C560 343.3 560 256 560 256s0-87.3-10.3-131.9zM232 334V178l142 78-142 78z" />
                        </svg>
                        <span class="sr-only">YouTube</span>
                    </a>

                    <!-- Facebook -->
                    <a href="#" class="text-gray-500 hover:text-[var(--txt-secondary)] ms-5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 320 512"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M279.14 288l14.22-92.66h-88.91V133.33c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0C141.09 0 89.09 54.42 89.09 153.33V195.3H0v92.7h89.09V512h107.78V288z" />
                        </svg>
                        <span class="sr-only">Facebook</span>
                    </a>

                    <!-- X (Twitter) -->
                    <a href="#" class="text-gray-500 hover:text-[var(--txt-secondary)] ms-5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M370.6 0H469L298.7 214.7 500 512H348.3L233.5 344.3 99.2 512H0L180.5 283.5 0 0h155.7l102.1 144.3L370.6 0zM344.3 463.5h42.9L145.3 48.6h-46z" />
                        </svg>
                        <span class="sr-only">X (Twitter)</span>
                    </a>
                </div>

            </div>
        </div>
    </footer>

    <!-- Tutup Footer -->

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>