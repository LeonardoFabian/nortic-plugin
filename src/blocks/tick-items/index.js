import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, TextareaControl } from "@wordpress/components";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { heading } = attributes;
    const blockProps = useBlockProps();

    const handleChangeHeading = (value) => {
      setAttributes({ heading: value });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <TextareaControl
              label={__("Title", block.textdomain)}
              value={heading}
              onChange={handleChangeHeading}
            />
          </PanelBody>
        </InspectorControls>
        <ul {...blockProps}>
          <RichText
            tagName="h5"
            placeholder={__("Click to add a custom title", block.textdomain)}
            value={heading}
            onChange={handleChangeHeading}
          />
          <InnerBlocks allowedBlocks={["nortic-plugin/tick-item"]} />
        </ul>
      </>
    );
  },
  save({ attributes }) {
    const { heading } = attributes;
    const blockProps = useBlockProps.save();

    return (
      <ul {...blockProps}>
        <RichText.Content tagName="h5" value={heading} />
        <InnerBlocks.Content />
      </ul>
    );
  },
});
