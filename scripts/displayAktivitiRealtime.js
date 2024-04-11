function loadAktivitiData() {
    // Get the search input value
    const searchInput = document.querySelector('input[name="nama_aktiviti"]');
    const searchValue = searchInput ? searchInput.value : '';

    // Create the AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-aktiviti-data.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            const aktivitiData = JSON.parse(xhr.responseText);
            const tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = '';

            aktivitiData.forEach(function (aktiviti) {
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
    };

    const formData = new FormData();
    formData.append('nama_aktiviti', searchValue);
    xhr.send(formData);
}

// Call the loadAktivitiData function on page load
loadAktivitiData();

// Call the loadAktivitiData function when the search input value changes
const searchInput = document.querySelector('input[name="nama_aktiviti"]');
searchInput.addEventListener('input', loadAktivitiData);