/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/block-editor/sidebar.js":
/*!*************************************!*\
  !*** ./src/block-editor/sidebar.js ***!
  \*************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// import { registerPlugin } from "@wordpress/plugins";
// import { PluginSidebar } from "@wordpress/edit-post";
// import { __ } from "@wordpress/i18n";
// import { useSelect, useDispatch } from "@wordpress/data";
// import {
//   PanelBody,
//   Icon,
//   TextControl,
//   __experimentalHStack as HStack,
// } from "@wordpress/components";

// registerPlugin("nortic-plugin-sidebar", {
//   render() {
//     const { phone, email } = useSelect((select) => {
//       return select("core/editor").getEditedPostAttribute("meta");
//     }, []);

//     const { editPost } = useDispatch("core/editor");

//     return (
//       <PluginSidebar
//         name="nortic_plugin_sidebar"
//         icon="menu-alt"
//         title={__("Team Metadata", "nortic-plugin")}
//       >
//         <PanelBody title={__("Information", "nortic-plugin")}>
//           <HStack>
//             <Icon icon="phone" />
//             <TextControl
//               label={__("Phone Number", "nortic-plugin")}
//               value={phone}
//               onChange={(phone) =>
//                 editPost({
//                   meta: {
//                     phone,
//                   },
//                 })
//               }
//             />
//           </HStack>
//         </PanelBody>
//       </PluginSidebar>
//     );
//   },
// });

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
/*!***********************************!*\
  !*** ./src/block-editor/index.js ***!
  \***********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sidebar_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./sidebar.js */ "./src/block-editor/sidebar.js");

})();

/******/ })()
;
//# sourceMappingURL=index.js.map