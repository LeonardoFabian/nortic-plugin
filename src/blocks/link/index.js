import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  BlockControls,
  RichText,
  AlignmentToolbar,
} from "@wordpress/block-editor";
import {
  PanelBody,
  SelectControl,
  ToolbarButton,
  TextareaControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, label, link, link_target, alignment } = attributes;
    const blockProps = useBlockProps({
      className: `is-layout-constrained wp-block-group mb-8 text-${alignment}`,
    });

    const handleLinkContentAlignment = (newAlignment) => {
      setAttributes({ alignment: newAlignment });
    };

    return (
      <>
        <BlockControls group="inline">
          <AlignmentToolbar
            onChange={handleLinkContentAlignment}
            value={alignment}
          />
        </BlockControls>
        <InspectorControls>
          <TextareaControl
            label={__("Link URL", "nortic-plugin")}
            value={link}
            onChange={(link) => setAttributes({ link })}
            help={__("Add the link Url", "nortic-plugin")}
          />
          <SelectControl
            label={__("Open the link in:", "nortic-plugin")}
            value={link_target}
            options={[
              { label: __("Same tab", "nortic-plugin"), value: "_self" },
              {
                label: __("New tab", "nortic-plugin"),
                value: "_blank",
              },
            ]}
            onChange={(link_target) => setAttributes({ link_target })}
          />
        </InspectorControls>
        <div {...blockProps}>
          <RichText
            tagName="p"
            className={`nortic-plugin-link-title has-small-font-size text-${alignment}`}
            placeholder={__("Add a title", "nortic-plugin")}
            value={title}
            onChange={(title) => setAttributes({ title })}
            style={{
              textAlign: alignment,
            }}
          />
          <RichText
            tagName="p"
            className={`nortic-plugin-link-label has-small-font-size text-${alignment}`}
            placeholder={__(
              "Add a custom label for this link",
              "nortic-plugin"
            )}
            value={label}
            onChange={(label) => setAttributes({ label })}
            style={{
              textAlign: alignment,
            }}
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { title, label, link, link_target, alignment } = attributes;
    const blockProps = useBlockProps.save({
      className: `is-layout-constrained wp-block-group mb-8 text-${alignment}`,
    });

    return (
      <div {...blockProps}>
        <RichText.Content
          tagName="p"
          className={`nortic-plugin-link-title has-small-font-size text-${alignment}`}
          value={title}
          style={{
            textAlign: alignment,
          }}
        />
        <a href={link} target={link_target} alt={title}>
          <RichText.Content
            tagName="p"
            className={`nortic-plugin-link-label has-small-font-size text-${alignment}`}
            value={label}
            style={{
              textAlign: alignment,
            }}
          />
        </a>
      </div>
    );
  },
});
