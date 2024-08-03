// Inisialisasi Notyf untuk notifikasi
let notyf = new Notyf();

document.addEventListener('DOMContentLoaded', function () {
    // Ambil parameter URL dari query string
    const urlParams = new URLSearchParams(window.location.search);
    const notificationType = urlParams.get('notificationType');
    const notificationMessage = urlParams.get('notificationMessage');

    // Paparkan notifikasi menggunakan JavaScript jika ada parameter
    if (notificationType && notificationMessage) {
        if (notificationType === 'success') {
            // Paparkan notifikasi kejayaan
            notyf.success({
                message: notificationMessage, // Mesej notifikasi
                duration: 3000, // Tempoh paparan notifikasi dalam milisaat
                dismissible: true, // Benarkan notifikasi ditutup oleh pengguna
                position: {
                    x: 'right', // Kedudukan mendatar notifikasi
                    y: 'top' // Kedudukan menegak notifikasi
                }
            });
        } else if (notificationType === 'error') {
            // Paparkan notifikasi ralat
            notyf.error({
                message: notificationMessage, // Mesej notifikasi
                duration: 3000, // Tempoh paparan notifikasi dalam milisaat
                dismissible: true, // Benarkan notifikasi ditutup oleh pengguna
                position: {
                    x: 'right', // Kedudukan mendatar notifikasi
                    y: 'top' // Kedudukan menegak notifikasi
                }
            });
        }

        // Alihkan URL untuk menghapuskan parameter notifikasi dari URL
        history.replaceState(null, null, window.location.pathname);
    }
});
