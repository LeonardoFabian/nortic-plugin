const listHeader = document.querySelectorAll(
  ".nortic-list > .nortic-list-header"
);

listHeader.forEach((liHeader) => {
  liHeader.style.background = "red";
  const listToggleIcon = liHeader.querySelector(".list-toggle-icon");
  const listBody = liHeader.nextElementSibling;

  // on load

  if (liHeader.classList.contains("active")) {
    listToggleIcon.classList.remove("bi-chevron-right");
    listToggleIcon.classList.add("bi-chevron-down");
    listBody.style.maxHeight = listBody.scrollHeight + "px";
  } else {
    listToggleIcon.classList.remove("bi-chevron-down");
    listToggleIcon.classList.add("bi-chevron-right");
    listBody.style.maxHeight = 0;
  }

  // on click

  liHeader.addEventListener("click", () => {
    alert("click");
    liHeader.classList.toggle("active");

    if (liHeader.classList.contains("active")) {
      listToggleIcon.classList.remove("bi-chevron-right");
      listToggleIcon.classList.add("bi-chevron-down");
      listBody.style.maxHeight = listBody.scrollHeight + "px";
    } else {
      listToggleIcon.classList.remove("bi-chevron-down");
      listToggleIcon.classList.add("bi-chevron-right");
      listBody.style.maxHeight = 0;
    }
  });
});
