document.addEventListener("DOMContentLoaded", () => {
  const provinces = document.querySelectorAll(".province");

  provinces.forEach((province) => {
    province.addEventListener("click", function () {
      const provinceID = this.dataset.provinceId;
      const provinceName = this.dataset.dependencyMapItem;
      const provinceLink = this.dataset.provinceLink;

      console.log("province link: ", provinceLink);

      //   console.log("Plugin URL: ", pluginData.pluginUrl);
      const pluginUrl = pluginData.pluginUrl;

      // Realiza la petición fetch a la API de WordPress
      fetch(`/wp-json/wp/v2/dependency?province=${provinceID}&_embed`)
        .then((response) => {
          // Verifica si la respuesta fue exitosa
          if (!response.ok) {
            throw new Error("Error en la consulta");
          }
          return response.json();
        })
        .then((data) => {
          // Procesa los datos obtenidos
          let provinceOutput = "";
          let output = "";
          if (data.length > 0) {
            provinceOutput += `<div>`;
            provinceOutput += `<span>Ubicación</span>`;
            provinceOutput += `<h3>`;
            provinceOutput += `<a href="${provinceLink}">${provinceName}</a>`;
            provinceOutput += `</h3>`;
            provinceOutput += `</span>`;
            output += `<ul>`;
            data.forEach((item) => {
              // featured image
              const featuredMedia = item._embedded["wp:featuredmedia"]
                ? item._embedded["wp:featuredmedia"]?.[0]?.source_url
                : `${pluginUrl}dist/public/images/default.jpg`;
              //   const phone = item.meta?.phone ? item.meta.phone : null;
              //   const location = item.meta?.location ? item.meta.location : null;

              output += `<li>`;
              output += `<img src="${featuredMedia}" alt="${item.title.rendered}">`;
              output += `<div>`;
              output += `<h6>${item.title.rendered}</h6>`;
              //   if (location) {
              //     output += `<p>${location}</p>`;
              //   }
              //   if (phone) {
              //     output += `<p>${phone}</p>`;
              //   }
              output += `<a href="${item.link}">Ver más detalles</a>`;
              output += `</div>`;
              output += `</li>`;
            });
            output += "</ul>";
          } else {
            output = "<p>No hay dependencias asociadas a esta provincia.</p>";
          }
          document.getElementById("interactive-map-info").innerHTML =
            provinceOutput;
          document.getElementById("interactive-province-info").innerHTML =
            output;
        })
        .catch((error) => {
          console.error("Error fetching dependencies:", error);
        });
    });
  });
});
