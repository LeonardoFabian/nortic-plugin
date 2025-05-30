document.addEventListener("DOMContentLoaded", function () {
  const tabButtons = document.querySelectorAll(".directories-tab-button");
  const tabContents = document.querySelectorAll(
    ".directories-tabs-content-list"
  );

  if (tabButtons.length > 0 && tabContents.length > 0) {
    // Ocultar todos los contenidos y desactivar todos los botones
    tabButtons.forEach((btn) => btn.classList.remove("active"));
    tabContents.forEach((content) => content.classList.add("hidden"));

    // Activar el primer tab y mostrar su contenido
    tabButtons[0].classList.add("active");
    tabContents[0].classList.remove("hidden");

    tabButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const termId = this.getAttribute("data-term-id");

        // Remover la clase active de todos los botones y ocultar todos los contenidos
        tabButtons.forEach((btn) => btn.classList.remove("active"));
        tabContents.forEach((content) => content.classList.add("hidden"));

        // Agregar la clase active solo al tab y mostrar su contenido
        this.classList.add("active");
        const activeContent = document.querySelector(
          `.directories-tabs-content-list[data-term-id="${termId}"]`
        );
        if (activeContent) {
          activeContent.classList.remove("hidden");
        }
      });
    });
  }
});

// document.addEventListener("DOMContentLoaded", function () {
//   const tabButtons = document.querySelectorAll(".directories-tab-button");
//   const tabContents = document.querySelectorAll(
//     ".directories-tabs-content .directories-tabs-content-list"
//   );

//   if (tabButtons.length > 0 && tabContents.length > 0) {
//     // Marcar el primer tab como activo por defecto
//     tabButtons[0].classList.add("active");
//     // tabContents[0].classList.remove("hidden");
//     tabContents[0].classList.add("active");

//     tabButtons.forEach((button) => {
//       button.addEventListener("click", function () {
//         const termId = this.getAttribute("data-term-id");

//         // Remover la clase active de todos los botones y contenidos
//         tabButtons.forEach((btn) => btn.classList.remove("active"));
//         tabContents.forEach((content) => content.classList.remove("active"));

//         // Agregar la clase active solo al tab y contenido correspondiente
//         this.classList.add("active");
//         document
//           .querySelector(
//             `.directories-tabs-content-list[data-term-id="${termId}"]`
//           )
//           ?.classList.add("active");
//       });
//     });
//   }
// });

// document.addEventListener("DOMContentLoaded", () => {
//   function showTab(termId) {
//     document
//       .querySelectorAll(".directories-tabs-content-list")
//       .forEach((section) => {
//         section.classList.add("hidden");
//       });
//     document.querySelectorAll(".directories-tab-button").forEach((tab) => {
//       tab.classList.remove("active");
//     });

//     document
//       .querySelector(`.directories-tabs-content-list[data-term-id='${termId}']`)
//       ?.classList.remove("hidden");
//     document
//       .querySelector(`.directories-tab-button[data-term-id='${termId}']`)
//       ?.classList.add("active");
//   }

//   document.querySelectorAll(".directories-tab-button").forEach((button) => {
//     button.addEventListener("click", () => {
//       showTab(button.getAttribute("data-term-id"));
//     });
//   });

//   const firstTab = document.querySelector(".directories-tab-button");
//   if (firstTab) {
//     showTab(firstTab.getAttribute("data-term-id"));
//   }
// });
