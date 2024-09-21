import Glide from "@glidejs/glide";

document.addEventListener("DOMContentLoaded", () => {
  const newslettersSection = document.querySelector(
    ".wp-block-nortic-plugin-newsletters-section"
  );

  var glide = new Glide(newslettersSection, {
    type: "carousel",
    startAt: 0,
    // focusAt: 'center',
    autoplay: 3000,
    gap: 30,
    hoverpause: true,
    animationDuration: 1000,
    perView: 5,
    breakpoints: {
      1024: {
        perView: 5,
      },
      800: {
        perView: 2,
      },
      480: {
        perView: 1,
      },
    },
  });

  glide.mount();
});
