document.addEventListener("DOMContentLoaded", () => {
  const accordionHeader = document.querySelectorAll(
    ".accordion > .accordion-header"
  );

  accordionHeader.forEach((aHeader) => {
    const accordionIcon = aHeader.querySelector(".accordion-icon");
    const accordionBody = aHeader.nextElementSibling;

    // on load

    if (aHeader.classList.contains("active")) {
      accordionIcon.classList.remove("bi-plus-lg");
      accordionIcon.classList.add("bi-dash");
      accordionBody.style.maxHeight = accordionBody.scrollHeight + "px";
    } else {
      accordionIcon.classList.remove("bi-dash");
      accordionIcon.classList.add("bi-plus-lg");
      accordionBody.style.maxHeight = 0;
    }

    // on click

    aHeader.addEventListener("click", () => {
      aHeader.classList.toggle("active");

      if (aHeader.classList.contains("active")) {
        accordionIcon.classList.remove("bi-plus-lg");
        accordionIcon.classList.add("bi-dash");
        accordionBody.style.maxHeight = accordionBody.scrollHeight + "px";
      } else {
        accordionIcon.classList.remove("bi-dash");
        accordionIcon.classList.add("bi-plus-lg");
        accordionBody.style.maxHeight = 0;
      }
    });
  });
});
