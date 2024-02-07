const navLinkEls = document.querySelectorAll('.nav__link');
const windowPathname = window.location.pathname;

navLinkEls.forEach(navLinkEl => {
    const navLinkPathname = new URL(navLinkEl.href).pathname;

    if ((windowPathname === navLinkPathname) || (windowPathname === '/index.php' && navLinkPathname === '/')) {
        navLinkEl.classList.add('active');
    }
})