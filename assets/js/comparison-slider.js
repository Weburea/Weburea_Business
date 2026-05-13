/**
 * Weburea Comparison Slider Logic
 */
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('imageComparisonSlider');
    if (!slider) return;

    const afterLayer = slider.querySelector('.after-layer');
    const handle = slider.querySelector('.slider-handle');
    let isDragging = false;

    const updateSlider = (x) => {
        const rect = slider.getBoundingClientRect();
        let position = ((x - rect.left) / rect.width) * 100;

        // Boundary checks
        if (position < 0) position = 0;
        if (position > 100) position = 100;

        // Update Clip Path and Handle Position
        afterLayer.style.clipPath = `inset(0 0 0 ${position}%)`;
        handle.style.left = `${position}%`;
    };

    const onStart = (e) => {
        isDragging = true;
        slider.classList.add('dragging');
        onMove(e);
    };

    const onEnd = () => {
        isDragging = false;
        slider.classList.remove('dragging');
    };

    const onMove = (e) => {
        if (!isDragging) return;
        
        let x = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
        updateSlider(x);
    };

    // Event Listeners
    slider.addEventListener('mousedown', onStart);
    window.addEventListener('mousemove', onMove);
    window.addEventListener('mouseup', onEnd);

    slider.addEventListener('touchstart', onStart, { passive: true });
    window.addEventListener('touchmove', onMove, { passive: false });
    window.addEventListener('touchend', onEnd);

    // Initial position based on device
    const setInitialPosition = () => {
        const isMobile = window.innerWidth <= 768;
        const position = isMobile ? 100 : 50;
        
        afterLayer.style.clipPath = `inset(0 0 0 ${position}%)`;
        handle.style.left = `${position}%`;
    };

    setInitialPosition();
    
    // Optional: Re-set on resize if needed
    // window.addEventListener('resize', setInitialPosition);
});
