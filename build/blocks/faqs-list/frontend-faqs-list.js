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
  !*** ./src/blocks/faqs-list/frontend-faqs-list.js ***!
  \****************************************************/
__webpack_require__.r(__webpack_exports__);
document.addEventListener("DOMContentLoaded", () => {
  const accordionHeader = document.querySelectorAll(".accordion > .accordion-header");
  accordionHeader.forEach(aHeader => {
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
/******/ })()
;
//# sourceMappingURL=frontend-faqs-list.js.map