/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./src/blocks/team-list/team-list-frontend.js ***!
  \****************************************************/
__webpack_require__.r(__webpack_exports__);
document.addEventListener("DOMContentLoaded", function () {
  // Inicializa el slider de miniaturas (mySwiperThumbs)
  var swiperThumbs = new Swiper(".mySwiperThumbs", {
    spaceBetween: 10,
    slidesPerView: 6,
    // Cambia el número de miniaturas visibles
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
      640: {
        slidesPerView: 6 // Muestra 4 miniaturas en pantallas grandes
      },

      320: {
        slidesPerView: 3 // Muestra 2 miniaturas en pantallas pequeñas
      }
    },

    loop: true // Habilitar loop
  });

  // Inicializa el slider principal (mySwiper2)
  var swiperMain = new Swiper(".mySwiper2", {
    spaceBetween: 10,
    slidesPerView: 1,
    thumbs: {
      swiper: swiperThumbs // Vincular a las miniaturas
    },

    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    loop: true,
    // Habilitar loop
    freeMode: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false
    }
  });
});

// function TeamSlider({ postData }) {
//   const [thumbsSwiper, setThumbsSwiper] = useState(null);

//   return (
//     <>
//       <Swiper
//         style={{
//           "--swiper-navigation-color": "#fff",
//         }}
//         loop={true}
//         spaceBetween={10}
//         navigation={true}
//         thumbs={{ swiper: thumbsSwiper }}
//         modules={[FreeMode, Navigation, Thumbs]}
//         className="mySwiper2"
//       >
//         {postData.map((post, index) => (
//           <SwiperSlide key={index}>
//             <a href={post.link}>
//               <img src={post.image} alt={post.title} />
//             </a>
//             <h3>{post.title}</h3>
//           </SwiperSlide>
//         ))}
//       </Swiper>

//       <Swiper
//         onSwiper={setThumbsSwiper}
//         spaceBetween={10}
//         slidesPerView={4}
//         freeMode={true}
//         watchSlidesProgress={true}
//         modules={[FreeMode, Thumbs]}
//         className="mySwiperThumbs"
//       >
//         {postData.map((post, index) => (
//           <SwiperSlide key={index}>
//             <img src={post.thumb} alt={post.title} />
//           </SwiperSlide>
//         ))}
//       </Swiper>
//     </>
//   );
// }

// document.addEventListener("DOMContentLoaded", () => {
//   const block = document.querySelector(
//     ".wp-block-nortic-plugin-nortic-team-list"
//   );

//   if (block) {
//     const postData = Array.from(block.querySelectorAll(".swiper-slide")).map(
//       (slide) => ({
//         link: slide.querySelector("a").href,
//         image: slide.querySelector("img").src,
//         title: slide.querySelector("h3").innerText,
//         thumb: slide.querySelector("img").src, // assuming thumbnail is same image, adjust if different
//       })
//     );

//     render(<TeamSlider postData={postData} />, block);
//   }
// });
/******/ })()
;
//# sourceMappingURL=team-list-frontend.js.map