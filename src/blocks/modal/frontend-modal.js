document.addEventListener("DOMContentLoaded", () => {
  const norticModal = document.querySelectorAll(
    ".wp-block-nortic-plugin-modal"
  );

  norticModal.forEach((modal) => {
    var modalTrigger = modal.querySelector(".modal-trigger-wrap > a");
    var modalContent = modal.querySelector(".modal-content-wrap");

    modalTrigger.addEventListener("click", () => {
      window.location.hash = "#" + modalContent.id;
    });
  });
});
