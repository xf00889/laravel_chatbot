const slides = document.querySelectorAll('.slide');
let currentSlide = 0;

function showSlide(index) {
    slides[currentSlide].classList.remove('opacity-100');
    slides[currentSlide].classList.add('opacity-0');

    currentSlide = (index + slides.length) % slides.length;

    slides[currentSlide].classList.remove('opacity-0');
    slides[currentSlide].classList.add('opacity-100');
}

document.getElementById('next').addEventListener('click', () => {
    showSlide(currentSlide + 1);
});

document.getElementById('prev').addEventListener('click', () => {
    showSlide(currentSlide - 1);
});

// Auto-slide every 5 seconds
setInterval(() => {
    showSlide(currentSlide + 1);
}, 5000);
