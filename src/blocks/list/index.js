import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
  RichText,
} from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  Button,
  PanelBody,
  SelectControl,
} from "@wordpress/components";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, direction } = attributes;
    const blockProps = useBlockProps({
      className: "space-y-4 nortic-list w-full",
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={_x("Settings", "PanelBody label", "nortic-plugin")}>
            <SelectControl
              label={_x(
                "Flex Direction",
                "SelectControl label",
                "nortic-plugin"
              )}
              value={direction}
              options={[
                { label: __("Row", "nortic-plugin"), value: "row" },
                { label: __("Column", "nortic-plugin"), value: "column" },
              ]}
              onChange={(direction) => setAttributes({ direction })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="nortic-list-header cursor-pointer border-b border-ultimate-gray">
            <button
              type="button"
              className="list-header-toggle-btn flex items-center justify-between w-full gap-6"
            >
              <RichText
                tagName="span"
                placeholder={_x(
                  "Add a custom title",
                  "RichText label",
                  "nortic-plugin"
                )}
                value={title}
                onChange={(title) => setAttributes({ title })}
              />
              {/* <span class="bg-white rounded-full">
                <i class="list-toggle-icon bi bi-chevron-right color-blue text-sm font-semibold"></i>
              </span> */}
            </button>
          </div>
          <div
            class="list-body grid grid-cols-3 place-items-center gap-4"
            style={{ flexDirection: direction }}
          >
            <InnerBlocks orientation="vertical" />
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { title, direction } = attributes;
    const blockProps = useBlockProps.save({
      className: "space-y-4 nortic-list w-full",
    });

    return (
      <div {...blockProps}>
        <div className="nortic-list-header cursor-pointer border-b border-ultimate-gray">
          <button
            type="button"
            className="list-header-toggle-btn flex items-center justify-between w-full gap-6"
          >
            <RichText.Content tagName="span" value={title} />
            {/* <span className="bg-white rounded-full">
              <i className="list-toggle-icon bi bi-chevron-right color-blue text-sm font-semibold"></i>
            </span> */}
          </button>
        </div>
        <div
          className="list-body grid grid-cols-3 place-items-center gap-4 overflow-hidden transition-all duration-200 ease-out"
          style={{ flexDirection: direction }}
        >
          <InnerBlocks.Content />
        </div>
      </div>
    );
  },
});
