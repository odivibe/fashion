document.addEventListener('DOMContentLoaded', function() {
    const menuIcon = document.querySelector('.menu-icon');
    const mobileNav = document.querySelector('.mobile-navigation');
    const closeMenu = document.querySelector('.close-menu');

    menuIcon.addEventListener('click', function(event) {
        event.preventDefault();
        mobileNav.classList.add('active');
    });

    closeMenu.addEventListener('click', function(event) {
        event.preventDefault();
        mobileNav.classList.remove('active');
    });

    const searchIcon = document.querySelector('.action.search');
    const searchFormMobile = document.querySelector('.search-form-mobile');
    const closeSearch = document.querySelector('.close-search');

    searchIcon.addEventListener('click', function(event) {
        event.preventDefault();
        searchFormMobile.classList.add('active');
    });

    closeSearch.addEventListener('click', function(event) {
        event.preventDefault();
        searchFormMobile.classList.remove('active');
    });
});
