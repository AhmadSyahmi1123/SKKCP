const navLinks = document.querySelectorAll('.links a'); 

navLinks.forEach(link => {

  let linkPath = new URL(link.href).pathname;
  
  if (linkPath === '/') {
    linkPath = '/index.php';
  }

  if (linkPath === window.location.pathname) {
    link.closest('li').classList.add('active');
  }

});