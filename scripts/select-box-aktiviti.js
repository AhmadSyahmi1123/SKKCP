$("#select-box-aktiviti").select2({
    placeholder: "Sila Pilih Aktiviti",
    containerCssClass: "select2-dark-container",
    dropdownCssClass: "select2-dark-dropdown"
});

$('.select2-selection').css({
    'font-size': '18px',
    'height': '30px',
    'background-color': '#26272b',
    'border': '2px solid var(--accent-color)',
    'border-radius': '6px',
    'transition': 'border .2s ease-in-out'
});

$('.select2-selection__rendered').css('color', '#fcfcfc');

// style tema gelap
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

// Tambah elemen style baru dan tambah ke head
var styleElement = document.createElement('style');
styleElement.innerHTML = darkThemeStyles;
document.head.appendChild(styleElement);

// Change border color on focus and blur for each select box
$('#select-box-aktiviti').on('select2:open', function (e) {
    $('#select-box-aktiviti').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent3-color)'); // Change to your desired focus border color
});

$('#select-box-aktiviti').on('select2:close', function (e) {
    $('#select-box-aktiviti').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent-color)'); // Change back to the original border color
});