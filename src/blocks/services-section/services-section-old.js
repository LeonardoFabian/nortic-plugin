import Glide from '@glidejs/glide'

document.addEventListener("DOMContentLoaded", () => {
    const serviceSection = document.querySelector('.wp-block-nortic-plugin-services-section');
    
    var glide = new Glide(serviceSection, {
        type: "carousel",
        startAt: 0,
        // focusAt: 'center',
        autoplay: 3000,
        gap: 10,
        hoverpause: true,
        animationDuration: 1000,
        perView: 3,
        breakpoints: {
            1024: {
                perView: 3
            },
            800: {
                perView: 2
            },
            480: {
                perView: 1
            }
        }
    });
    
    glide.mount();
})