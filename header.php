<!DOCTYPE html>
<html>

<head>
    <title>SKKCP</title>
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
</head>

<body>

    <?php
    if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "ADMIN") { ?>
        <!-- Menu ADMIN : dipaparkan sekiranya admin telah log masuk -->
        <aside class="sidebar">
            <ul class='links'>
                <li class='sidebar_link active'>
                    <i class='material-symbols-outlined'>dashboard</i>
                    <a href="index.php">Dashboard</a>
                </li>
                <li class='sidebar_link'>
                    <i class='material-symbols-outlined'>person</i>
                    <a href="profil.php">Profil</a>
                </li>
                <li class='sidebar_link'>
                    <i class='material-symbols-outlined'>support_agent</i>
                    <a href="kehadiran-rekod.php">Kaunter Kehadiran</a>
                </li>
                <li class='sidebar_link'>
                    <i class='material-symbols-outlined'>group</i>
                    <a href="senarai-ahli.php">Senarai Ahli</a>
                </li>
                <li class='sidebar_link'>
                    <i class='material-symbols-outlined'>assignment</i>
                    <a href="senarai-aktiviti.php">Senarai Aktiviti</a>
                </li>
                <li class='sidebar_link'>
                    <i class='material-symbols-outlined'>analytics</i>
                    <a href="kehadiran-laporan.php">Laporan Kehadiran</a>
                </li>
                <li>
                    <i class='material-symbols-outlined'>Logout</i>
                    <a href="logout.php">Log Keluar</a>
                </li>
            </ul>
        </aside>
    <?php } else if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "BIASA") { ?>
            <!-- Menu BIASA : dipaparkan sekiranya ahli biasa telah log masuk -->
            <aside class="sidebar">
                <ul class='links'>
                    <li>
                        <i class='material-symbols-outlined'>dashboard</i>
                        <a href="index.php">Dashboard</a>
                    </li>
                    <li>
                        <i class='material-symbols-outlined'>person</i>
                        <a href="profil.php">Profil</a>
                    </li>
                    <li>
                        <i class='material-symbols-outlined'>Logout</i>
                        <a href="logout.php">Log Keluar</a>
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
                                            style="fill: #ffffffbf;transform: ;msFilter:;">
                                            <path
                                                d="M12.71 2.29a1 1 0 0 0-1.42 0l-9 9a1 1 0 0 0 0 1.42A1 1 0 0 0 3 13h1v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7h1a1 1 0 0 0 1-1 1 1 0 0 0-.29-.71zM6 20v-9.59l6-6 6 6V20z">
                                            </path>
                                        </svg></i> Laman Utama
                                </a>
                            </li>
                            <li class="nav__item">
                                <a class="nav__link" href='login-borang.php'>
                                    <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            style="fill: #ffffffbf;transform: ;msFilter:;">
                                            <path d="m13 16 5-4-5-4v3H4v2h9z"></path>
                                            <path
                                                d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                                            </path>
                                        </svg></i> Daftar Masuk Ahli</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </header>
    <?php } ?>


</body>

</html>