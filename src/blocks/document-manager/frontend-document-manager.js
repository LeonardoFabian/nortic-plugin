document.addEventListener("DOMContentLoaded", () => {
  function showTab(tab) {
    document.getElementById("tab-content-section")?.classList.add("hidden");
    document.getElementById("tab-documents-section")?.classList.add("hidden");
    document.getElementById("tab-content")?.classList.remove("active");
    document.getElementById("tab-documents")?.classList.remove("active");

    if (tab === "content") {
      document
        .getElementById("tab-content-section")
        ?.classList.remove("hidden");
      document.getElementById("tab-content")?.classList.add("active");
    } else if (tab === "documents") {
      document
        .getElementById("tab-documents-section")
        ?.classList.remove("hidden");
      document.getElementById("tab-documents")?.classList.add("active");
    }
  }

  const contentTab = document.getElementById("tab-content");
  const documentsTab = document.getElementById("tab-documents");

  // Agregar eventos a los botones de pestañas si existen
  document.querySelectorAll(".tab-button").forEach((button) => {
    button.addEventListener("click", () => {
      const tab = button.getAttribute("data-tab"); // Obtener el atributo data-tab
      showTab(tab);
    });
  });

  // Determinar qué pestaña mostrar por defecto
  if (contentTab && documentsTab) {
    showTab("content"); // Si ambas pestañas existen, mostrar "Content" por defecto
  } else if (contentTab && documentsTab === null) {
    showTab("content"); // Si solo existe "Content", mostrarlo
  } else if (
    contentTab &&
    !document.querySelector("#tab-content-section").classList.contains("hidden")
  ) {
    showTab("content"); // Si el contenido está presente, mostrar la pestaña
    contentTab.classList.add("hidden"); // Ocultar botón de contenido si no hay contenido
  } else if (documentsTab) {
    showTab("documents"); // Si solo existe "Documents", mostrarlo
    documentsTab.classList.add("hidden"); // Ocultar botón de documentos si no hay otra pestaña
  }
});
