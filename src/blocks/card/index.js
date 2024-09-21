import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
  PanelColorSettings,
} from "@wordpress/block-editor";
import { PanelBody, RangeControl, ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context, isSelected }) {
    const {
      background_color,
      is_bordered,
      border_width,
      border_color,
      border_radius,
      padding,
    } = attributes;
    const blockProps = useBlockProps({
      className: `overflow-hidden ${is_bordered ? "border" : ""}`,
      style: {
        backgroundColor: background_color,
        borderStyle: `${is_bordered ? "solid" : "none"}`,
        borderWidth: `${is_bordered ? border_width + "px" : "none"}`,
        borderColor: `${is_bordered ? border_color : "none"}`,
        borderRadius: border_radius,
        padding: padding,
      },
    });

    // handle card border
    const toggleBorder = (value) => {
      setAttributes({ is_bordered: value });
    };

    // select background color
    const selectBackgroundColor = (color) => {
      setAttributes({ background_color: color });
    };

    // select border color
    const selectBorderColor = (color) => {
      setAttributes({ border_color: color });
    };

    const setBorderSize = (value) => {
      setAttributes({ border_width: value });
    };

    // border radius
    const setBorderRadius = (value) => {
      setAttributes({ border_radius: value });
    };

    const setPadding = (value) => {
      setAttributes({ padding: value });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            {/* Colors */}
            <PanelColorSettings
              title={__("Colors", "nortic-plugin")}
              colorSettings={[
                {
                  label: __("Background color", "nortic-plugin"),
                  value: background_color,
                  onChange: selectBackgroundColor,
                },
                <>
                  {is_bordered && {
                    label: __("Border color", "nortic-plugin"),
                    value: border_color,
                    onChange: selectBorderColor,
                  }}
                </>,
              ]}
            />
            {/* Border */}
            <ToggleControl
              label={__("Border", "nortic-plugin")}
              checked={is_bordered}
              onChange={toggleBorder}
              help={
                is_bordered
                  ? __("Card with border", "nortic-plugin")
                  : __("Borderless card", "nortic-plugin")
              }
            />
            {/* Border size */}
            <RangeControl
              label={__("Border size", "nortic-plugin")}
              value={border_width}
              onChange={setBorderSize}
              min={0}
              max={5}
            />
            {/* Border radius */}
            <RangeControl
              label={__("Border radius", "nortic-plugin")}
              value={border_radius}
              onChange={setBorderRadius}
              min={0}
              max={10}
            />
            {/* Padding */}
            <RangeControl
              label={__("Padding", "nortic-plugin")}
              value={padding}
              onChange={setPadding}
              min={0}
              max={50}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <InnerBlocks
            orientation="horizontal"
            allowedBlocks={[
              "core/post-title",
              "core/post-excerpt",
              "core/post-date",
              "core/paragraph",
              "core/buttons",
              "core/button",
              "core/columns",
              "core/column",
              "core/form",
              "core/form-input",
              "core/form-submit-button",
              "core/group",
              "core/heading",
              "core/html",
              "core/list",
              "core/list-item",
              "nortic-plugin/bootstrap-icon",
            ]}
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      background_color,
      is_bordered,
      border_width,
      border_color,
      border_radius,
      padding,
    } = attributes;
    const blockProps = useBlockProps.save({
      className: `overflow-hidden ${is_bordered ? "border" : ""}`,
      style: {
        backgroundColor: background_color,
        borderStyle: `${is_bordered ? "solid" : "none"}`,
        borderWidth: `${is_bordered ? border_width + "px" : "none"}`,
        borderColor: `${is_bordered ? border_color : "none"}`,
        borderRadius: border_radius,
        padding: padding,
      },
    });

    return (
      <div {...blockProps}>
        <InnerBlocks.Content />
      </div>
    );
  },
});
