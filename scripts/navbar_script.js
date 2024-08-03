// Dapatkan semua pautan navigasi
const navLinks = document.querySelectorAll('.links a');

// Iterasi melalui setiap pautan navigasi
navLinks.forEach(link => {
  // Dapatkan laluan dari atribut href pautan
  let linkPath = new URL(link.href).pathname;

  // Semak jika halaman semasa adalah halaman utama (index)
  if (window.location.pathname === '/' || window.location.pathname === '/index.php') {
    // Tandakan item menu aktif jika pautan adalah halaman utama
    if (linkPath === '/' || linkPath === '/index.php') {
      link.closest('li').classList.add('active');
    } else {
      link.closest('li').classList.remove('active');
    }
  } else {
    // Tandakan item menu aktif jika pautan sepadan dengan laluan semasa
    if (linkPath === window.location.pathname) {
      link.closest('li').classList.add('active');
    } else {
      link.closest('li').classList.remove('active');
    }
  }
});
