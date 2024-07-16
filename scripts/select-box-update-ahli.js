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

$('.select2-selection').css({
    'font-size': '16px',
    'height': '40px',
    'padding-top': '5px',
    'background-color': '#26272b',
    'border': '2px solid var(--accent-color)',
    'border-radius': '6px',
    'transition': 'border .2s ease-in-out'
});

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

// Change border color on focus and blur for each select box
$('#select-box-tahap').on('select2:open', function (e) {
    $('#select-box-tahap').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent3-color)'); // Change to your desired focus border color
});

$('#select-box-tahap').on('select2:close', function (e) {
    $('#select-box-tahap').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent-color)'); // Change back to the original border color
});

$('#select-box-kelas').on('select2:open', function (e) {
    $('#select-box-kelas').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent3-color)'); // Change to your desired focus border color
});

$('#select-box-kelas').on('select2:close', function (e) {
    $('#select-box-kelas').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent-color)'); // Change back to the original border color
});
