document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const closeBtn = document.getElementById('mobile-close-btn');
    const overlay = document.getElementById('mobile-overlay');
    const drawer = document.getElementById('mobile-drawer');

    function openMobileMenu() {
        drawer.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
        overlay.classList.add('block');
        menuBtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        drawer.classList.add('translate-x-full');
        overlay.classList.remove('block');
        overlay.classList.add('hidden');
        menuBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (menuBtn) menuBtn.addEventListener('click', openMobileMenu);
    if (closeBtn) closeBtn.addEventListener('click', closeMobileMenu);
    if (overlay) overlay.addEventListener('click', closeMobileMenu);

    document.querySelectorAll('#mobile-drawer a').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    window.closeMobileMenu = closeMobileMenu;
});
