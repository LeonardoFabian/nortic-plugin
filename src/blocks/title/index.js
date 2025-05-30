import { registerBlockType } from "@wordpress/blocks";
import {
  RichText,
  useBlockProps,
  InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, ColorPalette } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, color, underline_color } = attributes;
    const blockProps = useBlockProps({
      style: {
        color: color,
      },
    });
    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Colors", "nortic-plugin")}>
            <ColorPalette
              colors={[
                { name: "Blue", color: "#003876" },
                { name: "Red", color: "#ee2a24" },
                { name: "White", color: "#ffffff" },
                { name: "Black", color: "#000000" },
              ]}
              value={color}
              onChange={(newVal) => setAttributes({ color: newVal })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <RichText
            tagName="h1"
            className="nortic-title"
            placeholder={__("Click to edit", "nortic-plugin")}
            value={title}
            onChange={(title) => setAttributes({ title })}
            allowedFormats={[
              "core/bold",
              "core/italic",
              "core/link",
              "core/text-color",
            ]}
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { title, color, underline_color } = attributes;
    const blockProps = useBlockProps.save({
      style: {
        color: color,
      },
    });

    return (
      <div {...blockProps}>
        <RichText.Content className="nortic-title" tagName="h1" value={title} />
      </div>
    );
  },
});
