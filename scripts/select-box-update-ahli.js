$("#select-box-tahap").select2({
    width: 100,
    containerCssClass: "select2-dark-container",
    dropdownCssClass: "select2-dark-dropdown"
});

$("#select-box-kelas").select2({
    width: 150,
    containerCssClass: "select2-dark-container",
    dropdownCssClass: "select2-dark-dropdown"
});

$('.select2-selection').css('font-size', '16px');
$('.select2-selection').css('height', '40px');
$('.select2-selection').css('padding-top', '5px');
$('.select2-selection').css('background-color', '#26272b');
$('.select2-selection').css('border', '2px solid #adadad');
$('.select2-selection').css('border-radius', '6px');

$('.select2-selection__rendered').css('color', '#fcfcfc');

$('.select2-selection__arrow').css('margin-top', '5px');

// Add the custom styles for the dark theme
var darkThemeStyles = `
    .select2-dark-container {
        background-color: #26272b;
    }
    .select2-dark-container .select2-selection--single {
        background-color: #26272b;
        color: #fff;
    }
    .select2-dark-container .select2-selection--single .select2-selection__placeholder {
        color: #999;
    }
    .select2-dark-dropdown .select2-results__option {
        background-color: #26272b;
        color: #fff;
    }
    .select2-dark-dropdown .select2-results__option--highlighted {
        background-color: #555;
        color: #fff;
    }
`;

// Create a new style element and append it to the head
var styleElement = document.createElement('style');
styleElement.innerHTML = darkThemeStyles;
document.head.appendChild(styleElement);