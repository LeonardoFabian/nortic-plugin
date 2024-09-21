import Glide from "@glidejs/glide";

document.addEventListener("DOMContentLoaded", () => {
  const systemList = document.querySelector(
    ".wp-block-nortic-plugin-system-list"
  );

  var glide = new Glide(systemList, {
    type: "carousel",
    startAt: 0,
    focusAt: "center",
    autoplay: false, // 3000,
    gap: 10,
    hoverpause: true,
    animationDuration: 1000,
    perView: 4, // 5,
    breakpoints: {
      1024: {
        perView: 4,
      },
      800: {
        perView: 3,
      },
      480: {
        perView: 2,
      },
    },
  });

  glide.mount();
});
