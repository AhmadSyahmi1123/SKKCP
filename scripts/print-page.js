function printPage() {
    // Get the content of the scrollable table
    var tableContent = document.querySelector('.scrollable-table table').outerHTML;

    // Create a new window for printing
    var printWindow = window.open('', '_blank');

    // Write the table content to the new window
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; }');
    printWindow.document.write('table { border-collapse: collapse; width: 100%; }');
    printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.profile_img_list { display:none; }');
    printWindow.document.write('.td-name { display: inline-block; vertical-align: middle; }');
    printWindow.document.write('.action-container, .editBtn, .deleteBtn { display: none; }'); // Hide action buttons in print
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(tableContent);
    printWindow.document.write('</body></html>');

    printWindow.document.close();

    // Focus on the new window
    printWindow.focus();

    // Function to handle printing
    function handlePrint() {
        printWindow.print();

        // Close the window after a short delay
        printWindow.close();
    }

    // Call handlePrint after a short delay to ensure the content is loaded
    setTimeout(handlePrint, 100);
}