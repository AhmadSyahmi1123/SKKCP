const navLinks = document.querySelectorAll('.links a');

navLinks.forEach(link => {
  let linkPath = new URL(link.href).pathname;

  // Check if the current page is the index page
  if (window.location.pathname === '/' || window.location.pathname === '/index.php') {
    if (linkPath === '/' || linkPath === '/index.php') {
      link.closest('li').classList.add('active');
    } else {
      link.closest('li').classList.remove('active');
    }
  } else {
    if (linkPath === window.location.pathname) {
      link.closest('li').classList.add('active');
    } else {
      link.closest('li').classList.remove('active');
    }
  }
});