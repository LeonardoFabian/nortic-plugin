import Glide, { Autoplay } from "@glidejs/glide";

document.addEventListener("DOMContentLoaded", () => {
  const carousel = document.querySelector(".glide-carousel");

  var carouselGlide = new Glide(carousel, {
    type: "slider",
    perView: 1,
    autoplay: false,
    autoplay: false, //5000,
    hoverpause: true,
    // bound: true,
    focusAt: "center",
  });

  carouselGlide.mount();
});
