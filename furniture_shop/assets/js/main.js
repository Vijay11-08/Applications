// Main JS for Luxura Furniture
document.addEventListener('DOMContentLoaded', () => {
    // Quantity Selector logic
    const qtyButtons = document.querySelectorAll('.qty-btn');
    qtyButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('input');
            let val = parseInt(input.value);
            if (btn.textContent === '+') {
                val++;
            } else if (btn.textContent === '-' && val > 1) {
                val--;
            }
            input.value = val;
        });
    });

    // Intersection Observer for scroll reveal
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card, .category-card, .section-title').forEach(el => {
        observer.observe(el);
    });

    // Header scroll effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.style.background = 'rgba(11, 13, 15, 0.95)';
            header.style.padding = '0.8rem 0';
        } else {
            header.style.background = 'var(--glass-bg)';
            header.style.padding = '1.2rem 0';
        }
    });
});
