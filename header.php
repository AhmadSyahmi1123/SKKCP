<!DOCTYPE html>
<html>

<head>
    <title>SKKCP</title>
    <link rel="stylesheet" href="css\style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <script src="scripts\carousel_script.js" defer></script>
    <script src="scripts\navbar_script.js" defer></script>
</head>

<body>

    <!-- Tajuk sistem -->
    <header class="title__banner">
        <div class="container">
            <p class="text">KELAB COMPETITIVE PROGRAMMING SMK BANDAR TASIK PUTERI</p>
        </div>
    </header>

    <header class="header">
        <div class="header__content">
            <nav class="nav">
                <ul class="nav__list">
                    <?php
                    if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "ADMIN") { ?>
                        <!-- Menu ADMIN : dipaparkan sekiranya admin telah log masuk -->
                        <li class="nav__item">
                            <a class="nav__link" href='index.php'>Laman Utama</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='profil.php'>Profil</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='kehadiran-rekod.php'>Kaunter Kehadiran</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='senarai-ahli.php'>Senarai Ahli</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='senarai-aktiviti.php'>Senarai Aktiviti</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='kehadiran-laporan.php'>Laporan Kehadiran</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='logout.php'>Log Keluar</a>
                        </li>
                    <?php } else if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "BIASA") { ?>
                            <!-- Menu BIASA : dipaparkan sekiranya ahli biasa telah log masuk -->
                            <li class="nav__item">
                                <a class="nav__link" href='index.php'>Laman Utama</a>
                            </li>
                            <li class="nav__item">
                                <a class="nav__link" href='profil.php'>Profil</a>
                            </li>
                            <li class="nav__item">
                                <a class="nav__link" href='logout.php'>Log Keluar</a>
                            </li>
                    <?php } else { ?>
                            <!-- Menu Laman Utama : dipaparkan sekiranya admin/ahli biasa tidak log masuk -->
                            <li class="nav__item">
                                <a class="nav__link" href='index.php'>Laman Utama</a>
                            </li>
                            <li class="nav__item">
                                <a class="nav__link" href='login-borang.php'>Daftar Masuk Ahli</a>
                            </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>