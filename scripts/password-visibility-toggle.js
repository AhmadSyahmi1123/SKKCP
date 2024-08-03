// Elemen
const icon = document.querySelector('.password-toggle');
const input = document.querySelector('input[type="password"]');

// Pembolehubah keadaan
let showPassword = false;

icon.addEventListener('click', function () {

  // Tukar paparan kata laluan
  // Berdasarkan keadaan semasa
  if (showPassword) {
    input.type = 'password'; // Tukar input kepada jenis kata laluan
    showPassword = false;    // Kemas kini keadaan kepada tidak menunjukkan kata laluan
  } else {
    input.type = 'text';     // Tukar input kepada jenis teks
    showPassword = true;     // Kemas kini keadaan kepada menunjukkan kata laluan
  }

  // Tukar ikon
  if (icon.classList.contains('fa-eye')) {
    icon.classList.replace('fa-eye', 'fa-eye-slash'); // Tukar ikon kepada 'fa-eye-slash'
  } else {
    icon.classList.replace('fa-eye-slash', 'fa-eye'); // Tukar ikon kepada 'fa-eye'
  }

});
