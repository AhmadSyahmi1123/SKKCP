<!DOCTYPE html>
<html>

<head>
    <title>SKKCP</title>
    <link rel="stylesheet" href="css\style.css">

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

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="scripts\navbar_script.js" defer></script>
</head>

<body>

    <!-- Tajuk sistem -->
    <header class="title__banner">
        <div class="title-container">
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
                            <a class="nav__link" href='index.php'>
                                <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: #ffffffbf;transform: ;msFilter:;".>
                                        <path
                                            d="M12.71 2.29a1 1 0 0 0-1.42 0l-9 9a1 1 0 0 0 0 1.42A1 1 0 0 0 3 13h1v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7h1a1 1 0 0 0 1-1 1 1 0 0 0-.29-.71zM6 20v-9.59l6-6 6 6V20z">
                                        </path>
                                    </svg></i> Laman Utama
                            </a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='profil.php'>
                                <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: #ffffffbf;transform: ;msFilter:;">
                                        <path
                                            d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z">
                                        </path>
                                    </svg></i> Profil
                            </a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='kehadiran-rekod.php'> <i>
                                    <!-- Icon kaunter kehadiran -->
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 512 512" style="fill: #ffffffbf;transform: ;msFilter:;">
                                        <path
                                            d="M399 1.6c-26.6 5.7-47 31.1-47 58.4 0 32.4 27.6 60 60 60 27.6 0 52.8-20.5 58.5-47.5 4.3-20.4-1.6-39.7-16.4-54.6C439.2 3 419.4-2.8 399 1.6zm23.6 41.6c1.9 1.3 4.7 4.1 6.2 6.2 2.3 3.3 2.7 5 2.7 10.6s-.4 7.3-2.7 10.6c-4.6 6.5-9.1 8.9-16.8 8.9-5.4 0-7.3-.5-10.3-2.5-7.7-5.2-11.1-14-8.8-22.7 1.3-4.8 7.9-11.9 12.5-13.3 4.9-1.5 13.3-.4 17.2 2.2zM128 2.6C101.4 8.3 81 33.7 81 61c0 32.4 27.6 60 60 60 27.6 0 52.8-20.5 58.5-47.5 4.3-20.4-1.6-39.7-16.4-54.6C168.2 4 148.4-1.8 128 2.6zm23.6 41.6c1.9 1.3 4.7 4.1 6.2 6.2 2.3 3.3 2.7 5 2.7 10.6s-.4 7.3-2.7 10.6c-4.6 6.5-9.1 8.9-16.8 8.9-5.4 0-7.3-.5-10.3-2.5-7.7-5.2-11.1-14-8.8-22.7 1.3-4.8 7.9-11.9 12.5-13.3 4.9-1.5 13.3-.4 17.2 2.2zM359 140.6c-22.3 4.8-40.9 23.7-45.6 46.3-1.3 6.3-1.5 16.8-1.2 70l.3 62.6 2.3 6.5c5.6 15.6 16.9 28.8 29.9 35.1l7.2 3.4.3 67 .3 67 2.4 3.8c1.3 2.1 4.2 5 6.4 6.5 3.4 2.2 5.2 2.7 10.6 2.7 7.9 0 12.8-2.5 16.9-8.8l2.7-4.1V341.5l-2.4-3.8c-3.5-5.7-8.4-8.5-17.1-9.7-8.5-1.2-13-3.8-17-9.7l-2.5-3.7V192.3l2.7-3.9c1.5-2.1 4.4-5 6.5-6.4l3.7-2.5h93.2l3.7 2.5c2.1 1.4 5 4.3 6.5 6.4l2.7 3.9V314.6l-2.5 3.7c-4 5.9-8.5 8.5-17 9.7-8.7 1.2-13.6 4-17.1 9.7l-2.4 3.8v157l2.4 3.8c1.3 2.1 4.2 5 6.4 6.5 3.4 2.3 5.2 2.7 10.7 2.7 5.5 0 7.3-.4 10.7-2.7 2.2-1.5 5.1-4.4 6.4-6.5l2.4-3.8.3-67 .3-67 7.2-3.4c13-6.3 24.3-19.5 29.9-35.1l2.3-6.5.3-62.6c.3-53.2.1-63.7-1.2-70-4.8-22.9-23.4-41.6-46.1-46.4-9.9-2.1-95.8-2-105.5.1zM83 145.6c-22.1 4.7-40.8 23.6-45.5 45.9-1.2 5.5-1.5 16.2-1.5 51.1v44.2l-11.2.3c-13 .5-16.9 2.1-21.6 9.2l-2.7 4.1-.3 105.8L0 512l149.2-.2 149.3-.3 3.8-2.4c2.1-1.3 5-4.2 6.5-6.4 2.3-3.4 2.7-5.2 2.7-10.7 0-5.5-.4-7.3-2.7-10.7-1.5-2.2-4.4-5.1-6.5-6.4l-3.8-2.4-129.2-.3L40 472V327l109.3-.2 109.3-.3 4.1-2.7c6.3-4.1 8.8-9 8.8-16.9 0-5.4-.5-7.2-2.7-10.6-1.5-2.2-4.4-5.1-6.5-6.4l-3.8-2.4-91.3-.3-91.3-.2.3-44.9.3-44.8 2.7-3.9c1.5-2.1 4.4-5 6.5-6.4l3.7-2.5h93.2l3.7 2.5c2.1 1.4 5 4.3 6.5 6.4 2.6 3.8 2.7 4.3 3.2 22.1.5 17.6.6 18.3 3.2 22.2 4.1 6.3 9 8.8 16.9 8.8 5.4 0 7.2-.5 10.6-2.7 2.2-1.5 5.1-4.4 6.4-6.5 2.2-3.5 2.4-4.9 2.7-20.8.3-12.6-.1-19-1.2-24.5-4.8-23-23.4-41.7-46.1-46.5-9.9-2.1-95.8-2-105.5.1z" />
                                    </svg>
                                </i>Kaunter Kehadiran</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='senarai-ahli.php'><i>
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 512 512" style="fill: #ffffffbf;transform: ;msFilter:;">
                                        <path
                                            d="M240.8 45c-33.8 6.1-61.8 32-70.9 65.5-3 11-3.3 31.6-.5 42.5 5.6 21.8 18.6 40.9 36 53 7 4.8 20.3 10.8 29.1 13.1 11.3 3 31.7 3 43 0 8.8-2.3 22.1-8.3 29.1-13.1 17.4-12.1 30.4-31.2 36-53 2.8-10.9 2.5-31.5-.5-42.5-8.2-30.4-30.2-53.1-61.1-63-7.1-2.3-10.7-2.8-22-3.1-7.4-.1-15.6.1-18.2.6zm29.1 30.5c10.1 2.4 19.6 7.9 27.7 16 33 33.2 16 89.4-30.1 99-13.2 2.8-24.8 1.1-38.1-5.4-29.1-14.4-40.5-49.6-25.7-79.3 7-14 22.8-26.5 37.9-30.2 7.8-1.9 20.4-1.9 28.3-.1zM84.5 128.4c-13 3.2-23.5 9.6-33.3 20.1-26.3 28.1-22.4 74 8.1 97.1C66.4 251 77 256.1 85 258.1c7 1.7 22.9 1.7 30 0 7.8-1.9 20.5-8.2 27.3-13.6 10.2-8.1 19.6-23.2 22.8-36.5 1.8-7.7 1.6-23.1-.4-31-6-23.4-25.7-43-48.8-48.5-7.7-1.8-24.4-1.8-31.4-.1zm25.9 29.8c10.1 2.7 20.8 13 24.3 23.3 2.3 7.1 2 17.6-.7 25-3.2 8.3-12.3 17.4-20.5 20.5-13.1 4.9-27.7 2.2-37.8-7-19.9-18.1-14.1-50.3 10.9-60.5 6.7-2.8 16.4-3.3 23.8-1.3zM395.6 128.5c-22.9 5.8-42.3 25.3-48.3 48.5-2 7.9-2.2 23.3-.4 31 3.2 13.3 12.6 28.4 22.8 36.5 6.8 5.4 19.5 11.7 27.3 13.6 7.1 1.7 23 1.7 30 0 8-2 18.6-7.1 25.7-12.5 24.9-18.8 32.7-53.7 18.5-82.6-2.8-5.8-5.7-9.6-12.7-16.5-9.1-9.1-14.8-12.7-27-17-6.9-2.5-27.8-3-35.9-1zm29 30.6c25.4 9.5 31.8 42.5 11.7 60.9-10.1 9.2-24.7 11.9-37.8 7-8.2-3.1-17.3-12.2-20.5-20.5-2.7-7.4-3-17.9-.7-25 3.3-9.9 14.2-20.6 23.6-23.2 6.6-1.9 17.5-1.5 23.7.8z" />
                                        <path fill="#ffffffbf"
                                            d="M194.4 231.9c-19.2 4.7-37.3 17.9-46.6 33.9-1.9 3.4-3.5 5.1-4.4 4.8-5.1-2-21.3-2.7-49.6-2.4-28.8.4-31.9.7-38.8 2.7-13 3.9-22.4 9.5-32.5 19.6-10 9.9-15.4 18.8-19.7 32.5-2.3 7.4-2.3 7.9-2.3 57.5 0 55 0 55.4 6.1 65.6 5.8 9.7 15.4 17.1 26.3 20.3 4.9 1.4 27.4 1.6 223.1 1.6s218.2-.2 223.1-1.6c10.9-3.2 20.5-10.6 26.3-20.3 6.1-10.2 6.1-10.6 6.1-65.6 0-49.6 0-50.1-2.3-57.5-4.3-13.7-9.7-22.6-19.7-32.5-10.1-10.1-19.5-15.7-32.5-19.6-6.9-2-10-2.3-38.8-2.7-28.3-.3-44.5.4-49.6 2.4-.9.3-2.5-1.4-4.4-4.8-6.9-11.9-18.7-22.4-32.5-28.8-14.9-6.9-16-7-76.4-6.9-47.7 0-54.6.2-60.9 1.8zm117.7 29.7c8.5 2.5 13.9 5.7 19.8 11.5 5.8 5.9 9 11.3 11.5 19.8 1.4 4.8 1.6 14 1.6 75.3V438H167v-69.8c0-75.6-.1-74.2 5.5-85.2 2.8-5.5 11.6-14.5 17-17.3 10.9-5.6 10.9-5.6 66.1-5.6 44.1-.1 51.8.1 56.5 1.5zm-176.3 37.7c.9.6 1.2 15.7 1.2 69.8V438H40.3l-3.4-2.3c-6.9-4.6-6.9-4.2-6.9-52.3 0-25.2.4-45.4 1-48.5 3.4-17.9 18.3-32.8 36-35.8 6.6-1.1 67-.9 68.8.2zm308.2-.2c18.5 2.9 33.5 17.4 37 35.8.6 3.1 1 23.3 1 48.5 0 48.1 0 47.7-6.9 52.3l-3.4 2.3H375l.2-69.3.3-69.2 3.5-.6c6-1.1 58.2-.9 65 .2z" />
                                    </svg>
                                </i>Senarai Ahli</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='senarai-aktiviti.php'><i>
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 512 512" style="fill: #ffffffbf;transform: ;msFilter:;">
                                        <path
                                            d="M219.1 1.6C206.6 5 194.5 14.8 189.3 26l-2.8 6h-46.3c-44.2 0-46.5.1-52.5 2.1-15.6 5.2-27 17.4-31.2 33.6-1.3 5-1.5 31.4-1.5 203.5 0 140.1.3 199.2 1.1 203 3.7 17.8 18.9 33 36.7 36.7 7.5 1.6 318.9 1.6 326.4 0 18-3.8 33-18.7 36.7-36.7.8-3.8 1.1-62.9 1.1-203 0-172.1-.2-198.5-1.5-203.5-4.2-16.2-15.6-28.4-31.2-33.6-6-2-8.3-2.1-52.5-2.1h-46.3l-2.8-6c-5.3-11.4-17.3-21.1-30.2-24.5-8.3-2.1-65.3-2.1-73.4.1zm67.6 29.5c4.3 1.6 9.2 6.9 10.4 11.2 1.9 7.2-1.3 14.8-7.9 18.5-3.8 2.1-4.9 2.2-33.1 2.2-27.1 0-29.5-.1-33-2-6.6-3.3-10.1-11.4-8.2-18.7 1.1-4.1 6-9.6 10.1-11.2 3.5-1.4 58.1-1.4 61.7 0zm-97.1 36.6c3.5 7.2 12.3 16.2 19.5 19.8 10 5.1 12.9 5.5 46.9 5.5 33.5 0 37-.4 46.7-5.1 6.6-3.3 16.3-13.2 19.8-20.2l2.8-5.8 45.6.3c45.5.3 45.6.3 48.8 2.6 1.7 1.2 4.1 4.2 5.2 6.5l2.1 4.3v196.2c0 136.1-.3 196.9-1.1 198.9-1.4 3.8-5.7 8.3-9.6 9.9-4.8 2.1-315.7 2.1-320.6 0-4.3-1.7-9.5-7.8-10.2-11.8-.3-1.8-.4-91.5-.3-199.4l.3-196 2.6-4c5-7.5 3.9-7.4 54-7.4h44.7l2.8 5.7z" />
                                        <path fill="#ffffffbf"
                                            d="M179 152.5c-1.9.9-10.3 8.3-18.5 16.6l-15 14.9-5-5.1c-6-6.1-9.2-7.9-14-7.9-7.3 0-12.5 3.9-14.5 11.1-2 6.9-.6 9.5 11.9 22 10.1 10.1 12.2 11.8 16.4 12.8 5.2 1.3 10.5.7 15.2-1.7 3.6-1.7 38.8-36.4 41.6-41 2.5-4 2.8-10.6.6-14.9-3.5-6.6-12-9.7-18.7-6.8zM232.3 173c-4.7 1.1-8 3.5-9.9 7.3-3.6 6.8-1.3 16 4.9 19.7 3.1 1.9 5.6 2 80.8 2h77.6l3.3-2.3c9.5-6.4 9-19.3-1.1-25.2-3.3-1.9-5.3-2-77.9-2.2-41 0-76 .2-77.7.7zM179 258.1c-1.4.5-9.3 7.8-17.7 16.1l-15.2 15.1-6-5.6c-7-6.4-11.6-8.2-17.2-6.7-5.3 1.4-8.5 4.4-10.5 9.5-2.8 7.4-1.1 11.1 10.4 22.8 5.3 5.3 11.4 10.6 13.7 11.7 5.4 2.6 13.4 2.6 18.3.1 2-1.1 12.8-11.1 23.8-22.3 21.5-21.7 22.1-22.6 20.3-30.6-1.8-8.2-11.8-13.3-19.9-10.1zM229.4 279.4c-3.7 1.6-6.9 5.5-8.4 10.1-2.1 6.3 1.7 13.8 8.7 17.4 1.5.8 24 1.1 78.5 1.1 86.5 0 81 .5 85.6-8.1 3.8-7.1 2-14-5.2-19.3-2.7-2.1-3.7-2.1-79.4-2.3-62.7-.2-77.3 0-79.8 1.1zM179 358.5c-1.9.9-10.3 8.3-18.5 16.6l-15 14.9-5-5.1c-6-6.1-9.2-7.9-14-7.9-7.3 0-12.5 3.9-14.5 11.1-1.9 6.6-.4 9.6 10.4 20.7 5.6 5.7 11.9 11.3 14.1 12.5 5.1 2.6 13.6 2.7 18.5.2 4.1-2.1 39.2-36.4 42.2-41.3 2.4-4 2.7-10.6.5-14.9-3.5-6.6-12-9.7-18.7-6.8zM230.5 379.5c-11.7 4.2-13.6 20-3.1 26.4 3.3 2.1 4 2.1 80.8 2.1h77.5l3.3-2.3c9.5-6.4 9-19.3-1.1-25.2-3.3-1.9-5.4-2-78.4-2.2-62.9-.2-75.6 0-79 1.2z" />
                                    </svg>
                                </i>Senarai Aktiviti</a>
                        </li>
                        <li class="nav__item">
                            <a class="nav__link" href='kehadiran-laporan.php'><i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        id="activity" style="fill: #ffffffbf;transform: ;msFilter:;">
                                        <path
                                            d="M18.5593769,6.79017287 C18.9610428,6.79500189 19.2840764,7.12128333 19.2840764,7.52209253 L19.2840764,7.52209253 L19.2840764,13.9947315 C19.2840764,17.6984213 16.9685732,20 13.2566978,20 L13.2566978,20 L10.3048731,20 C9.89829739,20 9.56733821,19.6737307 9.56249802,19.2680803 C9.56727055,18.8609709 9.89686386,18.5321044 10.3048731,18.5273424 L10.3048731,18.5273424 L13.2566978,18.5273424 C16.1820091,18.5273424 17.7993263,16.9224101 17.8258397,13.9947315 L17.8258397,13.9947315 L17.8258397,7.52209253 C17.8258397,7.11786446 18.1542555,6.79017287 18.5593769,6.79017287 Z M12.5231605,0.776086015 C12.9297074,0.780915527 13.2566978,1.11114487 13.2566978,1.51682398 C13.2566978,1.71247872 13.1782169,1.89999431 13.0387346,2.0375122 C12.8992522,2.1750301 12.7103957,2.25110093 12.5143227,2.24874365 L12.5143227,2.24874365 L6.01854081,2.24874365 C3.09322949,2.24874365 1.47591236,3.86249422 1.47591236,6.79017287 L1.47591236,6.79017287 L1.47591236,13.9947315 C1.47591236,16.9224101 3.09322949,18.5273424 6.01854081,18.5273424 C6.42655005,18.5321044 6.75614336,18.8609709 6.76091588,19.2680803 C6.7560757,19.6737307 6.42511652,20 6.01854081,20 C2.30666542,20 3.55271368e-15,17.6984213 3.55271368e-15,13.9947315 L3.55271368e-15,13.9947315 L3.55271368e-15,6.79017287 C3.55271368e-15,3.07766471 2.30666542,0.776086015 6.01854081,0.776086015 L6.01854081,0.776086015 Z M13.6405699,7.47415709 C13.8986602,7.29834112 14.2463981,7.30338911 14.5010412,7.49883643 C14.7875146,7.71871466 14.8707838,8.11403406 14.697259,8.43037837 L14.697259,8.43037837 L11.8691634,12.0723401 C11.745354,12.2248371 11.5687763,12.3255161 11.3742467,12.354526 C11.1806403,12.3741653 10.9870465,12.3171652 10.835141,12.1957964 L10.835141,12.1957964 L8.12193686,10.0705839 L5.68270446,13.2363569 C5.56639108,13.3942512 5.39148033,13.4990132 5.19712938,13.52719 C5.00277843,13.5553667 4.80522024,13.5046048 4.64868203,13.3862681 C4.32921663,13.1363618 4.27016334,12.6767618 4.51611505,12.354526 L4.51611505,12.354526 L7.40607518,8.59792625 C7.52663161,8.44217824 7.70434594,8.34069843 7.89999886,8.31588215 C8.09565177,8.29106586 8.2931598,8.34495309 8.4489354,8.46565161 L8.4489354,8.46565161 L11.1621396,10.5908641 L13.5483452,7.54854746 Z M16.401155,0.199963635 C17.3717893,-0.204098898 18.4908164,0.015529541 19.2357623,0.756304368 C19.9807081,1.49707919 20.2046334,2.61288381 19.8029872,3.5827487 C19.4013411,4.55261359 18.4533477,5.1852406 17.4016253,5.1852406 C15.9700611,5.1852406 14.8081818,4.02987504 14.8032974,2.60147601 L14.8032974,2.60147601 L14.8091938,2.41743042 C14.8751213,1.44242571 15.4876169,0.580257785 16.401155,0.199963635 Z M17.4016253,1.48155075 C16.7817407,1.48155075 16.2792249,1.98295837 16.2792249,2.60147601 C16.2792249,3.21999366 16.7817407,3.72140128 17.4016253,3.72140128 C18.02151,3.72140128 18.5240257,3.21999366 18.5240257,2.60147601 C18.5240257,1.98295837 18.02151,1.48155075 17.4016253,1.48155075 Z"
                                            transform="translate(2 2)"></path>
                                    </svg>
                                </i>Laporan Kehadiran</a>
                        </li>
                        <li class="logout">
                            <a href="logout.php">
                                <i class='bx bx-log-out' data-tooltip="Log Keluar"></i>
                            </a>
                        </li>
                    <?php } else if (!empty($_SESSION['tahap']) and $_SESSION['tahap'] == "BIASA") { ?>
                            <!-- Menu BIASA : dipaparkan sekiranya ahli biasa telah log masuk -->
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
                                <a class="nav__link" href='profil.php'>
                                    <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            style="fill: #ffffffbf;transform: ;msFilter:;">
                                            <path
                                                d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z">
                                            </path>
                                        </svg></i> Profil
                                </a>
                            </li>
                            <li class="logout">
                                <a href="logout.php">
                                    <i class='bx bx-log-out' data-tooltip="Log Keluar"></i>
                                </a>
                            </li>
                    <?php } else { ?>
                            <!-- Menu Laman Utama : dipaparkan sekiranya admin/ahli biasa tidak log masuk -->
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
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>