import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  InspectorControls,
  PanelColorSettings,
} from "@wordpress/block-editor";
import { ToggleControl, PanelBody } from "@wordpress/components";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { content, showCategory, color, bgColor } = attributes;
    const blockProps = useBlockProps({
      style: {
        "background-color": bgColor,
        color: color,
      },
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("General", "nortic-plugin")}>
            <ToggleControl
              label={_x(
                "Show Category",
                "page-header ToggleControl label",
                "nortic-plugin"
              )}
              checked={showCategory}
              onChange={(showCategory) => setAttributes({ showCategory })}
              help={
                showCategory
                  ? __("Category shown", "nortic-plugin")
                  : __("Custom page header shown", "nortic-plugin")
              }
            />
          </PanelBody>
          <PanelColorSettings
            title={__("Colors", "nortic-plugin")}
            colorSettings={[
              {
                label: __("Text Color", "nortic-plugin"),
                value: color,
                onChange: (color) => setAttributes({ color }),
              },
              {
                label: __("Background Color", "nortic-plugin"),
                value: bgColor,
                onChange: (bgColor) => setAttributes({ bgColor }),
              },
            ]}
          />
        </InspectorControls>
        <div {...blockProps}>
          <div className="inner-page-header container !mx-auto">
            {showCategory ? (
              <h2>{__("Some Category", "nortic-plugin")}</h2>
            ) : (
              <RichText
                tagName="h2"
                placeholder={__(
                  "Click to edit or activate the setting to show the category title",
                  "nortic-plugin"
                )}
                value={content}
                onChange={(content) => setAttributes({ content })}
                allowedFormats={[
                  "core/bold",
                  "core/italic",
                  "core/link",
                  "core/text-color",
                ]}
              />
            )}
          </div>
        </div>
      </>
    );
  },
});
