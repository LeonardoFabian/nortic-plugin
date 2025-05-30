import Glide from "@glidejs/glide";

// Modificar según tus controles
const classes = {
  controls: "slider-controls",
  backArrow: "slider-back",
  nextArrow: "slider-next",
};

function ArrowDisabler(Glide, Components) {
  return {
    mount() {
      if (Glide.settings.rewind) {
        return;
      }

      Glide.on(["mount.after", "run"], () => {
        for (let controlItem of Components.Controls.items) {
          if (controlItem.className !== classes.controls) {
            continue;
          }

          // Flecha izquierda
          var left = controlItem.querySelector("." + classes.backArrow);
          if (left) {
            if (Glide.index === 0) {
              left.setAttribute("disabled", "");
            } else {
              left.removeAttribute("disabled");
            }
          }

          // Flecha derecha
          var right = controlItem.querySelector("." + classes.nextArrow);
          if (right) {
            const lastSlideIndex = Glide.settings.bound
              ? Glide.index + (Glide.settings.perView - 1)
              : Glide.index;

            if (lastSlideIndex === Components.Sizes.length - 1) {
              right.setAttribute("disabled", "");
            } else {
              right.removeAttribute("disabled");
            }
          }
        }
      });
    },
  };
}

document.addEventListener("DOMContentLoaded", () => {
  const serviceSection = document.querySelector(
    ".wp-block-nortic-plugin-services-section"
  );

  if (serviceSection) {
    var glide = new Glide(serviceSection, {
      type: "carousel",
      startAt: 0,
      autoplay: 3000,
      gap: 10,
      hoverpause: true,
      animationDuration: 1000,
      perView: 3,
      bound: true,
      breakpoints: {
        1024: { perView: 3 },
        800: { perView: 2 },
        480: { perView: 1 },
      },
    });

    glide.mount({ ArrowDisabler });
  }
});
