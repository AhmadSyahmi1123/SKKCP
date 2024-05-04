function loadAktivitiData() {
    // Get the search input value
    const searchInput = document.querySelector('.search_space input[name="nama_aktiviti"]');
    const searchValue = searchInput ? searchInput.value : '';

    // Create the AJAX request
    const xhr = new XMLHttpRequest();

    // Specify the request method, URL, and set it to asynchronous
    xhr.open('POST', 'senarai-aktiviti.php', true);

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

    // Create a FormData object to send the search value
    const formData = new FormData();
    formData.append('nama_aktiviti', searchValue);

    // Send the AJAX request with the form data
    xhr.send(formData);
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

// Call the loadAktivitiData function when the search input value changes
const searchInput = document.querySelector('input[name="nama_aktiviti"]');
searchInput.addEventListener('input', loadAktivitiData);
