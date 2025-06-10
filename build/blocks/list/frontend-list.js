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
/*!******************************************!*\
  !*** ./src/blocks/list/frontend-list.js ***!
  \******************************************/
__webpack_require__.r(__webpack_exports__);
const listHeader = document.querySelectorAll(".nortic-list > .nortic-list-header");
listHeader.forEach(liHeader => {
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
/******/ })()
;
//# sourceMappingURL=frontend-list.js.map