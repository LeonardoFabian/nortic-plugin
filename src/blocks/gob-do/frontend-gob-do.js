document.addEventListener("DOMContentLoaded", function () {
  const button = document.getElementById("gob-do-button");
  const dropdown = document.getElementById("gob-do-dropdown");

  dropdown.classList.add("hidden");
  dropdown.style.height = 0;

  if (button) {
    button.addEventListener("click", () => {
      button.classList.toggle("active");

      if (button.classList.contains("active")) {
        dropdown.classList.remove("hidden");
        // dropdown.style.height = dropdown.scrollHeight + "px";
        dropdown.style.height = "100px";
      } else {
        dropdown.classList.add("hidden");
        dropdown.style.height = 0;
        // dropdown.style.maxHeight = 0;
      }
    });
  }
});
