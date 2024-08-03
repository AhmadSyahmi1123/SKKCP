<!DOCTYPE html>
<html>

<head>
    <title>SISTEM KEHADIRAN KELAB PENGATURCARAAN KOMPETITIF SMKBTP</title>
    <!-- Memanggil fail CSS untuk gaya umum -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Import Google Icon untuk ikon material -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined">

    <!-- Import Font Utama (Roboto Mono) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <!-- Import Font Sekunder (Montserrat dan Roboto Mono) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <!-- Import Library Ikon (Boxicons dan Font Awesome) -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Import Library Carousel untuk slaid gambar -->
    <link rel="stylesheet" href="css/glide.core.min.css">
    <link rel="stylesheet" href="css/glide.theme.min.css">

    <!-- Import Library Select Box untuk dropdown dengan fungsi tambahan -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Memanggil skrip JavaScript untuk fungsi navbar -->
    <script src="scripts/navbar_script.js" defer></script>

    <!-- Import Library Toast Notification untuk pemberitahuan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- SVG untuk penapis warna mesra buta warna -->
    <svg version="1.1" style="display: none;">
        <defs>
            <!-- Penapis untuk Protanopia (buta warna merah-hijau) -->
            <filter id="protanopia">
                <feColorMatrix type="matrix"
                    values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0" />
            </filter>

            <!-- Penapis untuk Deuteranopia (buta warna hijau-merah) -->
            <filter id="deuteranopia">
                <feColorMatrix type="matrix"
                    values="0.625, 0.375, 0, 0, 0, 0.7, 0.3, 0, 0, 0, 0, 0.3, 0.7, 0, 0, 0, 0, 0, 1, 0" />
            </filter>

            <!-- Penapis untuk Tritanopia (buta warna biru-kuning) -->
            <filter id="tritanopia">
                <feColorMatrix type="matrix"
                    values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 0, 1, 0" />
            </filter>

            <!-- Penapis untuk Achromatopsia (buta warna total) -->
            <filter id="achromatopsia">
                <feColorMatrix type="matrix"
                    values="0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
        </defs>
    </svg>

    <!-- Fungsi JavaScript untuk menyokong pengguna buta warna -->
    <link rel="preload" href="scripts/colorblind.js" as="script">

</head>

<body>
    <div id="filter-overlay"></div>

    <?php
    // Menentukan nama halaman semasa
    $current_page = basename($_SERVER['PHP_SELF']);

    // Menyembunyikan kontainer tajuk jika halaman bukan index.php
    $hide_title_container = ($current_page != 'index.php');
    ?>

    <div class="title-container <?php if ($hide_title_container)
        echo 'hidden-title-container'; ?>">
        <div class="logo">
            <!-- Logo Sekolah -->
            <img src="img/logosekolah.png" alt="">
        </div>
        <div class="text-container">
            <div class="text">KELAB PENGATURCARAAN KOMPETITIF SMK BANDAR TASIK PUTERI</div>
        </div>
        <div class="logo">
            <!-- Logo Kelab -->
            <img src="img/logokelab.png" alt="">
        </div>
    </div>

    <?php
    // Menentukan menu berdasarkan tahap pengguna
    if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "ADMIN") { ?>
        <!-- Menu ADMIN : dipaparkan sekiranya admin telah log masuk -->
        <aside class="sidebar">
            <ul class='links'>
                <li class="active">
                    <a href="index-admin.php" data-text="Dashboard">
                        <i class='material-symbols-outlined'>dashboard</i>
                    </a>
                </li>
                <li>
                    <a href="profil.php" data-text="Profil">
                        <i class='material-symbols-outlined'>person</i>
                    </a>
                </li>
                <li>
                    <a href="kehadiran-rekod.php" data-text="Kaunter Kehadiran">
                        <i class='material-symbols-outlined'>support_agent</i>
                    </a>
                </li>
                <li>
                    <a href="senarai-ahli.php" data-text="Senarai Ahli">
                        <i class='material-symbols-outlined'>group</i>
                    </a>
                </li>
                <li>
                    <a href="senarai-aktiviti.php" data-text="Senarai Aktiviti">
                        <i class='material-symbols-outlined'>assignment</i>
                    </a>
                </li>
                <li>
                    <a href="kehadiran-laporan.php" data-text="Laporan Kehadiran">
                        <i class='material-symbols-outlined'>analytics</i>
                    </a>
                </li>
                <li>
                    <a href="logout.php" data-text="Log Keluar">
                        <i class='material-symbols-outlined'>Logout</i>
                    </a>
                </li>
            </ul>
        </aside>

    <?php } else if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "BIASA") { ?>
            <!-- Menu BIASA : dipaparkan sekiranya ahli biasa telah log masuk -->
            <aside class="sidebar">
                <ul class='links'>
                    <li>
                        <a href="index-biasa.php" data-text="Dashboard">
                            <i class='material-symbols-outlined'>dashboard</i>
                        </a>
                    </li>
                    <li>
                        <a href="profil.php" data-text="Profil">
                            <i class='material-symbols-outlined'>person</i>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" data-text="Log Keluar">
                            <i class='material-symbols-outlined'>Logout</i>
                        </a>
                    </li>
                </ul>
            </aside>

    <?php } else { ?>
            <!-- Menu Laman Utama : dipaparkan sekiranya admin/ahli biasa tidak log masuk -->
            <header class="header">
                <div class="header__content">
                    <nav class="nav">
                        <ul class="nav__list">
                            <li class="nav__item">
                                <a class="nav__link" href='index.php'>
                                    <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            style="fill: #ffffffbf;">
                                            <path
                                                d="M12.71 2.29a1 1 0 0 0-1.42 0l-9 9a1 1 0 0 0 0 1.42A1 1 0 0 0 3 13h1v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7h1a1 1 0 0 0 1-1 1 1 0 0 0-.29-.71zM6 20v-9.59l6-6 6 6V20z">
                                            </path>
                                        </svg></i> Laman Utama
                                </a>
                            </li>
                            <li class="nav__item">
                                <a class="nav__link" href='login-borang.php'>
                                    <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            style="fill: #ffffffbf;">
                                            <path d="m13 16 5-4-5-4v3H4v2h9z"></path>
                                            <path
                                                d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                                            </path>
                                        </svg></i> Log Masuk Ahli
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="colorblind-container">
                        <button class="reset-colorblind-btn" onclick="resetFilter()" data-tooltip="Reset Warna"><i
                                class='bx bx-reset'></i></button>
                        <button class="colorblind-btn" onclick="toggleFilter()" data-tooltip="Buta Warna"><span
                                class="material-symbols-outlined">symptoms</span></button>
                    </div>
                </div>
            </header>
    <?php } ?>
</body>

<!-- Memanggil skrip JavaScript untuk data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai ikon) -->
<script src="scripts/datatooltip.js" defer></script>

</html>