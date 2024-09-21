import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
  RichText,
  PanelColorSettings,
} from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  Button,
  PanelBody,
  SelectControl,
  RangeControl,
  ToggleControl,
  __experimentalHStack as HStack,
} from "@wordpress/components";
import { useEffect } from "@wordpress/element";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      title,
      color,
      background_color,
      anchor,
      transition_direction,
      display,
      columns,
    } = attributes;
    const blockProps = useBlockProps({
      className: "w-full",
      style: {
        backgroundColor: background_color,
      },
    });

    const handleTitle = (new_title) => {
      setAttributes({ title: new_title });
    };

    const handleColor = (new_color) => {
      setAttributes({ color: new_color });
    };

    const handleBackgroundColor = (new_bg_color) => {
      setAttributes({ background_color: new_bg_color });
    };

    const handleTransitionDirection = (direction) => {
      setAttributes({ transition_direction: direction });
    };

    const handleSetAnchor = (anchor_string) => {
      setAttributes({ anchor: anchor_string });
    };

    const handleDisplay = (display_value) => {
      setAttributes({ display: display_value });
    };

    const handleNumberOfColumns = (col_number) => {
      setAttributes({ columns: col_number });
    };

    return (
      <>
        <InspectorControls>
          <PanelColorSettings
            title={_x("Colors", "PanelColorSettings label", "nortic-plugin")}
            colorSettings={[
              {
                label: __("Text Color", "nortic-plugin"),
                value: color,
                onChange: { handleColor },
              },
              {
                label: __("Background Color", "nortic-plugin"),
                value: background_color,
                onChange: { handleBackgroundColor },
              },
            ]}
          />
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <TextControl
              label={_x("Anchor", "TextControl label", "nortic-plugin")}
              value={anchor}
              onChange={handleSetAnchor}
            />
            <SelectControl
              label={_x(
                "Transition direction",
                "SelectControl label",
                "nortic-plugin"
              )}
              value={transition_direction}
              options={[
                {
                  label: _x(
                    "Top Sheet",
                    "SelectControl label",
                    "nortic-plugin"
                  ),
                  value: "top-sheet",
                },
                {
                  label: _x(
                    "Bottom Sheet",
                    "SelectControl label",
                    "nortic-plugin"
                  ),
                  value: "bottom-sheet",
                },
              ]}
              onChange={handleTransitionDirection}
            />
            <SelectControl
              label={_x("Display", "SelectControl label", "nortic-plugin")}
              value={display}
              options={[
                {
                  label: _x("Flex", "SelectControl label", "nortic-plugin"),
                  value: "flex",
                },
                {
                  label: _x("Grid", "SelectControl label", "nortic-plugin"),
                  value: "grid",
                },
              ]}
              onChange={handleDisplay}
            />
            <RangeControl
              label={__("Columns", "nortic-plugin")}
              onChange={handleNumberOfColumns}
              value={columns}
              min={1}
              max={6}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="sheet-content-container">
            <div className="sheet-trigger-container">
              <button className="sheet-trigger w-full flex items-center justify-between">
                <RichText
                  tagName="span"
                  placeholder={_x(
                    "Click to add a title",
                    "RichText label",
                    "nortic-plugin"
                  )}
                  value={title}
                  onChange={handleTitle}
                  style={{ color: color }}
                />
                {title && (
                  <i
                    class="sheet-icon bi bi-chevron-up ml-1"
                    style={{ color: color }}
                  ></i>
                )}
              </button>
            </div>
            <div
              className={`sheet-content ${display} ${
                display === "grid" ? `grid-cols-${columns}` : "items-center"
              }`}
            >
              <InnerBlocks orientation="vertical" />
            </div>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      title,
      color,
      background_color,
      anchor,
      transition_direction,
      display,
      columns,
    } = attributes;
    const blockProps = useBlockProps.save({
      className: "w-full",
      style: {
        backgroundColor: background_color,
      },
    });

    return (
      <>
        <div {...blockProps}>
          <div className={`sheet-content-container ${transition_direction}`}>
            <div
              className="sheet-trigger-container flex items-center justify-start"
              style={{ height: "40px" }}
            >
              <button className="sheet-trigger w-full flex items-center justify-between">
                <RichText.Content
                  tagName="span"
                  value={title}
                  style={{ color: color }}
                />
                {title && (
                  <i
                    class="sheet-icon bi bi-chevron-up ml-1 transition-all duration-200 ease-out"
                    style={{ color: color }}
                  ></i>
                )}
              </button>
            </div>
            <div
              style={{
                display: display,
                backgroundColor: background_color,
                maxHeight: "0",
              }}
              className={`sheet-content overflow-hidden transition-all duration-300 ease-in-out ${display} ${
                display === "grid" ? `grid-cols-${columns}` : "items-center"
              }`}
            >
              <InnerBlocks.Content />
            </div>
          </div>
        </div>
      </>
    );
  },
});
