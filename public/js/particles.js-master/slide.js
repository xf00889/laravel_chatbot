let currentIndex = 0;

function moveSlide(direction) {
    const slides = document.querySelector('.gallery-slide');
    const totalSlides = slides.children.length;

    // Update the current index
    currentIndex = (currentIndex + direction + totalSlides) % totalSlides;

    // Slide to the correct position
    slides.style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Optional: Auto-slide every 5 seconds
setInterval(() => {
    moveSlide(1);
}, 5000);
