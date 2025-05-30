// Este archivo es el frontend handler del slideshow con Glide.js
import Glide, {
  Controls,
  Breakpoints,
} from "@glidejs/glide/dist/glide.modular.esm.js";

/**
 * Inicializar el Glide solo si hay un carrusel con clase 'glide-slideshow'
 */
document.addEventListener("DOMContentLoaded", () => {
  const glideCarousels = document.querySelectorAll(".glide-slideshow");

  glideCarousels.forEach((glide) => {
    new Glide(glide, {
      type: "carousel",
      perView: 1,
      autoplay: 4000,
      animationDuration: 800,
      hoverpause: true,
      gap: 0,
      breakpoints: {
        768: { perView: 1 },
        480: { perView: 1 },
      },
      classes: {
        activeNav: "glide__bullet--active",
      },
    }).mount({ Controls, Breakpoints });
  });
});

// import Glide from "@glidejs/glide";

// document.addEventListener("DOMContentLoaded", () => {
//   const slideshow = document.querySelector(".glide-slideshow");

//   var slideshowGlide = new Glide(slideshow, {
//     type: "slider",
//     perView: 4,
//     autoplay: 5000,
//     hoverpause: true,
//     bound: true,
//   });

//   slideshowGlide.mount();
// });
