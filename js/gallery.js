document.addEventListener('DOMContentLoaded', function() {
    const gallery = document.querySelector('.gallery');
    const images = gallery.querySelectorAll('img');
    const totalImages = images.length;
    let index = 0;

    function showNextImage() {
        index++;
        if (index >= totalImages) {
            index = 0;
        }
        const translateXValue = -index * images[0].clientWidth;
        gallery.style.transform = `translateX(${translateXValue}px)`;
    }

    setInterval(showNextImage, 3000); // Змінюйте зображення кожні 3 секунди
});
