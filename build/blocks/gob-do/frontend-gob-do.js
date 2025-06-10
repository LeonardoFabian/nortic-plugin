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
/*!**********************************************!*\
  !*** ./src/blocks/gob-do/frontend-gob-do.js ***!
  \**********************************************/
__webpack_require__.r(__webpack_exports__);
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
/******/ })()
;
//# sourceMappingURL=frontend-gob-do.js.map