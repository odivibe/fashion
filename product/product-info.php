<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Horizontal Image Scroll</title>
<style>
    /* Style for the image container */
    .image-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }
    
    /* Style for the image wrapper */
    .image-wrapper {
        display: flex;
        transition: transform 0.5s ease;
    }
    
    /* Style for each image */
    .image {
        flex: 0 0 auto;
        width: 100%;
        height: auto;
    }
    
    /* Style for the navigation circles */
    .navigation {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
    }
    
    /* Style for each navigation circle */
    .navigation-circle {
        width: 10px;
        height: 10px;
        background-color: #333;
        border-radius: 50%;
        margin: 0 5px;
        cursor: pointer;
    }
    
    /* Style for active navigation circle */
    .active {
        background-color: #fff;
    }
    
    /* Style for the button container */
    .button-container {
        margin-top: 20px;
        text-align: center;
    }
</style>
</head>
<body>

<div class="image-container">
    <div class="image-wrapper">
        <img class="image" src="image1.jpg" alt="Image 1">
        <img class="image" src="image2.jpg" alt="Image 2">
        <img class="image" src="image3.jpg" alt="Image 3">
    </div>
    <div class="navigation"></div>
</div>

<div class="button-container">
    <button id="prevBtn">Previous</button>
    <button id="nextBtn">Next</button>
</div>

<script>
    const images = document.querySelectorAll('.image');
    const nav = document.querySelector('.navigation');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;

    // Create navigation circles
    images.forEach((image, index) => {
        const circle = document.createElement('div');
        circle.classList.add('navigation-circle');
        circle.addEventListener('click', () => {
            currentIndex = index;
            updateDisplay();
        });
        nav.appendChild(circle);
    });

    // Set active class for current image
    const updateDisplay = () => {
        images.forEach((image, index) => {
            if (index === currentIndex) {
                image.style.display = 'block';
                nav.children[index].classList.add('active');
            } else {
                image.style.display = 'none';
                nav.children[index].classList.remove('active');
            }
        });
    };

    // Initial display
    updateDisplay();

    // Button functionality
    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateDisplay();
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        updateDisplay();
    });
</script>

</body>
</html>
