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
/*!********************************************!*\
  !*** ./src/blocks/modal/frontend-modal.js ***!
  \********************************************/
__webpack_require__.r(__webpack_exports__);
document.addEventListener("DOMContentLoaded", () => {
  const norticModal = document.querySelectorAll(".wp-block-nortic-plugin-modal");
  norticModal.forEach(modal => {
    var modalTrigger = modal.querySelector(".modal-trigger-wrap > a");
    var modalContent = modal.querySelector(".modal-content-wrap");
    modalTrigger.addEventListener("click", () => {
      window.location.hash = "#" + modalContent.id;
    });
  });
});
/******/ })()
;
//# sourceMappingURL=frontend-modal.js.map