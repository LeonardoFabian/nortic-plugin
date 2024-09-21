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
              min={2}
              max={6}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="modal-trigger-wrap">
            <a href="#">
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
            </a>
          </div>
          <div
            className="modal-content-wrap overlay"
            id={anchor}
            tabindex="-1"
            role="dialog"
          >
            <aside role="dialog" aria-hidden="true" className="modal-content">
              <InnerBlocks orientation="vertical" />
            </aside>
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
      style: {
        backgroundColor: background_color,
      },
    });

    return (
      <>
        <div {...blockProps}>
          <div className="modal-trigger-wrap">
            <a href={`${"#" + anchor}`}>
              <RichText.Content
                tagName="span"
                value={title}
                style={{ color: color }}
              />
            </a>
          </div>
          <div
            className={`modal-content-wrap overlay ${transition_direction}`}
            id={anchor}
            tabindex="-1"
            role="dialog"
          >
            <aside
              role="dialog"
              aria-hidden="true"
              style={{ display: display }}
              className={`modal-content ${display}`}
            >
              <InnerBlocks.Content />
            </aside>
          </div>
        </div>
      </>
    );
  },
});
