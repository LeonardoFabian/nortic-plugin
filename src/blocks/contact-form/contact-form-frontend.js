document.addEventListener("DOMContentLoaded", () => {
  const contactForm = document.querySelector("#np-contact-form");
  const btnReset = document.getElementById("reset-form-button");

  contactForm.addEventListener("submit", (event) => {
    contactForm.reset();
  });

  btnReset.addEventListener("click", () => {
    contactForm.reset();
  });
});
