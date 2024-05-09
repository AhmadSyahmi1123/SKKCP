<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");

?>

<div class="page-header">Senarai Aktiviti</div>
<main>

    <div class="upload-aktiviti-container">
        <div class="upload-container">
            <button id="open-aktiviti" class="uploadBtn" data-tooltip="Tambah Aktiviti/Perjumpaan">
                <i class='material-symbols-outlined'>playlist_add</i>
            </button>
        </div>
    </div>

    <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
    <div class="table-container">
        <div class="scrollable-table">
            <table class="table">

                <thead>
                    <tr>
                        <th>Nama Aktiviti</th>
                        <th>Tarikh</th>
                        <th>Masa Mula</th>
                        <th>Masa Tamat</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dapatkan data aktiviti realtime -->
                    <script>
                        function loadAktivitiData() {

                            // Create the AJAX request
                            const xhr = new XMLHttpRequest();

                            // Specify the request method, URL, and set it to asynchronous
                            xhr.open('POST', 'get-aktiviti-data.php', true);

                            // Set the request header to indicate form data will be sent
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                            // Define the function to execute when the response is received
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    // Parse the JSON response into JavaScript object
                                    const aktivitiData = JSON.parse(xhr.responseText);
                                    console.log(aktivitiData);

                                    // Display the retrieved data
                                    displayAktivitiData(aktivitiData);
                                }
                            };

                            // Send the AJAX request with the form data
                            xhr.send();
                        }

                        // Function to display the activity data in the HTML table
                        function displayAktivitiData(data) {
                            const tableBody = document.querySelector('.table tbody');
                            tableBody.innerHTML = '';

                            // Iterate through the activity data and create table rows
                            data.forEach(function (aktiviti) {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                <td>${aktiviti.nama_aktiviti}</td>
                                <td>${aktiviti.tarikh_aktiviti}</td>
                                <td>${aktiviti.masa_mula}</td>
                                <td>${aktiviti.masa_tamat}</td>
                                <td>
                                    <div class='action-container'>
                                        <div class='edit-container'>
                                            <button class='editBtn' data-tooltip='Kemaskini'>
                                                <a href='aktiviti-kemaskini-borang.php?IDaktiviti=${aktiviti.IDaktiviti}'><i class='bx bx-edit'></i></a>
                                            </button>
                                        </div>

                                        <div class='delete-container'>
                                            <button class='deleteBtn' data-tooltip='Hapus'>
                                                <a href='aktiviti-padam-proses.php?IDaktiviti=${aktiviti.IDaktiviti}' onClick="return confirm('Anda pasti anda ingin memadam data ini?')"><i class='bx bx-trash'></i></a>
                                            </button>
                                        </div>

                                        <div class='hadir-container'>
                                            <button class='hadirBtn' data-tooltip='Pengesahan Kehadiran'>
                                                <a href='kehadiran-borang.php?IDaktiviti=${aktiviti.IDaktiviti}'><i class='bx bx-list-check'></i></a>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            `;
                                tableBody.appendChild(row);
                            });
                        }

                        // Call the loadAktivitiData function on page load
                        loadAktivitiData();

                    </script>
                </tbody>
            </table>
        </div>
    </div>
    <script src="scripts\dialog-script-aktiviti.js" defer></script>
</main>

<div class="modal-container" id="modal_aktiviti_container">
    <div class="card modal_aktiviti modal">

        <button id="closeAddAktivitiBtn" class="closeBtn"><i class='bx bx-x'></i></button>
        <!-- Borang Daftar Masuk -->
        <form class="daftar_aktiviti_borang" method="POST">

            <!-- Tajuk Antaramuka Log Masuk -->
            <h1>Daftar Aktiviti Baru</h1>

            <label for="input-aktiviti">Nama Aktiviti*</label>
            <div class="input-box">
                <input id="input-aktiviti" type='text' name='nama_aktiviti' placeholder="Nama Aktiviti" required>
            </div>

            <label for="input-tarikh">Tarikh Aktiviti*</label>
            <div class="input-box">
                <input id="input-tarikh" type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' required>
            </div>

            <label for="input-masa">Masa Mula*</label>
            <div class="input-box">
                <input id="input-masa" type='time' name='masa_mula' placeholder="Masa Mula" required>
            </div>`

            <label for="input-masa">Masa Tamat*</label>
            <div class="input-box">
                <input id="input-masa" type='time' name='masa_tamat' placeholder="Masa Tamat" required>
            </div>

            <button onclick="daftarAktiviti()" class="addBtn" type='submit'>Tambah</button>

        </form>
    </div>
</div>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script defer>
    let notyf = new Notyf();

    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const notificationType = urlParams.get('notificationType');
        const notificationMessage = urlParams.get('notificationMessage');

        // Display the notification using JavaScript
        if (notificationType && notificationMessage) {
            if (notificationType === 'success') {
                notyf.success({
                    message: notificationMessage,
                    duration: 3000,
                    dismissible: true,
                    position: {
                        x: 'right',
                        y: 'top'
                    }
                });
            } else if (notificationType === 'error') {
                notyf.error({
                    message: notificationMessage,
                    duration: 3000,
                    dismissible: true,
                    position: {
                        x: 'right',
                        y: 'top'
                    }
                });
            }

            // Remove notification parameters from the URL
            history.replaceState(null, null, window.location.pathname);
        }
    });
</script>

<!-- Proses daftar aktiviti -->
<script>
    // Fungsi hantar data ke aktiviti-daftar-proses.php
    function daftarAktiviti() {
        var form = document.querySelector('.daftar_aktiviti_borang'); // Get the form element
        var formData = new FormData(form); // Create FormData object with form data
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "aktiviti-daftar-proses.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'success');
                urlParams.set('notificationMessage', 'Aktiviti berjaya ditambah.');
                window.location.href = "senarai-aktiviti.php?" + urlParams.toString();
            } else {
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'error');
                urlParams.set('notificationMessage', 'Ralat! Aktiviti gagal ditambah.');
                window.location.href = "senarai-aktiviti.php?" + urlParams.toString();
            }
        };
        xhr.onerror = function () {
            alert("An error occurred. Please try again."); // Show error message
        };
        xhr.send(formData); // Send the FormData object
    }
</script>

<!-- Elak daripada resubmission borang apabila refresh -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>