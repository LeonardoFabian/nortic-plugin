import defaultConfig from "@wordpress/scripts/config/webpack.config.js";

export default {
  ...defaultConfig,
  entry: {
    ...defaultConfig.entry(),
    "admin/index": "./src/admin",
    "block-editor/index": "./src/block-editor",
    "block-editor/achievement/index": "./src/block-editor/achievement",
    "block-editor/award/index": "./src/block-editor/award",
    "block-editor/dependency/index": "./src/block-editor/dependency",
    "block-editor/document/index": "./src/block-editor/document",
    "block-editor/event/index": "./src/block-editor/event",
    "block-editor/faq/index": "./src/block-editor/faq",
    "block-editor/gallery/index": "./src/block-editor/gallery",
    "block-editor/newsletter/index": "./src/block-editor/newsletter",
    "block-editor/resolution/index": "./src/block-editor/resolution",
    "block-editor/resource/index": "./src/block-editor/resource",
    "block-editor/service/index": "./src/block-editor/service",
    "block-editor/system/index": "./src/block-editor/system",
    "block-editor/team/index": "./src/block-editor/team",
  },
};
