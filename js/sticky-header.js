window.addEventListener('scroll', function() {
    // Select the header
    const header = document.getElementById('header-container');
    
    // Check the scroll position
    if (window.pageYOffset > 200) 
    { 
        header.classList.add('sticky');
    } 
    else 
    {
        header.classList.remove('sticky');
    }
});