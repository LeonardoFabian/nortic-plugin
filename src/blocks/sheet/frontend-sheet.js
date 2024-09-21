document.addEventListener("DOMContentLoaded", () => {
  const norticSheet = document.querySelectorAll(
    ".wp-block-nortic-plugin-sheet"
  );

  norticSheet.forEach((sheet) => {
    const btn = sheet.querySelector(".sheet-trigger");
    const content = sheet.querySelector(".sheet-content");
    const icon = sheet.querySelector(".sheet-icon");

    btn.addEventListener("click", () => {
      btn.classList.toggle("active");

      if (btn.classList.contains("active")) {
        content.style.maxHeight = 376 + "px";
        icon.classList.remove("bi-chevron-up");
        icon.classList.add("bi-chevron-down");

        // getting Y position

        // const contentRect = content.getBoundingClientRect();

        // const y0 = contentRect.top + window.scrollY;
        const contentTop = content.offsetTop;

        // alert(contentTop);

        // window.scrollTo(contentTop, content.scrollHeight);
        content.scrollIntoView();
      } else {
        content.style.maxHeight = 0;
        icon.classList.remove("bi-chevron-down");
        icon.classList.add("bi-chevron-up");
      }
    });
  });
});
