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
}
