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