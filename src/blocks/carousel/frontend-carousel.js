import Glide, {
  Controls,
  Breakpoints,
} from "@glidejs/glide/dist/glide.modular.esm.js";

document.addEventListener("DOMContentLoaded", () => {
  const carousel = document.querySelector(".glide-carousel");

  var carouselGlide = new Glide(carousel, {
    type: "slider",
    perView: 1, // número de diapositivas visibles en la ventanilla única.
    autoplay: 5000,
    autoplay: false, //5000,
    hoverpause: true,
    keyboard: true,
    // bound: true,
    focusAt: "center",
  });

  carouselGlide.mount({ Controls, Breakpoints });
});
