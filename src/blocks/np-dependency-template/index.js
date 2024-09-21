import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
} from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    const TEMPLATE = [
      ["core/post-title", {}],
      ["core/post-featured-image", {}],
    ];

    return (
      <div {...blockProps}>
        <InnerBlocks
          orientation="vertical"
          allowedBlocks={["core/post-title", "core/post-featured-image"]}
          template={TEMPLATE}
        />
      </div>
    );
  },
  save({ attributes }) {
    const blockProps = useBlockProps.save();

    return (
      <div {...blockProps}>
        <InnerBlocks.Content />
      </div>
    );
  },
});
