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
/*!**********************************************************!*\
  !*** ./src/blocks/contact-form/contact-form-frontend.js ***!
  \**********************************************************/
__webpack_require__.r(__webpack_exports__);
document.addEventListener("DOMContentLoaded", () => {
  const contactForm = document.querySelector("#np-contact-form");
  const btnReset = document.getElementById("reset-form-button");
  contactForm.addEventListener("submit", event => {
    contactForm.reset();
  });
  btnReset.addEventListener("click", () => {
    contactForm.reset();
  });
});
/******/ })()
;
//# sourceMappingURL=contact-form-frontend.js.map