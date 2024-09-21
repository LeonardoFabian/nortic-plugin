/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/admin/main.css":
/*!****************************!*\
  !*** ./src/admin/main.css ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
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
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!****************************!*\
  !*** ./src/admin/index.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _main_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./main.css */ "./src/admin/main.css");


// Options Page

const logoImgUploadBtn = document.querySelector("#np-theme-logo-upload-btn");
const logoImgPreview = document.querySelector("#np-theme-logo-preview");
const logoImgInput = document.querySelector("#np_theme_logo");
const logoFooterImgUploadBtn = document.querySelector("#np-theme-footer-logo-upload-btn");
const logoFooterImgPreview = document.querySelector("#np-theme-footer-logo-preview");
const logoFooterImgInput = document.querySelector("#np_theme_footer_logo");

// Open Graph Options Page

const ogImgUploadBtn = document.querySelector("#np-og-img-upload-btn");
const ogImgPreview = document.querySelector("#np-og-img-preview");
const ogImgInput = document.querySelector("#np_og_image");

// initialize media library
const logoMediaFrame = wp.media({
  title: "Select or Upload Media",
  button: {
    text: "Use this media"
  },
  multiple: false
});
const logoFooterMediaFrame = wp.media({
  title: "Select or Upload Media",
  button: {
    text: "Use this media"
  },
  multiple: false
});
const opengraphMediaFrame = wp.media({
  title: "Select or Upload Media",
  button: {
    text: "Use this media"
  },
  multiple: false
});
logoImgUploadBtn?.addEventListener("click", event => {
  event.preventDefault();
  logoMediaFrame.open();
});
logoMediaFrame.on("select", () => {
  const logoAttachment = logoMediaFrame.state().get("selection").first().toJSON();
  logoImgPreview.src = logoAttachment.sizes.logo.url;
  logoImgInput.value = logoAttachment.sizes.logo.url;
});
logoFooterImgUploadBtn?.addEventListener("click", event => {
  event.preventDefault();
  logoFooterMediaFrame.open();
});
logoFooterMediaFrame.on("select", () => {
  const logoFooterAttachment = logoFooterMediaFrame.state().get("selection").first().toJSON();
  logoFooterImgPreview.src = logoFooterAttachment.sizes.logoFooter.url;
  logoFooterImgInput.value = logoFooterAttachment.sizes.logoFooter.url;
});
ogImgUploadBtn?.addEventListener("click", event => {
  event.preventDefault();
  opengraphMediaFrame.open();
});
opengraphMediaFrame.on("select", () => {
  const opengraphAttachment = opengraphMediaFrame.state().get("selection").first().toJSON();
  ogImgPreview.src = opengraphAttachment.sizes.opengraph.url;
  ogImgInput.value = opengraphAttachment.sizes.opengraph.url;
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map