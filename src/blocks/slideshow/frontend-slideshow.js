import Glide from "@glidejs/glide";

document.addEventListener("DOMContentLoaded", () => {
  const slideshow = document.querySelector(".glide-slideshow");

  var slideshowGlide = new Glide(slideshow, {
    type: "slider",
    perView: 4,
    autoplay: 5000,
    hoverpause: true,
    bound: true,
  });

  slideshowGlide.mount();
});
