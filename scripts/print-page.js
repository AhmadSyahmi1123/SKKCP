function printPage() {
    // Get the content of the print-area
    var printArea = document.getElementById("print-area");

    // Save the original body content
    var originalBody = document.body.innerHTML;

    // Save the original styles of the print area
    var originalStyles = printArea.style.cssText;

    // Remove the scrollable properties to display the entire table
    printArea.style.height = 'auto';
    printArea.style.overflow = 'visible';

    // Replace the body content with the print-area content
    document.body.innerHTML = printArea.innerHTML;

    // Print the page
    window.print();

    // Restore the original body content and styles
    document.body.innerHTML = originalBody;
    document.getElementById("print-area").style.cssText = originalStyles;

    // Reattach the event listeners and reinitialize necessary scripts
    reinitializeSearchFeature();
}

function reinitializeSearchFeature() {
    document.getElementById('searchNama').addEventListener('input', function () {
        const searchValue = this.value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search-leaderboard.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status === 200) {
                document.getElementById('leaderboardBody').innerHTML = this.responseText;
            }
        }

        xhr.send('nama=' + encodeURIComponent(searchValue));
    });
}

// Call the reinitialize function on page load to ensure the search feature is initialized
document.addEventListener('DOMContentLoaded', reinitializeSearchFeature);
