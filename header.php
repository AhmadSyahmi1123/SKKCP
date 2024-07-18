<!DOCTYPE html>
<html>

<head>
    <title>SISTEM KEHADIRAN KELAB PENGATURCARAAN KOMPETITIF SMKBTP</title>
    <link rel="stylesheet" href="css\style.css">

    <!-- Import Google Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined">

    <!-- Import Primary Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <!-- Import Secondary Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <!-- Library Icon -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Library Carousel -->
    <link rel="stylesheet" href="css\glide.core.min.css">
    <link rel="stylesheet" href="css\glide.theme.min.css">

    <!-- Library Select Box -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="scripts\navbar_script.js" defer></script>

    <!-- Library Toast Notification -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <svg version="1.1" style="display: none;">
        <defs>
            <!-- Protanopia Filter -->
            <filter id="protanopia">
                <feColorMatrix type="matrix"
                    values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0" />
            </filter>

            <!-- Deuteranopia Filter -->
            <filter id="deuteranopia">
                <feColorMatrix type="matrix"
                    values="0.625, 0.375, 0, 0, 0, 0.7, 0.3, 0, 0, 0, 0, 0.3, 0.7, 0, 0, 0, 0, 0, 1, 0" />
            </filter>

            <!-- Tritanopia Filter -->
            <filter id="tritanopia">
                <feColorMatrix type="matrix"
                    values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 0, 1, 0" />
            </filter>

            <!-- Achromatopsia Filter -->
            <filter id="achromatopsia">
                <feColorMatrix type="matrix"
                    values="0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
        </defs>
    </svg>

</head>

<div id="filter-overlay"></div>
<?php
// Determine the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Check if the current page is index-admin.php or index-biasa.php
$hide_title_container = ($current_page != 'index.php');
?>

<div class="title-container <?php if ($hide_title_container)
    echo 'hidden-title-container'; ?>">
    <div class="text">KELAB PENGATURCARAAN KOMPETITIF SMK BANDAR TASIK PUTERI </div>
</div>

<body>
    <?php
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
                                        </svg></i> Log Masuk Ahli</a>
                            </li>
                        </ul>
                    </nav>
                    <button class="colorblind-btn" onclick="toggleFilter()" data-tooltip="Buta Warna"><span
                            class="material-symbols-outlined">symptoms</span></button>
                </div>
            </header>
    <?php } ?>
</body>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<!-- fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai icon) -->
<script src="scripts\datatooltip.js" defer></script>

</html>