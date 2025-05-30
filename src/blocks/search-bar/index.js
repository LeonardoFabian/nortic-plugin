import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  PanelColorSettings,
  InspectorControls,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { color, bgColor } = attributes;
    const blockProps = useBlockProps({
      className: "h-11",
    });
    return (
      <>
        <InspectorControls>
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
          <form>
            <input
              className="bg-white h-10 px-5 text-sm"
              type="search"
              name="search"
              placeholder={__("Search", "nortic-plugin")}
              style={{ color: color, "background-color": bgColor }}
            />
            <button type="submit" className="absolute">
              <i className="bi bi-search" style={{ color: color }}></i>
            </button>
          </form>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { color, bgColor } = attributes;
    const blockProps = useBlockProps.save({
      className: "h-11",
    });

    return (
      <div {...blockProps}>
        <form>
          <input
            className="bg-white h-10 px-5 text-sm absolute md:relative inset-x-0 top-0"
            type="search"
            name="search"
            placeholder={__("Search", "nortic-plugin")}
            style={{ color: color, "background-color": bgColor }}
          />
          <button type="submit" className="absolute">
            <i className="bi bi-search" style={{ color: color }}></i>
          </button>
        </form>
      </div>
    );
  },
});
